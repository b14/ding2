<?php
/**
 * @file
 * ding_serendipity.strongarm.inc
 */

/**
 * Implements hook_strongarm().
 */
function ding_serendipity_strongarm() {
  $export = array();

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_cache_lifetime';
  $strongarm->value = '600';
  $export['ding_serendipity_cache_lifetime'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_callbacks';
  $strongarm->value = array(
    'ding_entity_rating_materials_by_rating' => 'ding_entity_rating_materials_by_rating',
    'ding_serendipity_fallback_ting_object' => 'ding_serendipity_fallback_ting_object',
    'ding_serendipity_lists_ting_objects_adhr' => 'ding_serendipity_lists_ting_objects_adhr',
    'ding_serendipity_lists_ting_objects_adhl' => 'ding_serendipity_lists_ting_objects_adhl',
    'ding_serendipity_lists_frontpage_search' => 'ding_serendipity_lists_frontpage_search',
    'ding_serendipity_lists_loan_adhl' => 'ding_serendipity_lists_loan_adhl',
    'ding_serendipity_lists_author_from_lists' => 'ding_serendipity_lists_author_from_lists',
    'ding_serendipity_site_field_related_material' => 'ding_serendipity_site_field_related_material',
    'ding_serendipity_site_field_related_content' => 'ding_serendipity_site_field_related_content',
    'ding_serendipity_ting_entity_ting_object_author' => 'ding_serendipity_ting_entity_ting_object_author',
    'ding_serendipity_ting_entity_ting_object_subject' => 'ding_serendipity_ting_entity_ting_object_subject',
    'ding_serendipity_ting_entity_ting_object_type' => 'ding_serendipity_ting_entity_ting_object_type',
    'ding_serendipity_ting_entity_ting_object_adhl' => 'ding_serendipity_ting_entity_ting_object_adhl',
    'ding_serendipity_ting_entity_ting_object_adhr' => 'ding_serendipity_ting_entity_ting_object_adhr',
    'ding_serendipity_ting_entity_ting_object_openlist_adhl' => 'ding_serendipity_ting_entity_ting_object_openlist_adhl',
    'ding_entity_rating' => 0,
    'ding_serendipity_fallback' => 0,
    'ding_serendipity_lists' => 0,
    'ding_serendipity_site' => 0,
    'ding_serendipity_taxonomy_term' => 0,
    'ding_serendipity_taxonomy_term_recent' => 0,
    'ding_serendipity_taxonomy_term_related_by_term' => 0,
    'ding_serendipity_taxonomy_term_recommended_objects' => 0,
    'ding_serendipity_taxonomy_term_popular_objects' => 0,
    'ding_serendipity_ting_entity' => 0,
  );
  $export['ding_serendipity_callbacks'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_enable_cache';
  $strongarm->value = 0;
  $export['ding_serendipity_enable_cache'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_isslow_timeout';
  $strongarm->value = '10';
  $export['ding_serendipity_isslow_timeout'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_search_string_final';
  $strongarm->value = 'facet.type=bog';
  $export['ding_serendipity_search_string_final'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_search_string_final_description';
  $strongarm->value = 'The library recommends this';
  $export['ding_serendipity_search_string_final_description'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'ding_serendipity_weights';
  $strongarm->value = array(
    'ding_entity_rating_materials_by_rating' => '10',
    'ding_serendipity_fallback_ting_object' => '50',
    'ding_serendipity_lists_ting_objects_adhr' => '10',
    'ding_serendipity_lists_ting_objects_adhl' => '10',
    'ding_serendipity_lists_frontpage_search' => '10',
    'ding_serendipity_lists_loan_adhl' => '10',
    'ding_serendipity_lists_author_from_lists' => '10',
    'ding_serendipity_site_field_related_material' => '10',
    'ding_serendipity_site_field_related_content' => '10',
    'ding_serendipity_taxonomy_term_recent' => '10',
    'ding_serendipity_taxonomy_term_related_by_term' => '10',
    'ding_serendipity_taxonomy_term_recommended_objects' => '10',
    'ding_serendipity_taxonomy_term_popular_objects' => '10',
    'ding_serendipity_ting_entity_ting_object_author' => '10',
    'ding_serendipity_ting_entity_ting_object_subject' => '10',
    'ding_serendipity_ting_entity_ting_object_type' => '10',
    'ding_serendipity_ting_entity_ting_object_adhl' => '10',
    'ding_serendipity_ting_entity_ting_object_adhr' => '10',
    'ding_serendipity_ting_entity_ting_object_openlist_adhl' => '10',
  );
  $export['ding_serendipity_weights'] = $strongarm;

  return $export;
}
