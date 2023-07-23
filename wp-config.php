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
define('DB_NAME', 'puzzle');

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
define('AUTH_KEY',         'W_A3`~-9OZ!,vnU$ljkP;ght.,=}PC0_8WZ>|YC%Mzv?b#w|]}hD_m].1:#1Fn<Y');
define('SECURE_AUTH_KEY',  '3da>1nP@2,Zy$ PsP/X!XyU?:x&z6_/wmFz?,GbAT[gNd(w}%ZM&K~F:l|-COaMz');
define('LOGGED_IN_KEY',    'o;rw9P8?,{d;COrR}ZmGASq7v|&hmM4>%.|H&yT@K04WYK?1gz*_Cd%D<WUm}0/.');
define('NONCE_KEY',        'kyND,wIPP)=~C9p`En}^n`DS+o8{=4IIp]`SNEF;;Q3S<)19DKZYxNsQD,dMg<fq');
define('AUTH_SALT',        '>DJhaH,{Fd#W+EZLoa+kT{]=Ds^B|WZ<3kg^hyf9qe_Rw4#-rir:qo]+&b0s|(D#');
define('SECURE_AUTH_SALT', 'umw/).:DR)G`~PSF)N/*HpvWJ?}9a-O)}zPO&u6@)kL:8=39!C6>mwOG)QZzq(NU');
define('LOGGED_IN_SALT',   'B9oKar~1^cJ~YcqDL#%H0pESAG_aZ/OZsM3K(V[nf.y_^+[P8_+:vMHn[Gjk8M3[');
define('NONCE_SALT',       '(siw2O{k)@5EC2+qu:0H/@ip2{-&l0%598P_A,Hz+7z1t]L/!Cn`/d[M&BSH77xB');

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
