#!/bin/bash

# clear plugins to force new versions (excluding non-Wordpress plugin composer-libs/ )
# if you have other plugins that don't live in composer, you can add to the exclusion rule
shopt -s extglob
rm -rf ./wp-content/plugins/!(composer-libs)
# rm -rf ./wp-content/plugins/!(composer-libs|gravityforms*)

# copy everything over
cp -R ./composer/* ./

# remove unwanted defaults
rm -rf wp-content/plugins/akismet/
rm -rf wp-content/plugins/hello.php

# init files if they don't exist
mkdir -p wp-content/mu-plugins
cp -n _init/local-plugins.php wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
cp -n _init/gulpconfig.json gulpconfig.json 2>/dev/null || :
cp -n _init/local.sql _data/local.sql 2>/dev/null || :
cp -n _init/local-plugins.php wp-content/mu-plugins/local-plugins.php 2>/dev/null || :
mv _init/README.md README.md 2>/dev/null || :

# WP permissions
git config core.fileMode false
mkdir -p wp-content/uploads && chmod 777 wp-content/uploads
mkdir -p wp-content/themes/timber/acf-json && chmod -R 777 wp-content/themes/timber/acf-json
chmod +x _build/deploy.sh
