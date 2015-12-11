<?php
/**
 * @file
 * Set the base theme
 */

$enable = array(
  'theme_default' => 'bartik',
  'admin_theme' => 'seven',
);
theme_enable($enable);
foreach ($enable as $var => $theme) {
  if (!is_numeric($var)) {
    variable_set($var, $theme);
    if ($theme == $enable['theme_default']) {
      $settings =  variable_get('theme_'. $theme .'_settings');
      // Configure settings for theme.
      variable_set('theme_'. $theme .'_settings', $settings);
    }
  }
}

// Use the administration theme when editing or creating content.
variable_set('node_admin_theme', 1);
