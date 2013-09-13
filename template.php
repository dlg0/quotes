<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */


/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_maintenance_page(&$variables, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  quotes_preprocess_html($variables, $hook);
  quotes_preprocess_page($variables, $hook);
}
// */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_html(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // The body tag's classes are controlled by the $classes_array variable. To
  // remove a class from $classes_array, use array_diff().
  //$variables['classes_array'] = array_diff($variables['classes_array'], array('class-to-remove'));
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_page(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_node(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');

  // Optionally, run node-type-specific preprocess functions, like
  // quotes_preprocess_node_page() or quotes_preprocess_node_story().
  $function = __FUNCTION__ . '_' . $variables['node']->type;
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_comment(&$variables, $hook) {
  $variables['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the region templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_region(&$variables, $hook) {
  // Don't use Zen's region--sidebar.tpl.php template for sidebars.
  //if (strpos($variables['region'], 'sidebar_') === 0) {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('region__sidebar'));
  //}
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function quotes_preprocess_block(&$variables, $hook) {
  // Add a count to all the blocks in the region.
  // $variables['classes_array'][] = 'count-' . $variables['block_id'];

  // By default, Zen will use the block--no-wrapper.tpl.php for the main
  // content. This optional bit of code undoes that:
  //if ($variables['block_html_id'] == 'block-system-main') {
  //  $variables['theme_hook_suggestions'] = array_diff($variables['theme_hook_suggestions'], array('block__no_wrapper'));
  //}
}
// */
/**
 * Implements hook_preprocess_HOOK().
 *
 */
function quotes_preprocess_html(&$vars) {
  // Fixes page titles for login, register & password.
  switch (current_path()) {
    case 'user':
      $vars['head_title_array']['title'] = t('Login');
      $head_title = $vars['head_title_array'];
      $vars['head_title'] = implode(' | ', $head_title);
      break;
    case 'user/register':
      $vars['head_title_array']['title'] = t('Create new account');
      $head_title = $vars['head_title_array'];
      $vars['head_title'] = implode(' | ', $head_title);
      break;
    case 'user/password':
      $vars['head_title_array']['title'] = t('Request new password');
      $head_title = $vars['head_title_array'];
      $vars['head_title'] = implode(' | ', $head_title);
      break;
 
    default:
      break;
  }
}
 
/**
 * Implements hook_preprocess_HOOK().
 *
 */
function quotes_preprocess_page(&$vars) {
  /**
  * Removes the tabs from user  login, register & password. Also fixes page titles
  */
  switch (current_path()) {
    case 'user':
      $vars['title'] = t('Login');
      unset($vars['tabs']['#primary']);
      break;
    case 'user/register':
      $vars['title'] = t('Create new account');
      unset($vars['tabs']['#primary']);
      break;
    case 'user/password':
      $vars['title'] = t('Request new password');
      unset($vars['tabs']['#primary']);
      break;
 
    default:
      break;
  }
}
 
/**
* Implements hook_form_FORM_ID_alter()
*
**/
function quotes_form_user_login_alter(&$form, &$form_state, $form_id) {
  $pass_suffix = '<div class="request-new-password">';
  $pass_suffix .= l(t('Request new password'), 'user/password', array('attributes' => array('class' => 'dlg-login-password', 'title' => t('Get a new password'))));
  $pass_suffix .= '</div>';
  $form['pass']['#suffix'] = $pass_suffix;

  if (user_register_access()):
    $name_prefix = '<div class="create-new-account">';
    $name_prefix .= l(t('Create new account'), 'user/register', array('attributes' => array('class' => 'dlg-login-register', 'title' => t('Create a new user account'))));
    $name_prefix .= '</div>';
    $form['name']['#prefix'] = $name_prefix;
  endif;


}

function quotes_form_alter( &$form, &$form_state, $form_id )
{
    if (in_array( $form_id, array( 'user_login', 'user_login_block', 'user_pass')))
    {
        //kpr($form);
        $form['name']['#attributes']['placeholder'] = t( 'Username or Email' );
        $form['pass']['#attributes']['placeholder'] = t( 'Password' );
    }
    if (in_array( $form_id, array( 'user_register_form')))
    {
        //kpr($form);
        $form['account']['name']['#attributes']['placeholder'] = t( 'Username' );
        $form['account']['mail']['#attributes']['placeholder'] = t( 'Email' );
    }
}
