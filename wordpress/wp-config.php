<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// $onGae is true on production.
$onGae = isset($_SERVER['GAE_ENV']) ? true : false;


// Cache settings
// Disable cache for now, as this does not work on App Engine for PHP 7.2
define('WP_CACHE', false);

// Disable pseudo cron behavior
define('DISABLE_WP_CRON', true);

// Determine HTTP or HTTPS, then set WP_SITEURL and WP_HOME
$protocol_to_use = $onGae ? 'https://' : 'http://';

if (isset($_SERVER['HTTP_HOST'])) {
    define('HTTP_HOST', $_SERVER['HTTP_HOST']);
} else {
    define('HTTP_HOST', 'localhost');
}
define('WP_SITEURL', $protocol_to_use . HTTP_HOST);
define('WP_HOME', $protocol_to_use . HTTP_HOST);

// ** MySQL settings - You can get this info from your web host ** //
if ($onGae) {
    /** The name of the Cloud SQL database for WordPress */
    define('DB_NAME', 'wp_ellasasi');
    /** Production login info */
    define('DB_HOST', ':/cloudsql/sword-dev:us-central1:db-main');
    define('DB_USER', 'ellasasi_web_user');
    define('DB_PASSWORD', 'LuLEW&IM6d2ZH6');
} else {
    /** The name of the local database for WordPress */
    define('DB_NAME', 'wp_ellasasi');
    /** Local environment MySQL login info */
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'ellasasi_web_user');
    define('DB_PASSWORD', 'LuLEW&IM6d2ZH6');
}

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
define('AUTH_KEY',         'TfkuGr7vK/gF9o+NJb2Kin54Y7ExC9US4VhdLLAIgJIYK8yYJlOVTvDKKL/UOcNZ6RKrw82Nzjcz8uqR');
define('SECURE_AUTH_KEY',  'XycikD1saP569DXSvcNrtyqizvc/8hu24jFVjoFajgEIFTXKci5oLE3DZaSHaaI5kz8MNJDzlYP8eRGg');
define('LOGGED_IN_KEY',    'qJ2XeU/7/7sMcLhq+klYN3vVqSWsNIRzfBFuVadxiAnmGm5YGlBe2XMWyGq6LezTdlFXfUUnCVfPcDQn');
define('NONCE_KEY',        'EsKHRogz6+imSKuLUOZvuHHk+qoiwX06fxKbOSBafhn5jGHvHtCpMyXuTza14VxebYtOPmlXuztsID06');
define('AUTH_SALT',        'cOZriu5A5vFF4NmWzug9SZzC5KO0Y68ameKqWi4j7XK6RTbNR99nRwDJ3lLdPhgZzX0lumU/p3gHzp7o');
define('SECURE_AUTH_SALT', '1YAbDLuQ5BrbFSxnfhAQwStTUF5gr2R7LF4WST/WoaBOXGOc4AduxqbgkS+hJ9PLN6zXhhmCPtcMn+Pk');
define('LOGGED_IN_SALT',   'zPeEdrUW1ymsSy6RKhrU6N++K0tlrbFsKIEeZFeK39867jHY+mAzQexYFzwG/Qj6Mzv/AnDL3LeVqdds');
define('NONCE_SALT',       'xhqN/TxtVtECMNw13KFMB2D2d+L2lWhN5d2S53cgbDInxamOa9O7TL6Lg1sMnCkbmofKrDj0uSKN3JTK');

/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', !$onGae);

/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/wordpress/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
