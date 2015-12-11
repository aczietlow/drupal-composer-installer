#!/bin/bash

set -e
path=$(dirname "$0")
base=$(cd $path/.. && pwd)
drush="$base/bin/drush.php $drush_flags -y -r $base/www"
