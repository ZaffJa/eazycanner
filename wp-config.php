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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/eazycann/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'eazycann_web');
define('ALLOW_UNFILTERED_UPLOADS', true);


/** MySQL database username */
define('DB_USER', 'eazycann');

/** MySQL database password */
define('DB_PASSWORD', '3006YtfFsx');

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
define('AUTH_KEY',         '@{~gYvRXCJ?.V@{Jok1CM2VR{{Ohb^iYj-*_+6%IzGrDZ-UlI<HBsEEDLkkH;,%n');
define('SECURE_AUTH_KEY',  'sdsnp!a`7Idlx_pD}zilLkCh$/zLt5`n)Z{gc`p8@zi?.d$HVsSe|8HeTh#1<mCl');
define('LOGGED_IN_KEY',    '+8?6h~Ud+q8=4K=.T,*PJ:1#4oxpS]4_=N94%-#gcfh:W>dBidEm},L4m3M[NLjN');
define('NONCE_KEY',        'qY/yM2~z%os>|WU|r-p;.o|z}z,z/6izDexf7SAzcLRXHzi=Ak9<z%ItvqFF9a*.');
define('AUTH_SALT',        '>A[NsED5ZNY,Y1^@gK1kF${ i!+]h_aq/uJLrr>mixw?)b,o*,B-ef#[2jPDsLt@');
define('SECURE_AUTH_SALT', '#q[ur3Hb8kW5x6_1jk~gh({Ji LbS?BU$DE23,G:)#0r@2qJGv&(T*KJ< A6m(kS');
define('LOGGED_IN_SALT',   'EhXD#vTU-=Vs5V>xsc,1Rpa;bw` _:|RLVFqMmE_VeSvO14SE%tmF0(@TAls1ns(');
define('NONCE_SALT',       '#d;gdWCZ&*3]wEtO[fFmGHNv#aS].%;As@WVZd,aTruZY8B$%*M]q>OcbF{wA+0:');

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
