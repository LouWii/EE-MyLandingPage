<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once PATH_THIRD.'my_landing_page/helper.php';

class My_landing_page_mcp
{

  function index()
  {
    $settings = My_landing_page_helper::get_settings();

    $vars = array();
    $vars['page_title'] = $settings['landing_page_title'];
    $vars['page_content'] = $settings['landing_page_content'];

    ee()->view->cp_page_title = $settings['landing_page_title'];

    $vars['setting_page_url'] = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page'.AMP.'method=settings';

    return ee()->load->view('index', $vars, TRUE);
  }

  function settings()
  {
    ee()->view->cp_page_title = lang('settings');

    if (ee()->input->post('action') == 'save_settings')
    {
      $data = array (
        "landing_page_title" => ee()->input->post('landing_page_title'),
        "landing_page_content"  => ee()->input->post('landing_page_content'),
      );
      My_landing_page_helper::save_settings($data);

      ee()->session->set_flashdata('message_success', lang('settings_saved_desc'));
      ee()->functions->redirect(BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page'.AMP.'method=settings');
    }

    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=my_landing_page'.AMP.'method=settings';
    $vars['form_hidden'] = array('action' => 'add_email');

    $settings = My_landing_page_helper::get_settings();
    $vars['settings'] = $settings;

    return ee()->load->view('settings', $vars, TRUE);
  }
}
