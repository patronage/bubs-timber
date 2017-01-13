#!/usr/bin/env bash

# remove unneeded things from default WP, then copy out
rm -rf ../composer/wp-content/themes/twenty*
rm -rf ../composer/wp-config-sample.php
rm -rf ../composer/wp-content/plugins/hello.php
cp -R ../composer/* ../.

# conditionally create files from the init dir if they don't exist (first run only)
cp -n ../_init/wp-config-sample.php ../wp-config.php 2>/dev/null || :
cp -n ../_init/wp-config-local-sample.php ../wp-config-local.php 2>/dev/null || :
cp -n ../_init/gulpconfig.json ../gulpconfig.json 2>/dev/null || :
cp -n ../_init/local-plugi/ns.php ../wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
mv ../_init/README.md ../README.md 2>/dev/null || :
mv ../_init/post-merge ../.git/hooks/post-merge 2>/dev/null || :

# chmod tasks
mkdir -p ../wp-content/uploads && chmod 755 ../wp-content/uploads
mkdir -p ../wp-content/themes/timber/acf-json && chmod -R 755 ../wp-content/themes/timber/acf-json
chmod +x deploy.sh
chmod +x ../.git/hooks/post-merge
