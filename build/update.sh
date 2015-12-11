#!/bin/bash

set -e
path=$(dirname "$0")
source $path/common.sh

chmod -R +w $base/www/sites/default

echo "Enabling modules";
# Enable dependencies here
echo "Rebuilding registry and clearing caches.";
$drush cc drush
$drush rr
echo "Set default theme";
$drush scr $base/build/scripts/set_theme.php
echo "Set basic site variables";
$drush scr $base/build/scripts/set_site_variables.php
echo "Clearing caches one last time.";
$drush cc all