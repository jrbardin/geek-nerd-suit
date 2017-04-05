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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '5k1m506OSAMRa2qDObFfr4qdg9FbE2YDEaKaR3/bNm06eHmXfBNKcmoRO2Ryzf5KFk+0eSqzyGdPA/IFAR4fgg==');
define('SECURE_AUTH_KEY',  'YKnfccjCeMhvAkEaxVAbTy82ZvTQvsZwDJ6nngStCrnSSWZLUaB1OC6Op9VxJhAAV+5sk07OsAcf02xnTJfmIQ==');
define('LOGGED_IN_KEY',    'MACrkonrqsUTezdn1fXrVOrrXZndaTHqTNtLofPEC5lc7445yfLwgggLa2YOonq1abSuFK99igFjcRD8ZxlwhA==');
define('NONCE_KEY',        'Ex/Wo1Yavkm/tQmDtNyLVOLf1GLCZuV/3hrqiWfGrPXmwu6ytFGsLdPB0E81LkK8YQS3U47kMQGUFqcIeM3kCQ==');
define('AUTH_SALT',        'C6xk92zO/mWluE8YNkms3vgx07NqAxwQ86XnU7dIUxQVQwQhdbhVAFXlcdP9Xxwo0+AqylV7ZLqp1D8T88Eagg==');
define('SECURE_AUTH_SALT', '1fIVZ+qUFh97U79TWi84AI8UP1Tfz6ywZSKqb7+aunDp0pFN8/umXV4C6edrSyBMbbpe0zbDYrxKOyxk3Ny5fA==');
define('LOGGED_IN_SALT',   'uuN8kGojxxDlZED6hSZNoD6iUYeeFYITb6i9ytyc4Euxv7sZegMExb+s+srDcJbCUx9/TVjJ5I12Vaa22Qrf/A==');
define('NONCE_SALT',       'xat+wcys2RrVg4D47nFup4ArrqBo6k+7u6EYXYh79X4/9gC/A0bW3319YgtKgzL7nO5KNi0ipxa1pVRs4n2DWg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
