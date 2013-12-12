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
define('DB_NAME', 'blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '-O`oCO[bZ.biOp.DIBO9(V=sZmdz1K1c?)^A346Yp,*G,^o$jHuPZ Lb)0PYSzsC');
define('SECURE_AUTH_KEY',  'c(7]PJg!YsBPN)Fj&=G@%ww[/2teqezP6`qD_E5?_k:2>n1+~_UrmFZ/=Q+Wf$E ');
define('LOGGED_IN_KEY',    'nU AZ0R&~O_]4Qnl,kfx+yHE^q#6#2[Yo(3):~>r,/5JW]a]ki.R__F^*ylt1iez');
define('NONCE_KEY',        'qH/{hgs~|{bk(i6Ch3WI!8vV[sdwhD7C?U?K<P9 *c;l)hN$cM2X%~0<p7-}Kk<$');
define('AUTH_SALT',        'h{|d=x*SsI`w~)Ju(NE?Nh&Bsk5Zt[UMd)laB0xBZW|g%XDyCDr@8L;i^~Atu)O_');
define('SECURE_AUTH_SALT', 's+@Q6%1YIo_ax])f^Z.e?tzJ2.SEVKU4.X)]?LU-Y|#cI[4!0gL+-,nJ?8E(K.p#');
define('LOGGED_IN_SALT',   'qdBQ[^+6:=(6:2EjeMyA>Ap9fO*yKe$l3[5Q:% Wl}`lYu6^:iUPQs}qODzuqxmm');
define('NONCE_SALT',       'w1fQ,VGED}saSK>Zo.y[A+b[sj283=bGiju.Ah&Eye6ruIGETHnN>`;*`F0CsbRA');

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
