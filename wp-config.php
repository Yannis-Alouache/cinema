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
define('DB_NAME', 'cinema_bdd');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'jM9tspyEDC+$xdgc.6(!r&4=|}Qz2> )-s~avPSW[ZoP3N=;%YGk?Gmi(Na$fE71');
define('SECURE_AUTH_KEY',  ':iik)+]fxbdy6Bh:<_5aX$bM851AbDFtgQ_V|B!}{LA}p_TV*-PXuQb3/N7;QuHp');
define('LOGGED_IN_KEY',    '3quZ>3E&7(k*Z;V=gN]?3ryZYUTU}ovGYq^H17/ZF6t(*w]9a+#Ds<kCjEQJT3.f');
define('NONCE_KEY',        'wBn-6v.I`V9_:]TbVrdN$z,-cvO7>N4yDa:Z##|c&@+B9-$Ri&y22nn.2KZ9 6of');
define('AUTH_SALT',        'Gd4O!HR#7t-3?>}4~KF|2v@!5*,zqCug66 :1DZ*M^42uGtyt)bK<q|y_*NY:4R:');
define('SECURE_AUTH_SALT', 'SDaaR/)X$J54dcy+_-$`%a1U?QxN,wD 2Au3[{sbA8O!Llk2TsI@x^6728<37+1r');
define('LOGGED_IN_SALT',   'p8z*%Gt?Y8hPUS~LQ*:/cMq!B@wH@CF-+Q6tsNRJZIpcX2H-~qE7_}/Y,@=2+RI^');
define('NONCE_SALT',       ')Npe1(QT=F=>?(>#t>#Fa# j!.Ue%zuc(NShZ<XY>O]R11rwsi{@gndnE?.Bt*Vk');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
