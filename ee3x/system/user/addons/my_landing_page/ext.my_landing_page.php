<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'my_landing_page/helper.php';

class My_landing_page_ext
{

  var $name           = 'My Landing Page';
  var $version        = '1.0';
  var $description    = 'Create a custom landing page after logging in in  EE CP.';
  var $settings_exist = 'n';
  var $docs_url       = ''; // 'https://ellislab.com/expressionengine/user-guide/';

  var $settings       = array();

  /**
   * Constructor
   *
   * @param   mixed   Settings array or empty string if none exist.
   */
  function __construct($settings = '')
  {
      $this->settings = $settings;
  }

  function activate_extension()
  {
    $this->settings = array(

    );

    $data = array(
      'class'     => __CLASS__,
      'method'    => 'show_landing_page',
      'hook'      => 'cp_member_login',
      'settings'  => serialize($this->settings),
      'priority'  => 10,
      'version'   => $this->version,
      'enabled'   => 'y'
    );

    ee()->db->insert('extensions', $data);
  }

  function update_extension($current = '')
  {
    if ($current == '' OR $current == $this->version)
    {
        return FALSE;
    }

    if ($current < '1.0')
    {
      // Update to version 1.0
    }

    ee()->db->where('class', __CLASS__);
    ee()->db->update(
      'extensions',
      array('version' => $this->version)
    );
  }

  function disable_extension()
  {
    ee()->db->where('class', __CLASS__);
    ee()->db->delete('extensions');
  }

  function show_landing_page($hook_data)
  {
    if ($hook_data->can_access_cp)
    {
      ee()->functions->redirect(ee('CP/URL')->make('addons/settings/my_landing_page'));
    }
  }
}
