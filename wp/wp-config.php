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
define('DB_NAME', 'k0155809_wp114');

/** MySQL database username */
define('DB_USER', 'k0155809_wp114');

/** MySQL database password */
define('DB_PASSWORD', '!bN2pk!7S5');

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
define('AUTH_KEY',         'sruqfncujx7gg3wstpj7dvkraufca28oohcpmi6nld5xkescytt95gope6m4pt8j');
define('SECURE_AUTH_KEY',  'i7rr5c27say9xkq8rjv8vdydlh49ue2rhbpmq8wvaep79twqn6zqnvkx8zb3m7i6');
define('LOGGED_IN_KEY',    'rtbeji6hweujbkz46ksdvqmc3peazzoyck1kw1suwz1paj32c1ditgwjmq19gzbi');
define('NONCE_KEY',        '2wsifwwjjomd2n0iew9tivst9vr2blwh29jcgzntgqs7szpkhcnhqgbnlc5ovitt');
define('AUTH_SALT',        'k3o6kuavm5uh1w7btdhmhqpra8kr8pkncabara1ikklzkqo2ppvtxe0a3fsszgws');
define('SECURE_AUTH_SALT', 'uyw8jrgu5a1zneaqmebfmblk68mhz8j6gbtg6qvalyknacqgn16ug9fd9q0gkwe7');
define('LOGGED_IN_SALT',   'yk2dzdf8w3rici8lgjnuqf6q7rebjtwtmlfbvxlq8i5s8wqldthb52ezjogmc79e');
define('NONCE_SALT',       'cu5q18oojcjmf2xafua8xwyverpdaxfcipmcpobbyamvszjpcv2kbcdx4ssrjiho');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp53_';

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
