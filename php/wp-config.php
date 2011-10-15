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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $_ENV['OPENSHIFT_APP_NAME']);

/** MySQL database username */
define('DB_USER', $_ENV['OPENSHIFT_DB_USERNAME']);

/** MySQL database password */
define('DB_PASSWORD', $_ENV['OPENSHIFT_DB_PASSWORD']);

/** MySQL hostname */
define('DB_HOST', $_ENV['OPENSHIFT_DB_HOST']);

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
define('AUTH_KEY',         'a6-(D_Jw_d[J^0y/N3T=vHeo]k.WI},[9hCyT#bMj(*V,a!G-.<(#WiHrBR+;dRy');
define('SECURE_AUTH_KEY',  'T8ybU6zVkHa{K}5 4@_j|)VK{Q8:D]~6Ix5M7y.uB?r|CanxzNT%y4$[W-m; !U7');
define('LOGGED_IN_KEY',    'zs_{o.#p;8x1%ECk q_30lx>zVAyliwd2|nvNKu,Vf>dMh(0=+9y$J7{v+vst5ha');
define('NONCE_KEY',        '%TR48r@oJYyA/a6t^|SQ/YjJ:O.BOX1Go]$j=oi24V(K`X9D71=X-!;j9b-)Hjd>');
define('AUTH_SALT',        '!h?!}MP?G)o!v9l<$;#P(5gMd|/#-@+|SLm<`D:II;I.gTwLe$&ZSu}$4P&?6hs]');
define('SECURE_AUTH_SALT', 'e^o+I(B~-c|p!Ot#j$[Fa)m2nX5)`KM2~:V0[Kh(fk*4SNi(>-9[zX/6|$G*Kg?b');
define('LOGGED_IN_SALT',   'Y1!s/Nf_#F4F-~-{#@J4Id;VDH)1q,|&3$+5]NAEJPCG4nD_:eZ[Z_0YV _%}{=G');
define('NONCE_SALT',       'D07L}-KRA=61d,ZD?(8te.=+n^3Ue<Oex7f=&IG-*E-=NbOD@E9B5z|mqODy|KV?');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
