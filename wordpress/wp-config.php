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
    define('DB_HOST', '127.0.0.1:3305');
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
define('AUTH_KEY',         'UgjetDGrt0msCOXCPvUJjLqLhZ3Nx54JKj/2fA8Zb3KqouTzzH8piK7g/jYgjXOVkfwfMmmCCtmWLR9j');
define('SECURE_AUTH_KEY',  'fGPqldvQ+W/5f8Ky6lOhp0wOyxHTirAnaQX1XjfA6lrVmo/D7PaUSBB50ed7DhFFKijSvP6tMEByb6ue');
define('LOGGED_IN_KEY',    'oJjw5C+jbuPc0Mkowc7vogIJdz2roZ6CpOcS0GEABYG6s5XI/+kEJdHslkLFBLWHBYzXkCg/HhmNqRia');
define('NONCE_KEY',        'u40iZIauGdHxFiXvIweQemWljlskRpvA+VW4W5Okekso/AfcVB9QI4wct16u+7IdL3oguJDeVDcY0Lsc');
define('AUTH_SALT',        'rfLRLd7Tb0PHVb3xvI0hygzPG4azmHHVqgnHeZSiZr91SrnkiKwYkcrE5MQVTzfFvV4BJVEaUSstosl6');
define('SECURE_AUTH_SALT', 'vC9IdtXgMBLVLm92CHI8crXhVA11Vo8iNaSFTGRWNp5J/cxTsBU3BkK1jCYfYgaMg1ypy2NXiwq3lPYm');
define('LOGGED_IN_SALT',   'syPx/lWrO1Sdl65XRSAxp4AWxokzOnaU9U4wYHRmFuPLWXZu+fyeGowdRC3sa9tv401Hv5Yc5b4tDDnv');
define('NONCE_SALT',       'Syst0TFKAH+JIG7U07rCDyRx7kaaj3nhfffMaZO/SEuCM3+QjASWrb/J5K1Rtt8zMMiY8uGyfjqSHUs2');

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
