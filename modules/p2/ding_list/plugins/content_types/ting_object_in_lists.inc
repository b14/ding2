<?php

/**
 * @file
 * Ting objects appear in lists.
 */

$plugin = array(
  'title' => t('TingObject in lists'),
  'single' => TRUE,
  'required context' => new ctools_context_required(t('Ting object'), 'ting_object'),
  'category' => t('Ding!'),
);

/**
 * Implements hook_content_type_render().
 */
function ding_list_ting_object_in_lists_content_type_render($subtype, $conf, $panel_args, $context) {
  $block = new stdClass();
  $ting_obj = $context->data;

  try {
    $openlist_items = ding_provider_invoke('openlist', 'call_module', 'TingQuery', 'getPublicLists', array(
      $ting_obj->ding_entity_id
    ));

    if (!empty($openlist_items)) {
      $lists = ding_list_load_list_by_openlist_ids($openlist_items);
      // $block->content = array();
      $block->content = entity_view('ding_type', $lists, 'reference');
    }
  }
  catch (Exception $e) {
    watchdog_exception('ding_entity_rating', $e);
  }

  return $block;
}

/**
 * Implements hook_content_type_edit_form().
 */
function ding_list_ting_object_in_lists_content_type_edit_form($form, &$form_state) {
  return $form;
}
