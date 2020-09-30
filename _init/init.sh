#!/bin/bash

# clear plugins to force new versions (excluding non-Wordpress plugin composer-libs/ )
shopt -s extglob
rm -rf ./wp-content/plugins/!(composer-libs)

# Clean composer before copying . roots/wordpress installs the wordpress core into wp/ . Update wordpress
rm -rf ./composer/wp/wp-config-sample.php
rm -rf ./composer/wp/wp-content/
mv -n ./composer/wp/* ./composer
rm -rf ./composer/wp/


cp -R ./composer/* ./

cp -n _init/wp-config-sample.php wp-config.php 2>/dev/null || :
cp -n _init/wp-config-local-sample.php wp-config-local.php 2>/dev/null || :
cp -n _init/gulpconfig.json gulpconfig.json 2>/dev/null || :
cp -n _init/local.sql _data/local.sql 2>/dev/null || :
cp -n _init/local-plugins.php wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
mv _init/README.md README.md 2>/dev/null || :

mkdir -p wp-content/uploads && chmod 777 wp-content/uploads
mkdir -p wp-content/themes/timber/acf-json && chmod -R 777 wp-content/themes/timber/acf-json
chmod +x _build/deploy.sh
