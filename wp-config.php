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
define('DB_NAME', 'phuotblog');

/** MySQL database username */
define('DB_USER', 'hungphongbk');

/** MySQL database password */
define('DB_PASSWORD', 'Hungphong1812');

/** MySQL hostname */
define('DB_HOST', 'ulibi.cwvkylm2lmvh.ap-southeast-1.rds.amazonaws.com');

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
define('AUTH_KEY', '_$(Wsm-ln3?`Kf2UUCEg7i6Dw}.W>eX;S+s+Oc}^HGaTEWhjA(+{M3~UDF90r-&4');
define('SECURE_AUTH_KEY', '7MI.Cvam413sRkjnHIrRAS]6iuWRjIsM$9)F-a+]wf7w(u*-%l<->:RVEa;~xm]#');
define('LOGGED_IN_KEY', 'y8j H+*:5Y^hs ROl.cMV_/cM[X|VkYg.BwL*a7_t@+L-jf*+/91Es_G(Bs.C7*[');
define('NONCE_KEY', 'o7OYDSMjj1xl@n(rwXdUva%n%HmJF+@] `_Tu-Ymf/S5P$(ZD$/R]5+O|xJ,|/UE');
define('AUTH_SALT', 'luq<qYoMkF,Cfu*!0[{(ko*-{33Xt9<~G~v1yw+R3.wk}+t{QF2|h^(Gy7lWFHaR');
define('SECURE_AUTH_SALT', 'sGkzbxsUh-P+Vl+yi f$elIvpV14H*|rX!X-xl8qN_iz;dV45Hl1v$#p%zpD{>%q');
define('LOGGED_IN_SALT', '!1VpK[NUP>hFd+@#l:+lkq~ 89iiiT!72}+6nWg$-|):@0%%hXRIP[J_t$+jVk]*');
define('NONCE_SALT', 'bYs<91TP&l/!(igsP=e*}7X&@). iITY%,(<z)d_F9vHz@6=7|x l|?O<VMy-|Tr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define('WP_DEBUG', true);

define('WP_CACHE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
