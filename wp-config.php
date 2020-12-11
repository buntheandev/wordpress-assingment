<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'w~0x5<;PUS}Nw^C7cbZ+|()$bl&Y|3>[WI~#lvb Z:0cv_CIhzvP{~ |:S2zz93Y' );
define( 'SECURE_AUTH_KEY',  'RDloD u>H/$<gf;{]>)l oxZDsRNKK{<B+CTVW08W/OFK/Qe/!1xnW%[M*L!vJ/.' );
define( 'LOGGED_IN_KEY',    ')]$,koS43Xq{<uc}=eF2#nLt-a^i+8HL^RES.+%Eh#yb&-v#CZ/Wt>]RaN`G>N%_' );
define( 'NONCE_KEY',        '#%)RK=KhUVizo`acLmHZu:<C}1T9bYMUtMpY~lwbmiUft|DmS+@[?})FHstk1eq6' );
define( 'AUTH_SALT',        ';<Anu3nK?h(MDQHHl:r1.|jK1a2%l_A.x^Rqz3SH%*L;JlBS2i*WNHP  zat3)-Y' );
define( 'SECURE_AUTH_SALT', 'n+:R)/3Q%pJv~i[jC:~OG>MLtc{qZs,_KCJvNEH+_a?He@lAPtKWIVGoQ>,~OPk=' );
define( 'LOGGED_IN_SALT',   'xyBBH(<I#oyaYRs3:<3$L~gsjM{D;,)Skl|+o9swc0s9obPrqG6MF-i~1`br,fc{' );
define( 'NONCE_SALT',       'oka?JW;I)fEUz~wKN,!6;=MGL(l=GM+m4&>uwD~=Ts^ir3EA)G0rx a4D&~E.+L=' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
