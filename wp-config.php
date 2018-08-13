<?php


























/*a4bc0*/



/*a4bc0*/
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
/*define('WP_HOME', 'http://dijivu.com');
define('WP_SITEURL', 'http://dijivu.com');*/
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dijivu_staging');

/** MySQL database username */
define('DB_USER', 'dijivu_admin');

/** MySQL database password */
define('DB_PASSWORD', 'Ud#@Gc3FnU+k');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'L#jt~J+u{Xy9+HL+N3S+c;~GQ#VA+!8@oKs0sWq|_}/Fpizb-4%[i5Z7VgNY&r~4');
define('SECURE_AUTH_KEY',  'alsbUVP#X.S0&GpE,V-~^Y2ERFUMf#z^U;UaCb+:6,w/} U`0#i72} 5E>TOr_@!');
define('LOGGED_IN_KEY',    'r(*}c[x?qEyWi|$-5;VUJ>~@(Y/TQ$}Qk+)RV5$sThfFq55qgS[O`+0~eqmPrZAp');
define('NONCE_KEY',        '<~?>B>xvyXjkL3FtGWfL8ruQLqVZr-7jA*no=d^2PuuJ)=> I2%vK;e4~:eJ2@#P');
define('AUTH_SALT',        'iPY}mo?[ew!n.QNv`<#-W.m=f7 :jzp+%/;%5~zP~OF93OX|iy+9-$FXqFFV:0o:');
define('SECURE_AUTH_SALT', 'j=kR,obi-lb<|[M&;F+(Gv/()an+*_{:m4B;>U]1=Y8uL`aLQ(<`di{`cucGOMN^');
define('LOGGED_IN_SALT',   '(`q|_x51@f>-kLO Ub^D&>29|7rh76,.V:3n(.=NJ-JD_BYW=c0qFn#Hl}88+#gr');
define('NONCE_SALT',       ',_kh].nvD2:EK7&&}7g|E)CLW8]B [m+v;AY1 {/wNSc8ZS3`=WY)i+[#pEhUUX8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pubhtml_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '1024M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


define('WP_MEMORY_LIMIT', '128M');
