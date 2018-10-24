<?php

define('WP_CACHE', true);
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
define( 'WPCACHEHOME', '/home/k0155809/public_html/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'k0155809_wp148');
/** MySQL database username */
define('DB_USER', 'k0155809_wp148');
/** MySQL database password */
define('DB_PASSWORD', 'sMS[p7291.');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('WP_MEMORY_LIMIT', '256M');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'd0evvc6n7texgbo9drlatovpzyqwhcv82mgovpm1xnxwqintkvcr0kc36bjkqedv');
define('SECURE_AUTH_KEY',  'ofcwvglchux6zphjplq0rjlvqskkwpatnzks8dndd32ytwmqvunsskvlplocgyje');
define('LOGGED_IN_KEY',    'ual0h5zil759hlhpneov2qpinrdhlbfes1ojqnhwn3xjnyklwqh4soqfojodvdei');
define('NONCE_KEY',        'f61cx96uziceb30jjf7nvzewzbufoxbcohr9uz4bczgndc3teeklbvy1dumikpji');
define('AUTH_SALT',        'ajx28ksedco5fbeoryuab4syifamaaillphcwr3txkbq9qsskdkkemivb8q5jtdx');
define('SECURE_AUTH_SALT', 'fsbdbxdu3chlk6h9k2itg7i3na5ohsjqnp0kpbjppvcfwcdd1f9pql15axu444ht');
define('LOGGED_IN_SALT',   '2egqdvl4lsvfhrxqvmywypgt2kyi4t5gkxs9nyhli2c7u8gxpi0smuybnfhxmjya');
define('NONCE_SALT',       'bcc1v728nsis7jsxeh8sofvpwcwojwfjsi33h4h3v6jtlzyd8nsxsjma1zmdcrz3');
/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpfa_';
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