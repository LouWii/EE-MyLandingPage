<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'my_landing_page/helper.php';

class My_landing_page_upd
{
  var $version = '1.0';

  function install()
  {

    $data = array(
     'module_name' => 'My_landing_page' ,
     'module_version' => $this->version,
     'has_cp_backend' => 'y',
     'has_publish_fields' => 'y'
    );

    ee()->db->insert('modules', $data);

    ee()->load->dbforge();

    $fields = array(
      'setting_name'    => array('type' => 'VARCHAR', 'constraint' => '100'),
      'setting_value'   => array('type' => 'TEXT')
    );

    ee()->dbforge->add_field($fields);
    ee()->dbforge->add_key('setting_name', TRUE);

    ee()->dbforge->create_table('my_landing_page_settings');

    // Save default settings in our DB
    My_landing_page_helper::save_settings();

    return TRUE;
  }

  function update($current = '')
  {
    ee()->load->dbforge();

    if (version_compare($current, '0.1', '='))
    {
      return FALSE;
    }

    /*
    if (version_compare($current, '2.0', '<'))
    {
      // Do your update code here
    }
    */

    return TRUE;
  }

  function uninstall()
  {
    ee()->db->select('module_id');
    $query = ee()->db->get_where('modules', array('module_name' => 'My_landing_page'));

    ee()->db->where('module_id', $query->row('module_id'));
    ee()->db->delete('module_member_groups');

    ee()->db->where('module_id', $query->row('module_id'));
    ee()->db->delete('modules');

    ee()->load->dbforge();
    ee()->dbforge->drop_table('my_landing_page_settings');

    return TRUE;
  }

}
