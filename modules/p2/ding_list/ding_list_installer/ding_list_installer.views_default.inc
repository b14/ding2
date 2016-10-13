<?php
/**
 * @file
 * ding_list_installer.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function ding_list_installer_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'public_lists';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'eck_ding_type';
  $view->human_name = 'Public lists';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Public lists';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '10';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['pager']['options']['id'] = '0';
  $handler->display->display_options['pager']['options']['quantity'] = '9';
  $handler->display->display_options['pager']['options']['expose']['items_per_page_label'] = 'Antal elementer';
  $handler->display->display_options['pager']['options']['expose']['items_per_page_options_all_label'] = '- Alle -';
  $handler->display->display_options['pager']['options']['expose']['offset_label'] = 'Forskydning';
  $handler->display->display_options['pager']['options']['tags']['first'] = '« første';
  $handler->display->display_options['pager']['options']['tags']['previous'] = '‹ forrige';
  $handler->display->display_options['pager']['options']['tags']['next'] = 'næste ›';
  $handler->display->display_options['pager']['options']['tags']['last'] = 'sidste »';
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['row_plugin'] = 'entity';
  $handler->display->display_options['row_options']['view_mode'] = 'carousel';
  /* Field: Ding_type: Id */
  $handler->display->display_options['fields']['id']['id'] = 'id';
  $handler->display->display_options['fields']['id']['table'] = 'eck_ding_type';
  $handler->display->display_options['fields']['id']['field'] = 'id';
  /* Sort criterion: Ding_type: Id */
  $handler->display->display_options['sorts']['id']['id'] = 'id';
  $handler->display->display_options['sorts']['id']['table'] = 'eck_ding_type';
  $handler->display->display_options['sorts']['id']['field'] = 'id';
  $handler->display->display_options['sorts']['id']['order'] = 'DESC';
  /* Filter criterion: Ding_type: ding_type type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'eck_ding_type';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'ding_list' => 'ding_list',
  );
  /* Filter criterion: ding_type: Ding List Status (field_ding_list_status) */
  $handler->display->display_options['filters']['field_ding_list_status_value']['id'] = 'field_ding_list_status_value';
  $handler->display->display_options['filters']['field_ding_list_status_value']['table'] = 'field_data_field_ding_list_status';
  $handler->display->display_options['filters']['field_ding_list_status_value']['field'] = 'field_ding_list_status_value';
  $handler->display->display_options['filters']['field_ding_list_status_value']['value'] = array(
    'public' => 'public',
  );
  /* Filter criterion: ding_type: Type (field_list_type) */
  $handler->display->display_options['filters']['field_list_type_value']['id'] = 'field_list_type_value';
  $handler->display->display_options['filters']['field_list_type_value']['table'] = 'field_data_field_list_type';
  $handler->display->display_options['filters']['field_list_type_value']['field'] = 'field_list_type_value';
  $handler->display->display_options['filters']['field_list_type_value']['value'] = 'user_list';

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['path'] = 'public-lists';
  $translatables['public_lists'] = array(
    t('Master'),
    t('Public lists'),
    t('more'),
    t('Apply'),
    t('Reset'),
    t('Sort by'),
    t('Asc'),
    t('Desc'),
    t('Antal elementer'),
    t('- Alle -'),
    t('Forskydning'),
    t('« første'),
    t('‹ forrige'),
    t('næste ›'),
    t('sidste »'),
    t('Id'),
    t('.'),
    t(','),
    t('Page'),
  );
  $export['public_lists'] = $view;

  return $export;
}
