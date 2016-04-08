<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?=form_open($action_url, '', $form_hidden)?>
<input type="hidden" name="action" value="save_settings" />
<table class="mainTable padTable" border="0" cellspacing="0" cellpadding="0">
  <thead>
    <tr class="even">
      <th style="width:50%;" class="">Preference</th><th>Setting</th>
    </tr>
  </thead>
  <tbody>
    <tr class="<?php echo alternator('even', 'odd');?>">
      <td>
        <strong><label for="enabled"><?=lang('landing_page_title')?></label></strong>
        <div class="subtext"><?=lang('landing_page_title_desc')?></div>
      </td>
      <td>
        <input type="text" name="landing_page_title" id="landing_page_title" value="<?=$settings['landing_page_title']?>">&nbsp;
      </td>
    </tr>
    <tr class="<?php echo alternator('even', 'odd');?>">
      <td>
        <strong><label for="enabled"><?=lang('landing_page_content')?></label></strong>
        <div class="subtext"><?=lang('landing_page_content_desc')?></div>
      </td>
      <td>
        <textarea name="landing_page_content" id="landing_page_content" rows="8" cols="40"><?=$settings['landing_page_content']?></textarea>
      </td>
    </tr>
  </tbody>
</table>
<?=form_submit(array('name' => 'submit', 'value' => lang('settings_save'), 'class' => 'submit'))?>
<?=form_close()?>
