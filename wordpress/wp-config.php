<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'schoolmanagementsystem' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'yC{<A(*2ME+X$pFoHU`3AN$arJg&{OD/Ty<7]8h[m_+G&O&OivN1h[1+G3=by-~8' );
define( 'SECURE_AUTH_KEY',  '.!Ksn,02O1;Z&C.6D+8Z9.yEseqj+)|+{a,2banoQg:9:mx~l``F,1f%<uI._L.e' );
define( 'LOGGED_IN_KEY',    '|WQju]fi#?G:^KMJ?}V{C?1NahH+=]TU=`#F#%v!{&ZcSCwA^:ZlKAw{aB?h%7a8' );
define( 'NONCE_KEY',        'z,gqz: m)Op>VN_5ngdcfF,<~xP&]mp)<!9`U2tWb8+z&(ITo]9_:;fmP`[jo>,%' );
define( 'AUTH_SALT',        'H_tC82W~ik@@7u~|ZFj0_ykpOMw:?Qd`I*BO~?X#!~$4DMOnL[1}y4G(=Dz}]=5S' );
define( 'SECURE_AUTH_SALT', '6M>zO3%}h`(Wp.2sZFXv8aL8yy,ucaN-`keK1bt<#AyB+GD-OlN4Mz;/I>GfXds@' );
define( 'LOGGED_IN_SALT',   '3c*^g9yKE]xpe[fIR2G9JAl]Y #&hA/ LBf ,A_;/MwXmCAO?wuH6s|y3qWDd)$f' );
define( 'NONCE_SALT',       'JNgc{>(hqrKVf{</x=XAVL@QK!/[&FtN7%C?([}KUTfS)-rGtE9KWGcf]S,fCF&K' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
