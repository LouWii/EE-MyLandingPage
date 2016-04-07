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

    $vars['setting_page_url'] = ee('CP/URL')->make('addons/settings/my_landing_page/settings');

    return array(
      'heading'     => $vars['page_title'],
      'body'        => ee('View')->make('my_landing_page:index')->render($vars),
      // 'breadcrumb'  => array(
      //   ee('CP/URL')->make('addons/settings/module_name')->compile() => lang('module_name')
      // )
    );
  }

  function settings()
  {
    $settings = My_landing_page_helper::get_settings();

    $vars['sections'] = array(
      array(
        array(
          'title' => 'landing_page_title',
          'desc' => 'landing_page_title_desc',
          'fields' => array(
            'landing_page_title' => array(
              'type' => 'text',
              'value' => $settings['landing_page_title'],
            )
          )
        ),
        array(
          'title' => 'landing_page_content',
          'desc' => 'landing_page_content_desc',
          'fields' => array(
            'landing_page_content' => array(
              'type' => 'textarea',
              'value' => $settings['landing_page_content'],
            )
          )
        ),
        array(
          'title' => '',
          'fields' => array(
            'action' => array('type' => 'hidden', 'value' => 'save_settings')
          )
        ),
      )
    );

    if (ee()->input->post('action') == 'save_settings')
    {
      $fields = array();
        foreach ($vars['sections'] as $settings)
        {
          foreach ($settings as $setting)
          {
            foreach ($setting['fields'] as $field_name => $field)
            {
              $fields[$field_name] = ee()->input->post($field_name);
            }
          }
        }
        // We don't want to save that field, it's not a setting
        unset($fields['action']);
        My_landing_page_helper::save_settings($fields);

        ee('CP/Alert')->makeInline('shared-form')
          ->asSuccess()
          ->withTitle(lang('preferences_updated'))
          ->addToBody(lang('preferences_updated_desc'))
          ->defer();

        ee()->functions->redirect(ee('CP/URL', 'addons/settings/my_landing_page/settings')->compile());
    }

    // Final view variables we need to render the form
    $vars += array(
      'base_url' => ee('CP/URL', 'addons/settings/my_landing_page/settings'),
      'cp_page_title' => lang('general_settings'),
      'save_btn_text' => 'btn_save_settings',
      'save_btn_text_working' => 'btn_saving'
    );

    return array(
      'heading'     => lang('settings'),
      'body'        => ee('View')->make('my_landing_page:settings')->render($vars),
      'breadcrumb'  => array(
        ee('CP/URL')->make('addons/settings/my_landing_page')->compile() => lang('my_module_module_name')
      )
    );
  }
}
