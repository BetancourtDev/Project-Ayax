<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "projectayax_db" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define('AUTH_KEY',         '4dHGZ4ngidqNXh/4WPyRY+fMSqzv1212XGTihzH7o7jyJVKLu1op/h6vVkgZstBrTxw8/jQazsrQsrOAub7zUQ==');
define('SECURE_AUTH_KEY',  'CFtBgeAqtHEIEpM1JFWZbyjlByilUHZVZPwzkh+0lK8RsDmVdbYtVDu5S8e+2QrTzLSngkuShd/2pNiq8e4SSw==');
define('LOGGED_IN_KEY',    'P9Ih5IsMRRC0FtrlHqRgTUL4w+t967cdr6VUwrsDxp4QnHy0iV0SnB7eFr+UvBPjrvopoc38m/vPDE9yRcxmuw==');
define('NONCE_KEY',        'K3WFKWQpiOE4QrJB7gSXqaCbKQBLd5k4RncJBTCZVszVHxDqlD4DAePhTofyKRBVayUGzNhHXSqk9pOr4BTR5A==');
define('AUTH_SALT',        'I8yWGaHriIahXbYG1CueJgxxIBrgq2besBR69xLMW6syRbPD/OfdSPPhMWZLK9sjW+6tmoYVCx7sM2L9bp36Lw==');
define('SECURE_AUTH_SALT', 'LcDdPI9VJswgFvClTEEleO06Zc35+UyQBroxNoS+vA79gMLYDWvnMddlkONe4lSa6UTRdNIN12EPqQoHWK2Q/w==');
define('LOGGED_IN_SALT',   'cPe6Md9tab4L4udxRl/XIa8+gC8FBswh6japQSt2r5sGizdPadQ6SIPXASSu3Pa3rolbj47itfvmgTQw/C4zhA==');
define('NONCE_SALT',       'uC5ny2WesF6CeN9hCDjfFvHK+TJe5leCr1CqNC4yT75N0CUUfh8rnLDrjPdQ7sq3tuAgZBzhq97gxsDcovh6Bg==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'WP_SITEURL', 'http://localhost/project-ayax' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
