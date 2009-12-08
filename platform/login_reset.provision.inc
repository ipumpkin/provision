<?php
/**
 * @file
 *   Provision hooks for the provision login_reset command.
 */

/**
 * Provision login_reset command
 *
 * These are the hooks that will be executed by the drush_invoke function
 * when generating a one-time login reset URL.
 */

/**
 * Generate a one-time login reset url
 */
function drush_provision_drupal_provision_login_reset($url) {
  drush_bootstrap(DRUSH_BOOTSTRAP_DRUPAL_FULL);
  $account = user_load(1);
  $onetime = user_pass_reset_url($account);
  // pass the login link to the front end
  drush_set_option('login_link', $onetime);
  drush_log(t('Login url: !onetime', array('!onetime' => $onetime)), 'message');
  sess_destroy_uid(1);
}