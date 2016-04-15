<?php
# Database Configuration

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         ')*][ey$-&f(c^+nmfw3 XYe&XDq(%$9mA[iSt&Hc_x0[U,sr`c$DA7-~`!BtiyxL');
define('SECURE_AUTH_KEY',  'Up!|k!{3%Q-tSC>BdFE7Un//<nYFmyTDj6i$Al+uZ+A(Y/Oi#fh$#4aV~FEPq8yH');
define('LOGGED_IN_KEY',    'GK%%K{-bVI*VM}5xJ!>;M/V1*Zl{+?^qVSlU{{8L-ku/u,n+p;sC<LDH9S/elK.1');
define('NONCE_KEY',        'bq~L}`o`{`.:K f-9Kn4Nb{Fd@c@R-q/`j%Y;}~t%^nbk1$k:qqls JURJEzR~v5');
define('AUTH_SALT',        'R}-w?!+RKrZA6J7E.sjdR=[mJ(>*?J/y9(*|RlZ,k-Z10~.j;70+5#p1-Y@F3lb#');
define('SECURE_AUTH_SALT', ']2mXz[hq=ptS6%*5Sz%/Fp^m4eXkpiGo<>p*ALjhX35qxZbGd+YAX9pyI--x-6Zf');
define('LOGGED_IN_SALT',   '*T*d<~brmhkv$CZun`8mpCMV;LkX7k!x46cW)qn~0i4}Az|Lg<S!fZG|_r^2/C<p');
define('NONCE_SALT',       '.+C*/kWZKbfh=sN8s1uhV+:{e)@5yFDz3H]vE(Ky=EM@We)L(mn?z5VaoEBn1Fre');

if (file_exists(dirname(__FILE__) . '/wp-config-local.php')):
    # IMPORTANT: ensure your local config does not include wp-settings.php
    define('WP_LOCAL_DEV', true);
    require_once(dirname(__FILE__) . '/wp-config-local.php');

else:
    define('WP_DEBUG', false);
    # Production configs

endif;

# That's It. Pencils down
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
