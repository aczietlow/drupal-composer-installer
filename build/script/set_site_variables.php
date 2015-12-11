<?php
/**
 * @file
 * Set site variables.
 */

$enable = array(
  'site_frontpage' => 'home',
  'site_slogan' => "It goes to 11",
);
foreach ($enable as $var => $setting) {
  if (!is_numeric($var)) {
    // Set the site variables.
    variable_set($var, $setting);
  }
}

// Disable all unnecessary modules.
if (module_exists('block')) {
  module_disable(array('block'));
  drupal_uninstall_modules(array('block'));
}
