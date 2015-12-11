#!/bin/bash
set -e

path=$(dirname "$0")

source $path/common.sh

pushd $base/www
echo "Installing the Drupal."
$drush si minimal --site-name="drupal-ci" --account-pass=admin -y
source $path/update.php