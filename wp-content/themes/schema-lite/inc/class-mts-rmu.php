<?php
/**
 * Schema Theme - Rank Math notice.
 *
 * @package Schema
 */

define( 'RMU_PLUGIN_FILE', 'seo-by-rank-math/rank-math.php' );
define( 'RMU_PLUGIN_SLUG', 'seo-by-rank-math' );

$active_plugins = get_option( 'active_plugins' );
$rm_installed   = in_array( RMU_PLUGIN_FILE, $active_plugins, true );
define( 'RMU_INSTALLED', $rm_installed );

/**
 * Rank Math admin notice class.
 */
class MTS_RMU {

	/**
	 * Object instance.
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Current MTS RMU configuration.
	 *
	 * @var array
	 */
	public $config = array();

	/**
	 * Constructor.
	 *
	 * @param array $config MTS RMU config array.
	 */
	private function __construct( $config = array() ) {
		$config_defaults = array(

			'link_label_install'   => __( 'Try it for FREE!', 'schema-lite' ),
			'link_label_activate'  => __( 'Click here to activate it.', 'schema-lite' ),
			'add_dashboard_notice' => true,
			/* Translators: %s is CTA, e.g. "Try it now!" */
			'notice_install'       => sprintf( __( 'The new %1$s plugin will help you rank better in the search results.', 'schema-lite' ), '<a href="https://mythemeshop.com/plugins/wordpress-seo/?utm_source=SEO+Meta+Box&utm_medium=Link+CPC&utm_content=Rank+Math+SEO+LP&utm_campaign=UserBackend" target="_blank">Rank Math SEO</a>' ) . ' @CTA',
			/* Translators: %s is CTA, e.g. "Try it now!" */
			'notice_activate'      => sprintf( __( 'The %1$s plugin is installed but not activated.', 'schema-lite' ), '<a href="https://mythemeshop.com/plugins/wordpress-seo/?utm_source=SEO+Meta+Box&utm_medium=Link+CPC&utm_content=Rank+Math+SEO+LP&utm_campaign=UserBackend" target="_blank">Rank Math SEO</a>' ) . ' @CTA',

		);

		$this->config = $config_defaults;

		// Apply constructor config.
		$this->config( $config );

		$this->add_hooks();
	}

	/**
	 * Add WP hooks.
	 *
	 * @return void
	 */
	public function add_hooks() {

		// The rest doesn't need to run when RM is installed already
		// Or if user doesn't have the capability to install plugins.
		if ( RMU_INSTALLED || ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		add_action( 'wp_ajax_rmu_dismiss', array( $this, 'ajax_dismiss_notice' ) );

		if ( $this->get_setting( 'add_dashboard_notice' ) && ! $this->is_dismissed( 'main_notice' ) ) {
			add_action( 'admin_notices', array( $this, 'dashboard_notice_output' ) );
		}

	}

	/**
	 * Output admin notice content.
	 *
	 * @return void
	 */
	public function dashboard_notice_output() {
		?>
		<div class="notice notice-warning" id="rmu_dashboard_notice" style="position:relative;">
			<div class="rmu-dashboard-panel">
				<button class="rmu-dashboard-panel-close notice-dismiss" id="rmu-dashboard-dismiss"><span class="screen-reader-text"><?php echo esc_html( 'Dismiss this notice.', 'schema-lite' ); ?></span></button>
				<div class="rmu-dashboard-panel-content">
					<p>
					<?php
					$plugins      = array_keys( get_plugins() );
					$rm_installed = in_array( RMU_PLUGIN_FILE, $plugins, true );

					if ( $rm_installed ) {
						echo wp_kses_post( strtr( $this->get_setting( 'notice_activate' ), array( '@CTA' => $this->get_activate_link() ) ) );
					} else {
						echo wp_kses_post( strtr( $this->get_setting( 'notice_install' ), array( '@CTA' => $this->get_install_link() ) ) );
					}
					?>
					</p>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$( '#rmu-dashboard-dismiss' ).click(function(event) {
						event.preventDefault();
						$( '#rmu_dashboard_notice' ).slideUp();
						$.ajax({
								url: ajaxurl,
								type: 'GET',
								data: { action: 'rmu_dismiss', n: 'main_notice' },
						});
				});
			});
		</script>
		<?php
	}

	public static function init( $config = array() ) {
		if ( self::$instance === null ) {
			self::$instance = new MTS_RMU( $config );
		} else {
			self::$instance->config( $config );
		}

		return self::$instance;
	}

	/**
	 * Change single option in MTS RMU config array.
	 *
	 * @param  string $configuration Option.
	 * @param  mixed $value         New value.
	 * @return void
	 */
	public function config( $configuration, $value = null ) {
		if ( is_string( $configuration ) && $value !== null ) {
			$this->config[ $configuration ] = $value;
			return;
		}

		$this->config = array_merge( $this->config, $configuration );
	}

	/**
	 * Get single option value from MTS RMU config array.
	 *
	 * @param  string $setting Option name.
	 * @return mixed           Option value, or null if the option does not exist.
	 */
	public function get_setting( $setting ) {
		if ( isset( $this->config[ $setting ] ) ) {
			return $this->config[ $setting ];
		}
		return null;
	}

	/**
	 * Dismiss an admin notice.
	 *
	 * @param  string $notice Notice ID.
	 * @return void
	 */
	public function dismiss_notice( $notice ) {
		$current            = (array) get_user_meta( get_current_user_id(), 'rmu_dismiss', true );
		$current[ $notice ] = '1';
		update_user_meta( get_current_user_id(), 'rmu_dismiss', $current );
	}

	/**
	 * Check whether notice was dismissed before.
	 *
	 * @param  string $notice Notice ID.
	 * @return boolean         True if dismissed.
	 */
	public function is_dismissed( $notice ) {
		$current = (array) get_user_meta( get_current_user_id(), 'rmu_dismiss', true );
		return ( ! empty( $current[ $notice ] ) );
	}

	/**
	 * Dismiss admin notice AJAX handler.
	 *
	 * @return void
	 */
	public function ajax_dismiss_notice() {
		$notice = sanitize_title( wp_unslash( $_GET['n'] ) );
		$this->dismiss_notice( $notice );
		exit;
	}

	/**
	 * Create plugin install link HTML.
	 *
	 * @param  string $class Class name.
	 * @param  string $label Inner text.
	 * @return string        Link HTML.
	 */
	public function get_install_link( $class = '', $label = '' ) {
		if ( ! $label ) {
			$label = '<strong>' . $this->get_setting( 'link_label_install' ) . '</strong>';
		}
		$action       = 'install-plugin';
		$slug         = RMU_PLUGIN_SLUG;
		$install_link = add_query_arg(
			array(
				'tab'       => 'plugin-information',
				'plugin'    => $slug,
				'TB_iframe' => 'true',
				'width'     => '600',
				'height'    => '550',
			),
			admin_url( 'plugin-install.php' )
		);

		add_thickbox();
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );

		return '<a href="' . $install_link . '" class="thickbox ' . esc_attr( $class ) . '" title="' . esc_attr__( 'Rank Math SEO', 'schema-lite' ) . '">' . $label . '</a>';
	}

	/**
	 * Create plugin activation link HTML.
	 *
	 * @param  string $class Class name.
	 * @param  string $label Inner text.
	 * @return string        Link HTML.
	 */
	public function get_activate_link( $class = '', $label = '' ) {
		if ( ! $label ) {
			$label = '<strong>' . $this->get_setting( 'link_label_activate' ) . '</strong>';
		}
		$activate_link = wp_nonce_url( 'plugins.php?action=activate&plugin=' . rawurlencode( RMU_PLUGIN_FILE ), 'activate-plugin_' . RMU_PLUGIN_FILE );
		return '<a href="' . $activate_link . '" class="' . esc_attr( $class ) . '">' . $label . '</a>';
	}

	/**
	 * Get install or activation link based on plugin availability.
	 *
	 * @param  string $class          Class name.
	 * @param  string $label_install  Inner text for Install link.
	 * @param  string $label_activate Inner text for Activate link.
	 * @return string                 Link HTML.
	 */
	public function get_install_or_activate_link( $class = '', $label_install = '', $label_activate = '' ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$plugins      = array_keys( get_plugins() );
		$rm_installed = in_array( RMU_PLUGIN_FILE, $plugins, true );

		if ( ! $rm_installed ) {
			return $this->get_install_link( $class, $label_install );
		} else {
			return $this->get_activate_link( $class, $label_activate );
		}
	}

}

define( 'RMU_ACTIVE', true );
