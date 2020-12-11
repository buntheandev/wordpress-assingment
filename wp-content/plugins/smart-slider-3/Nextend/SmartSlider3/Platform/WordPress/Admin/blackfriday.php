<?php
$current = time();
if (mktime(0, 0, 0, 11, 27, 2020) <= $current && $current <= mktime(0, 0, 0, 12, 2, 2020)) {
    if (get_option('ss3_bf_2020') != '1') {

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_script('jquery');
        });

        add_action('admin_notices', function () {
            ?>
            <div class="notice notice-info is-dismissible" data-ss3dismissable="ss3_bf_2020">
                <h3>Smart Slider 3 Pro Black Friday Deal</h3>
                <p>Don't miss out our biggest sale of the year! Get your <b>Smart Slider 3 Pro</b> with <b>40%
                        OFF</b>! Limited time offer expires on December 2.</p>
                <p>
                    <a class="button button-primary" href="https://smartslider3.com/pricing/?coupon=SAVE4020&utm_source=wpfree&utm_medium=wp&utm_campaign=bf20" target="_blank">Buy
                        Now!</a>
                    <a class="button button-dismiss" href="#">Dismiss</a>
                </p>
            </div>
            <?php
        });

        add_action('admin_footer', function () {
            ?>
            <script type="text/javascript">
                (function ($) {
                    $(function () {
                        setTimeout(function () {
                            $('div[data-ss3dismissable] .notice-dismiss, div[data-ss3dismissable] .button-dismiss')
                                .on('click', function (e) {
                                    e.preventDefault();
                                    $.post(ajaxurl, {
                                        'action': 'ss3_dismiss_admin_notice',
                                        'nonce': <?php echo json_encode(wp_create_nonce('ss3-dismissible-notice')); ?>
                                    });
                                    $(e.target).closest('.is-dismissible').remove();
                                });
                        }, 1000);
                    });
                })(jQuery);
            </script>
            <?php
        });

        add_action('wp_ajax_ss3_dismiss_admin_notice', function () {
            check_ajax_referer('ss3-dismissible-notice', 'nonce');

            update_option('ss3_bf_2020', '1');
            wp_die();
        });
    }
}
