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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'db:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'h7!9xj--)Ny7y#Amo!2qfWMqX1Om>O$e.ez=$Qi<yz9Eugn&T*/AWzmH8zkUUis/' );
define( 'SECURE_AUTH_KEY',  'j{L7fz478q90%;?NQS.lCWKLr|E+_*7/{~T.g#2i<%9:Fv,&`n*CLW>=|6`0`Lcf' );
define( 'LOGGED_IN_KEY',    '9 1j*iZKhi}$r9jPx|l:1XkE6a>_+QjI,SO`?0)Uk+N%}s*N@5 qOLxr=?&1KvtA' );
define( 'NONCE_KEY',        ']`^%~Zc{+*~e?~Vp{?}k7S*(T!xCSqg>!2#GQONu^Dv89@LLRC}{uJ+T<[{@:Rju' );
define( 'AUTH_SALT',        'hza`VaciyuA$5>iIibK[7O_QxY6>7%N/iX9[&rX%3FN>l5*vD.j>?(HyWpGo`<0i' );
define( 'SECURE_AUTH_SALT', 'G^cikiOK/iD&24q1eolybIe47dWe|+4#(&l${f>:{#?ei6_rKRTZ9 N|y449 X^m' );
define( 'LOGGED_IN_SALT',   '>}bgjPVOP0fCb3-R]nTW-g<,!J>+~pYk$Pq~|C)R:E>XjtzXIW?1T@~hSk+bE (l' );
define( 'NONCE_SALT',       '^*kqc@?Ei 1A<U3c?rd/xufxXZ.zm%@z[6QJ+^wMM^&D*/)q*FtM07N%N!A*]&:l' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
