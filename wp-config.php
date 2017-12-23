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

define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\xampp\htdocs\mybooktravels.com\wp-content\plugins\wp-super-cache/' );
/*
define( 'WP_CACHE', true );
define( 'WPCACHEHOME', 'C:\xampp\htdocs\mybooktravels.com\wp-content\plugins\wp-super-cache/' );
*/
define('DB_NAME', 'mybooktravels');

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
define('AUTH_KEY',         'zhoulzpj3s2lxcpdq4nvfxg2nrew1ebc2kc7irv316rksub9zdn7zyabjzghnako');
define('SECURE_AUTH_KEY',  'p7u7v55yxpjpu06axpd6zikwbujim9fxmp5el5jjrccf3mkhqmk63aospextwhjt');
define('LOGGED_IN_KEY',    'du6msfsdbx8uxq1k4hf4bfpowfeszsfufpdpuslnakzyoexhyiphsjte4n7zdibb');
define('NONCE_KEY',        'c8zutihtam1sebdhbjvxseu7dgyysr2qqhrw5c6arypaimuh4d2sesqtbobd3npa');
define('AUTH_SALT',        '5vmh7hokw4vneyrs1nscfansnquuadecvaxyezcspdmtdtak9cufdqedlxrsvmdf');
define('SECURE_AUTH_SALT', 'u7rokdbz58tas9gil78hsfwsxvcixnpdsukpd7vxjc8mtht9ny0jawauqlj64czi');
define('LOGGED_IN_SALT',   'ltqzuteawtckjbfyqmb4xy5tebv9qkmh7ak2gkpv0rebw7exk2ladaaxwfoj9zfr');
define('NONCE_SALT',       'qova8rotuvbm5zuwdynqop9daf4hsvlyujpo59tzooryn7u51h0gqbhm3n7btgqp');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mbt_';

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
