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
    // echo BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page';
    if ($hook_data->can_access_cp)
    {
      // I can't believe we have to do all this crap :/
      // Fortunately, EE3 is doing WAY BETTER here !
      if (version_compare(APP_VER, '2.6.0', '<='))
      {
        ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page');
      }
      elseif (version_compare(APP_VER, '2.7.3', '<='))
      {
        $s = 0;
        if (ee()->config->item('admin_session_type') == 's')
        {
          $s = ee()->session->userdata('session_id', 0);
        }
        else if (ee()->config->item('admin_session_type') == 'cs')
        {
          $s = ee()->session->userdata('fingerprint', 0);
        }

        $base = SELF.'?S='.$s.'&amp;D=cp';
        ee()->functions->redirect($base.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page');
      }
      else
      {
        $s = 0;
        if (ee()->config->item('cp_session_type') == 's')
        {
          $s = ee()->session->userdata('session_id', 0);
        }
        else if (ee()->config->item('cp_session_type') == 'cs')
        {
          $s = ee()->session->userdata('fingerprint', 0);
        }

        $base = SELF.'?S='.$s.'&amp;D=cp';
        ee()->functions->redirect($base.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page');
      }
    }
  }
}
