<?php
//
// Wordpress Configuration (Development)
// These settings assist you when building your
// site locally. See readme in the root folder for more.
//

// Database Connection
define('DB_NAME', '');
define('DB_USER', 'root');
define('DB_PASSWORD', 'changeme');
define('DB_HOST', '127.0.0.1');

// Wordpress Settings
define('WP_DEBUG', true);
define('SAVEQUERIES', true);
define('FS_METHOD','direct'); // Force WP to use internal updater, not FTP.
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// Cache Settings
define('WP_CACHE_PERIOD', false);

// Custom
define('WP_ENV', 'development');
