<?php

require_once 'extrajs.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function extrajs_civicrm_config(&$config) {
  _extrajs_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function extrajs_civicrm_xmlMenu(&$files) {
  _extrajs_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function extrajs_civicrm_install() {
  _extrajs_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function extrajs_civicrm_uninstall() {
  _extrajs_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function extrajs_civicrm_enable() {
  _extrajs_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function extrajs_civicrm_disable() {
  _extrajs_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function extrajs_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _extrajs_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function extrajs_civicrm_managed(&$entities) {
  _extrajs_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function extrajs_civicrm_caseTypes(&$caseTypes) {
  _extrajs_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function extrajs_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _extrajs_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 */
/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function extrajs_civicrm_buildForm($formName, &$form) {
  $whiteList = array(
    'CRM_Contribute_Form_Contribution_Main',
    'CRM_Contribute_Form_Contribution_ThankYou',
  );
  if (!in_array($formName, $whiteList)) {
    // We don't have a strong reason for the whitelist approach
    // - only that this is in early stages
    return;
  }

  // We don't know the impact on performance of checking all template directories.
  // So we will check only the second to last - ie. the custom configured
  // directory, if it exists.
  $fileLocations = array_reverse(CRM_Core_Smarty::singleton()->template_dir);
  if (empty($fileLocations[1])) {
    return;
  }
  $id = $form->get('id') ? $form->get('id') : $form->_id;
  $domainID = 'Domain' . CRM_Core_Config::domainID();
  $formNameParts = explode('_', $formName);
  $fileName = array_pop($formNameParts);
  $filePath
    = CRM_Core_Config::singleton()->userSystem->cmsRootPath()
    . DIRECTORY_SEPARATOR
    . $fileLocations[1]
    . DIRECTORY_SEPARATOR
    . implode(DIRECTORY_SEPARATOR, $formNameParts);


  $fileNames = array(
    $filePath . DIRECTORY_SEPARATOR . $fileName . '.js',
    $filePath . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . $fileName . '.js',
    $filePath . DIRECTORY_SEPARATOR . $domainID . DIRECTORY_SEPARATOR . $fileName . '.js',
  );

  foreach ($fileNames as $fileName) {
    if (file_exists($fileName)) {
      CRM_Core_Resources::singleton()->addScript(file_get_contents($fileName));
    }
  }

}


