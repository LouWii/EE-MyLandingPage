<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_landing_page_helper
{
  private static $_settings;

  /**
   * Get add-on settings
   * @return [type] [description]
   */
  public static function get_settings()
  {
    // If already loaded, no need to get them from DB
    if (! isset(self::$_settings))
    {
      $settings = array();

      //Get the actual saved settings
      $query = ee()->db->get('my_landing_page_settings');

      foreach ($query->result_array() as $row)
      {
        $settings[$row["setting_name"]] = $row["setting_value"];
      }

      self::$_settings = array_merge(self::_get_default_settings(), $settings);
    }

    return self::$_settings;
  }

  public static function save_settings($settings = array())
  {
    //be sure to save all settings possible
    $_tmp_settings = array_merge(self::_get_default_settings(), $settings);

    foreach ($_tmp_settings as $setting_name => $setting_value)
    {
      $query = ee()->db->get_where('my_landing_page_settings', array('setting_name'=>$setting_name), 1, 0);
      if ($query->num_rows() == 0)
      {
        // A record does not exist, insert one.
        $query = ee()->db->insert('my_landing_page_settings', array('setting_name' => $setting_name, 'setting_value' => $setting_value));
      }
      else
      {
        // A record does exist, update it.
        $query = ee()->db->update('my_landing_page_settings', array('setting_value' => $setting_value), array('setting_name'=>$setting_name));
      }
    }

    self::$_settings = $_tmp_settings;
  }

  /**
   * Array of default settings of the add-on
   * @return [type] [description]
   */
  private static function _get_default_settings()
  {
    return array(
      'landing_page_title'     => '',
      'landing_page_content'   => '',
    );
  }
}
