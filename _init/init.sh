#!/bin/bash

# clear plugins to force new versions (excluding non-Wordpress plugin composer-libs/ )
# if you have other plugins that don't live in composer, you can add to the exclusion rule
shopt -s extglob
rm -rf ./wp-content/plugins/!(composer-libs)
# rm -rf ./wp-content/plugins/!(composer-libs|gravityforms*)

# clean composer before copying
# rm -rf ./composer/wp/wp-config-sample.php
# rm -rf ./composer/wp-content/plugins/hello.php
# rm -rf ./composer/wp/wp-content/
# mv -n ./composer/wp/* ./composer
# rm -rf ./composer/wp/

# copy everything over
cp -R ./composer/* ./

# init files if they don't exist
mkdir -p wp-content/mu-plugins
cp -n _init/local-plugins.php wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
cp -n _init/wp-config-sample.php wp-config.php 2>/dev/null || :
cp -n _init/wp-config-local-sample.php wp-config-local.php 2>/dev/null || :
cp -n _init/gulpconfig.json gulpconfig.json 2>/dev/null || :
cp -n _init/local.sql _data/local.sql 2>/dev/null || :
cp -n _init/local-plugins.php wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
mv _init/README.md README.md 2>/dev/null || :

# WP permissions
git config core.fileMode false
mkdir -p wp-content/uploads && chmod 777 wp-content/uploads
mkdir -p wp-content/themes/timber/acf-json && chmod -R 777 wp-content/themes/timber/acf-json
chmod +x _build/deploy.sh
