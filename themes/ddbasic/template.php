<?php
require_once __DIR__ . '/utils.inc';

require_once __DIR__ . '/template.block.php';
require_once __DIR__ . '/template.form.php';
require_once __DIR__ . '/template.node.php';
require_once __DIR__ . '/template.field.php';
require_once __DIR__ . '/template.opening_hours.php';
require_once __DIR__ . '/template.ctools_plugin.php';

/**
 * @file
 * Preprocess and Process Functions.
 */

// @TODO Remove unused code
// Includes frequently used theme functions that gets theme info, css files etc.
// @B14 outcommentet
//include_once drupal_get_path('theme', 'ddbasic') . '/inc/functions.inc';


/**
 * Implements hook_preprocess_html().
 */
function ddbasic_preprocess_html(&$vars) {
  global $language;

  // Setup iOS logo if it's set.
  $vars['ios_logo'] = theme_get_setting('iosicon_upload');

  // Set variable for the base path.
  $vars['base_path'] = base_path();

  // Clean up the lang attributes.
  $vars['html_attributes'] = 'lang="' . $language->language . '" dir="' . $language->dir . '"';

  // @TODO Remove unused code
  // Load ddbasic plugins.
  // @B14 outcommentet
  //ddbasic_load_plugins();

  // Add conditional CSS for IE8.
  // @B14 outcommentet
  //drupal_add_css(path_to_theme() . '/css/ddbasic.ie8.css', array(
  //  'group' => CSS_THEME,
  //  'browsers' => array(
  //    'IE' => 'lte IE 8',
  //    '!IE' => FALSE,
  //  ),
  //  'weight' => 999,
  //  'preprocess' => FALSE,
  //));

  // Add conditional CSS for IE9.
  // @B14 outcommentet
  //drupal_add_css(path_to_theme() . '/css/ddbasic.ie9.css', array(
  //  'group' => CSS_THEME,
  //  'browsers' => array(
  //    'IE' => 'lte IE 9',
  //    '!IE' => FALSE,
  //  ),
  //  'weight' => 999,
  //  'preprocess' => FALSE,
  //));

  // Add additional body classes
  $vars['classes_array'] = array_merge($vars['classes_array'], ddbasic_body_class());

  if (variable_get('ting_search_extend_form', FALSE)) {
    $vars['classes_array'][] = 'search-form-extended';
    if (!ding_ddbasic_is_search_form_extended()) {
      $vars['classes_array'][] = 'search-form-no-materials';
    }
  }

}

/**
 * Implements hook_process_html().
 *
 * Process variables for html.tpl.php
 */
function ddbasic_process_html(&$vars) {
  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$vars['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    $section = explode('/', $path);
    $section = array_shift($section);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node' && isset($arg[1])) {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $vars['classes_array'][] = drupal_html_class('section-' . $section);
  }
  // Store the menu item since it has some useful information.
  $vars['menu_item'] = menu_get_item();
  if ($vars['menu_item']) {
    switch ($vars['menu_item']['page_callback']) {
      case 'views_page':
        // Is this a Views page?
        $vars['classes_array'][] = 'page-views';
        break;

      case 'page_manager_page_execute':
      case 'page_manager_node_view':
      case 'page_manager_contact_site':
        // Is this a Panels page?
        $vars['classes_array'][] = 'page-panels';
        break;
    }
  }
// @TODO Remove unused code
  // Color module.
  // Hook into color.module.
  // @B14 outcommentet
  //if (module_exists('color')) {
  //  _color_html_alter($vars);
  //}

}


/**
 * Implements hook_preprocess_panels_pane().
 */
function ddbasic_preprocess_panels_pane(&$vars) {

  // Suggestions base on sub-type.
  $vars['theme_hook_suggestions'][] = 'panels_pane__' . str_replace('-', '__', $vars['pane']->subtype);
  $vars['theme_hook_suggestions'][] = 'panels_pane__'  . $vars['pane']->panel . '__' . str_replace('-', '__', $vars['pane']->subtype);

  if (isset($vars['content'])) {
    if (isset($vars['content']['profile_ding_staff_profile']['#title']) && $vars['content']['profile_ding_staff_profile']['#title'] == 'Staff') {
      $vars['theme_hook_suggestions'][] = 'panels_pane__user_profile_staff';
    }
  }

  // Suggestions on panel pane.
  $vars['theme_hook_suggestions'][] = 'panels_pane__' . $vars['pane']->panel;

  // Suggestion for mobile user menu in the header.
  if ($vars['pane']->panel == 'header' && $vars['pane']->subtype == 'user_menu') {
    $vars['theme_hook_suggestions'] = array('panels_pane__sub_menu__mobile');
  }

  // Suggestions on menus panes.
  if ($vars['pane']->subtype == 'og_menu-og_single_menu_block' || $vars['pane']->subtype == 'menu_block-3') {
    $vars['theme_hook_suggestions'][] = 'panels_pane__sub_menu';
    $vars['classes_array'][] = 'sub-menu-wrapper';

    // Change the theme wrapper for both menu-block and OG menu.
    if (isset($vars['content']['#content'])) {
      // Menu-block.
      $vars['content']['#content']['#theme_wrappers'] = array('menu_tree__sub_menu');
    }
    else {
      // OG menu.
      $vars['content']['#theme_wrappers'] = array('menu_tree__sub_menu');
    }
  }


  if($vars['pane']->subtype == 'menu_block-main_menu_second_level') {
    ddbasic_body_class('has-second-level-menu');
  }

}

/**
 * Render callback.
 *
 * Remove panels div separator.
 */
function ddbasic_panels_default_style_render_region($vars) {
  $output = '';
  $output .= implode('', $vars['panes']);

  return $output;
}

/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__menu_block__1($vars) {
  return '<ul class="main-menu">' . $vars['tree'] . '</ul>';
}
/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__menu_block__main_menu_second_level($vars) {
  return '<ul class="main-menu-second-level">' . $vars['tree'] . '</ul>';
}
/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__sub_menu($vars) {
  return '<ul class="main-menu-third-level">' . $vars['tree'] . '</ul>';
}

/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__menu_block__2($vars) {
  return '<ul class="secondary-menu">' . $vars['tree'] . '</ul>';
}

/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__menu_tabs_menu($vars) {
  return '<ul class="topbar-menu">' . $vars['tree'] . '</ul>';
}

/**
 * Implements theme_menu_tree().
 */
function ddbasic_menu_tree__user_menu($vars) {
  return '<ul class="system-user-menu">' . $vars['tree'] . '</ul>';
}

/**
 * @TODO CLeanup line spacing
 * Implements hook_preprocess_views_view_unformatted().
 *
 * Overwrite views row classes
 */
function ddbasic_preprocess_views_view(&$vars) {

  switch ($vars['name']) {
    case 'ding_event':
      switch ($vars['view']->current_display) {
        case 'ding_event_library_list':
        case 'ding_event_groups_list':
        case 'ding_event_list_same_tag':
          // Add max-two-rows class
          $vars['classes_array'][] = 'max-two-rows';

        break;
        case 'ding_event_list_frontpage':
          // Add max-two-rows class
          $vars['classes_array'][] = 'max-two-rows';

          // Add event count setting as js variable
          $count = variable_get('ding_frontpage_events_count', 6);
          drupal_add_js(array('number_of_events' => $count), 'setting');

        break;
      }
    break;
    case 'ding_news':
       switch ($vars['view']->current_display) {
        case 'ding_news_groups_list':
        case 'ding_news_list_same_tag':
          // Add slide-on-mobile class
          $vars['classes_array'][] = 'slide-on-mobile';
        break;
        case 'ding_news_frontpage_list':
          // Add slide-on-mobile class
          $vars['classes_array'][] = 'slide-on-mobile';
          // Add first-child-large class
          $vars['classes_array'][] = 'first-child-large';
        break;
      }
    break;
    case 'ding_groups':
       switch ($vars['view']->current_display) {
        case 'panel_pane_1':
          // Add slide-on-mobile class
          $vars['classes_array'][] = 'slide-on-mobile';
        break;


      }
    break;

  }

}
/**
 * Implements hook_preprocess_views_view_unformatted().
 *
 * Overwrite views row classes
 */
function ddbasic_preprocess_views_view_unformatted(&$vars) {
  // Add type class to tags_list view
  if($vars['view']->name == 'tags_list') {
    $nodes = array_values($vars['view']->style_plugin->row_plugin->nodes);
    reset($vars['rows']);
    $first_key = key($vars['rows']);
    $first_node = $nodes[$first_key];
    $vars['type_class'] = drupal_html_class($first_node->type);
  }
  // Class names for overwriting.
  $row_first = "first";
  $row_last  = "last";

  $view = $vars['view'];
  $rows = $vars['rows'];

  // Set arrays.
  $vars['classes_array'] = array();
  $vars['classes'] = array();

  // Variables.
  $count = 0;
  $max = count($rows);

  // Loop through the rows and overwrite the classes, its important that the
  // $row variable is here, as it's the $id that we need.
  foreach ($rows as $id => $row) {
    $count++;

    $vars['classes'][$id][] = $count % 2 ? 'odd' : 'even';
    $vars['classes'][$id][] = 'views-row';

    if ($count == 1) {
      $vars['classes'][$id][] = $row_first;
    }
    if ($count == $max) {
      $vars['classes'][$id][] = $row_last;
    }

    if ($row_class = $view->style_plugin->get_row_class($id)) {
      $vars['classes'][$id][] = $row_class;
    }

    if ($vars['classes'] && $vars['classes'][$id]) {
      $vars['classes_array'][$id] = implode(' ', $vars['classes'][$id]);
    }
    else {
      $vars['classes_array'][$id] = '';
    }
  }
}


/**
 * Implements hook_preprocess_views_view_field().
 */
function ddbasic_preprocess_views_view_field(&$vars) {
  $field = $vars['field'];

  if (isset($field->field_info) && $field->field_info['field_name'] == 'field_ding_event_price') {
    $ding_event_price = intval($vars['output']);
    // Show "Free" text if ding_event_price is empty or zero.
    if (empty($ding_event_price)) {
      $vars['output'] = t('Free');
    }
  }
}

/**
 * Implements hook_preprocess_user_picture().
 *
 * Override or insert variables into template user_picture.tpl.php
 *
 * @TODO: Is there an render array for this, str replacement is not cheap.
 * @TODO: Why do we replace and insert span2 thumbnail classes? Aren't they
 *        bootstrap specific?
 */
function ddbasic_preprocess_user_picture(&$variables) {
  // Inject the class we need into the A tag of user_picture.
  $variables['user_picture'] = str_replace('<a ', '<a class="span2 thumbnail" ', $variables['user_picture']);

  // Inject the class we need into the IMG tag of user_picture.
  $variables['user_picture'] = str_replace('<img ', '<img class="pull-left" ', $variables['user_picture']);
}

<<<<<<< HEAD
/**
 * Implements hook_preprocess_node().
 *
 * Override or insert variables into the node templates.
 */
function ddbasic_preprocess_node(&$variables, $hook) {
  // Add ddbasic_byline to variables.
  $variables['ddbasic_byline'] = t('By: ');

  // Add event node specific ddbasic variables.
  if (isset($variables['content']['#bundle']) && $variables['content']['#bundle'] == 'ding_event') {

    // Add event location variables.
    if (!empty($variables['content']['field_ding_event_location'][0]['#address']['name_line'])) {
      $variables['ddbasic_event_location'] = $variables['content']['field_ding_event_location'][0]['#address']['name_line'] . '<br/>' . $variables['content']['field_ding_event_location'][0]['#address']['thoroughfare'] . ', ' . $variables['content']['field_ding_event_location'][0]['#address']['locality'];
    }
    else {
      // User OG group ref to link back to library.
      if (isset($variables['content']['og_group_ref'])) {
        $variables['ddbasic_event_location'] = $variables['content']['og_group_ref'];
      }
    }

    // Add event date to variables. A render array is created based on the date
    // format "date_only".
    $event_date_ra = field_view_field('node', $variables['node'], 'field_ding_event_date', array(
      'label' => 'hidden',
      'type' => 'date_default',
      'settings' => array(
        'format_type' => 'ding_date_only',
        'fromto' => 'both',
      ),
    ));
    $variables['ddbasic_event_date'] = $event_date_ra[0]['#markup'];

    // Add event time to variables. A render array is created based on the date
    // format "time_only".
    $event_time_ra = field_view_field('node', $variables['node'], 'field_ding_event_date', array(
      'label' => 'hidden',
      'type' => 'date_default',
      'settings' => array(
        'format_type' => 'ding_time_only',
        'fromto' => 'both',
      ),
    ));
    $variables['ddbasic_event_time'] = $event_time_ra[0]['#markup'];

    // Show "Free" text if ding_event_price is empty or zero. Unfortunately we
    // can't use the field template for this, since it's not called when the
    // price field is empty. This means we also need to handle this en the views
    // field preprocess.
    if (empty($variables['content']['field_ding_event_price']['#items'][0]['value'])) {
      $variables['content']['field_ding_event_price'][0]['#markup'] = t('Free');
    }
  }

  // Add tpl suggestions for node view modes.
  if (isset($variables['view_mode'])) {
    $variables['theme_hook_suggestions'][] = 'node__view_mode__' . $variables['view_mode'];
  }

  // Add "read more" links to event, news and e-resource in search result view
  // mode.
  if ($variables['view_mode'] == 'search_result') {
    switch ($variables['node']->type) {
      case 'ding_event':
        $more_link = array(
          '#theme' => 'link',
          '#text' => '<i class="icon-chevron-right"></i>',
          '#path' => 'node/' . $variables['nid'],
          '#options' => array(
            'attributes' => array(
              'title' => $variables['title'],
            ),
            'html' => TRUE,
          ),
          '#prefix' => '<div class="event-arrow-link">',
          '#surfix' => '</div>',
          '#weight' => 6,
        );

        $variables['content']['group_right_col_search']['more_link'] = $more_link;
        break;

      case 'ding_news':
        $more_link = array(
          '#theme' => 'link',
          '#text' => t('Read more'),
          '#path' => 'node/' . $variables['nid'],
          '#options' => array(
            'attributes' => array(
              'title' => $variables['title'],
            ),
            'html' => FALSE,
          ),
          '#prefix' => '<span class="news-link">',
          '#surfix' => '</span>',
          '#weight' => 6,
        );

        $variables['content']['group_right_col_search']['more_link'] = $more_link;
        break;

      case 'ding_eresource':
        $more_link = array(
          '#theme' => 'link',
          '#text' => t('Read more'),
          '#path' => 'node/' . $variables['nid'],
          '#options' => array(
            'attributes' => array(
              'title' => $variables['title'],
            ),
            'html' => FALSE,
          ),
          '#prefix' => '<span class="eresource-link">',
          '#surfix' => '</span>',
          '#weight' => 6,
        );

        $variables['content']['group_right_col_search']['more_link'] = $more_link;
        break;

      case 'ding_page':
        $more_link = array(
          '#theme' => 'link',
          '#text' => t('Read more'),
          '#path' => 'node/' . $variables['nid'],
          '#options' => array(
            'attributes' => array(
              'title' => $variables['title'],
            ),
            'html' => FALSE,
          ),
          '#prefix' => '<span class="page-link">',
          '#surfix' => '</span>',
          '#weight' => 6,
        );

        $variables['content']['group_right_col_search']['more_link'] = $more_link;
        break;
    }
  }

  // For search result view mode move title into left col. group.
  if (isset($variables['content']['group_right_col_search'])) {
    $variables['content']['group_right_col_search']['title'] = array(
      '#theme' => 'link',
      '#text' => decode_entities($variables['title']),
      '#path' => 'node/' . $variables['nid'],
      '#options' => array(
        'attributes' => array(
          'title' => $variables['title'],
        ),
        'html' => FALSE,
      ),
      '#prefix' => '<h2>',
      '#suffix' => '</h2>',
    );
  }

  // Add updated to variables.
  $variables['ddbasic_updated'] = t('!datetime', array(
    '!datetime' => format_date(
      $variables['node']->changed,
      $type = 'long',
      $format = '',
      $timezone = NULL,
      $langcode = NULL
    ))
  );

  // Modified submitted variable.
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('!datetime', array(
      '!datetime' => format_date(
        $variables['created'],
        $type = 'long',
        $format = '',
        $timezone = NULL,
        $langcode = NULL
      ))
    );
  }
}

/**
 * Implements template_preprocess_field().
 */
function ddbasic_preprocess_field(&$vars, $hook) {
  // Get current view mode (teaser).
  $view_mode = $vars['element']['#view_mode'];
  $field_name = $vars['element']['#field_name'];

  // Add suggestion for ddbasic specific field.
  $vars['theme_hook_suggestions'][] = 'field__ddbasic';

  // Add suggestion for ddbasic field with specific name.
  $vars['theme_hook_suggestions'][] = 'field__ddbasic_' . $field_name;

  // Add suggestion for ddbasic field in specific view mode.
  $vars['theme_hook_suggestions'][] = 'field__ddbasic_' . $view_mode;

  // Stream line tags in view modes using the same tpl.
  if ($vars['element']['#field_type'] == 'taxonomy_term_reference') {
    $vars['theme_hook_suggestions'][] = 'field__ddbasic_tags__' . $view_mode;
  }

  // Ensure that all OG group ref field are the same.
  if ($field_name == 'ding_event_groups_ref' || $field_name == 'ding_news_groups_ref' || $field_name == 'og_group_ref') {
    $vars['theme_hook_suggestions'][] = 'field__og_group_ref';

    // Add classes to get label correctly formatted.
    foreach ($vars['items'] as $id => $item) {
      $vars['items'][$id]['#options'] = array(
        'attributes' => array(
          'class' => array(
            'label',
            'label_info',
          ),
        ),
      );
    }
  }

  // Clean up fields in search result view mode aka. search result page.
  if ($view_mode == 'search_result') {
    // Add suggestion that only hits the search result page.
    $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_type'] . '__' . $view_mode;

    switch ($vars['element']['#field_name']) {
      case 'ting_author':
      case 'ting_abstract':
      case 'ting_subjects':
        $vars['classes_array'] = array('content');
        break;

      case 'ting_title':
        $vars['classes_array'] = array('heading');
        break;
    }
  }

  // Make suggestion for the availability on the search result page.
  if ($vars['element']['#field_type'] == 'ting_collection_types' &&
      $vars['element']['#formatter'] == 'ding_availability_with_labels') {
    $vars['theme_hook_suggestions'][] = 'field__' . $vars['element']['#field_type'] . '__' . 'search_result';
  }

  // Add class to library OG ref on staff profiles only.
  if ($vars['element']['#bundle'] == 'ding_staff_profile') {
    $staff_fields = array(
      'og_group_ref',
      'field_ding_staff_department',
      'field_ding_staff_email',
      'field_ding_staff_phone',
      'field_ding_staff_work_areas',
    );

    if (in_array($field_name, $staff_fields)) {
      $vars['theme_hook_suggestions'][] = 'field__ding_staff__content_field';

      // Ensure that department is not add label info.
      if ($field_name == 'field_ding_staff_department' || $field_name == 'og_group_ref') {
        foreach ($vars['items'] as $id => $item) {
          // This as little hack to make the user interface look better.
          $vars['items'][$id]['#options']['no_label'] = TRUE;
        }
      }
    }

    if ($field_name == 'og_group_ref') {
      $vars['classes_array'][] = 'field-name-ding-library-name';
    }
  }
}
=======
>>>>>>> Initial commit

/**
 * Implements theme_link().
 *
 * Adds a class "label" to all link in taxonomies.
 *
 * @see theme_link()
 */
function ddbasic_link($variables) {
  if (isset($variables['options']['entity_type']) && $variables['options']['entity_type'] == 'taxonomy_term') {
    if (!isset($variables['options']['no_label'])) {
      // Add classes label and label-info.
      if (!isset($variables['options']['attributes']['class'])) {
        $variables['options']['attributes']['class'] = array();
      }
      $variables['options']['attributes']['class'][] = 'label';
      $variables['options']['attributes']['class'][] = 'label-info';
    }
  }

  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}


/**
 * Implements template_preprocess_user_profile().
 */
function ddbasic_preprocess_user_profile(&$variables) {
  $variables['user_profile']['summary']['member_for']['#access'] = FALSE;
}


/**
 * Implements template_preprocess_entity().
 *
 * Runs an entity specific preprocess function, if it exists.
 */
function ddbasic_preprocess_entity(&$variables, $hook) {
  $function = __FUNCTION__ . '_' . $variables['entity_type'];
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}


/**
 * Profile2 specific implementation of template_preprocess_entity().
 */
function ddbasic_preprocess_entity_profile2(&$variables) {
  // Add staff position as a renderable field without label for subheader.
  if ($variables['profile2']->type == 'ding_staff_profile') {
    if (isset($variables['content']['group_contactinfo']['field_ding_staff_position'])) {
      $staff_position = $variables['content']['group_contactinfo']['field_ding_staff_position'];
      $staff_position['#label_display'] = 'hidden';
      $variables['position_no_label'] = $staff_position;
    }
    else {
      $variables['position_no_label'] = FALSE;
    }
  }
}

/**
 * Implements theme_menu_link().
 */
function ddbasic_menu_link($vars) {
  $element = $vars['element'];

  // Render any sub-links/menus.
  $sub_menu = '';
  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  // Add default class to a tag.
  $element['#localized_options']['attributes']['class'] = array(
    'menu-item',
  );

  // Filter classes.
  $element['#attributes']['class'] = ddbasic_remove_default_link_classes($element['#attributes']['class']);

  // Make sure text string is treated as html by l function.
  $element['#localized_options']['html'] = TRUE;

  $link = l('<span>' . $element['#title'] . '</span>', $element['#href'], $element['#localized_options']);

  return '<li' . drupal_attributes($element['#attributes']) . '>' . $link . $sub_menu . "</li>\n";
}


/**
 * Implements theme_menu_link().
 *
 * Add specific markup for top-bar menu exposed as menu_block_4.
 */
function ddbasic_menu_link__menu_tabs_menu($vars) {
  // Run classes array through our custom stripper.
  $vars['element']['#attributes']['class'] = ddbasic_remove_default_link_classes($vars['element']['#attributes']['class']);

  // Check if the class array is empty.
  if (empty($vars['element']['#attributes']['class'])) {
    unset($vars['element']['#attributes']['class']);
  }

  $element = $vars['element'];

  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  // Add default class to a tag.
  $element['#localized_options']['attributes']['class'] = array(
    'menu-item',
  );

  // Make sure text string is treated as html by l function.
  $element['#localized_options']['html'] = TRUE;

  $element['#localized_options']['attributes']['class'][] = 'js-topbar-link';

  // Add some icons to our top-bar menu. We use system paths to check against.
  switch ($element['#href']) {
    case 'search':
      $title_prefix = '<i class="icon-search"></i>';
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-search';
      $element['#attributes']['class'][] = 'topbar-link-search';
      break;

    case 'node':
      // Special placeholder for mobile user menu. Fall through to next case.
      $element['#localized_options']['attributes']['class'][] = 'default-override';

    case 'user':
      $title_prefix = '<i class="icon-user"></i>';
      // If a user is logged in we change the menu item title.
      if (user_is_logged_in()) {
        $element['#title'] = 'My Account';
        $element['#attributes']['class'][] = 'topbar-link-user-account';
        $element['#localized_options']['attributes']['class'][] = 'topbar-link-user-account';
      }
      else {
        $element['#attributes']['class'][] = 'topbar-link-user';
        $element['#localized_options']['attributes']['class'][] = 'topbar-link-user';
      }
      break;

    case 'user/logout':
      $title_prefix = '<i class="icon-signout"></i>';
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-signout';
      $element['#attributes']['class'][] = 'topbar-link-signout';

      break;

    case 'libraries':
      $title_prefix = '<i class="icon-clock"></i>';
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-opening-hours';
      $element['#attributes']['class'][] = 'topbar-link-opening-hours';
      break;

    default:
      $title_prefix = '<i class="icon-align-justify"></i>';
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-menu';
      $element['#attributes']['class'][] = 'topbar-link-menu';
      break;
  }

   // For some unknown issue translation fails.
  $element['#title'] = t($element['#title']);

  $output = l($title_prefix . '<span>' . $element['#title'] . '</span>', $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Used to strip default class names from menu links.
 *
 * @param array $classes
 *   An array of class attributes.
 *
 * @return array
 *   Classes that are left.
 */
function ddbasic_remove_default_link_classes($classes) {
  if (!isset($classes)) {
    return FALSE;
  }

  // Remove classes.
  $remove = array();

  // Remove .leaf.
  if (theme_get_setting('ddbasic_classes_menu_leaf')) {
    $remove[] .= "leaf";
  }

  // Remove .has-children.
  if (theme_get_setting('ddbasic_classes_menu_has_children')) {
    $remove[] .= "has-children";
  }

  // Remove .collapsed, .expanded and expandable.
  if (theme_get_setting('ddbasic_classes_menu_collapsed')) {
    $remove[] .= "collapsed";
    $remove[] .= "expanded";
    $remove[] .= "expandable";
  }

  // Remove the classes.
  if ($remove) {
    $classes = array_diff($classes, $remove);
  }

  // Remove menu-mlid-[NUMBER].
  if (theme_get_setting('ddbasic_classes_menu_items_mlid')) {
    $classes = preg_grep('/^menu-mlid-/', $classes, PREG_GREP_INVERT);
  }

  return $classes;
}

/**
 * Allows us to add script plugins to the theme via theme settings.
 *
 * Ex. add a javascript depending on the settings in the theme.
 */
// @TODO Remove unused code
//
// @B14 outcommentet
//
//function ddbasic_load_plugins() {
//  $theme_path = drupal_get_path('theme', 'ddbasic');
//
//  // If sticky menus is enabled in the theme load it.
//  if (theme_get_setting('main_menu_sticky')) {
//
//    // Add variable to js so we can check if it is set.
//    drupal_add_js(array('ddbasic' => array('main_menu_sticky' => theme_get_setting('main_menu_sticky'))), 'setting');
//  }
//
//  // If equalize is enabled in the theme load it.
//  if (theme_get_setting('load_equalize')) {
//
//    // Add the script.
//    drupal_add_js($theme_path . '/scripts/contrib/equalize.min.js');
//
//    // Add variable to js so we can check if it is set.
//    drupal_add_js(array('ddbasic' => array('load_equalize' => theme_get_setting('load_equalize'))), 'setting');
//  }
//}

/**
 * Implements hook_js_alter().
 */
function ddbasic_js_alter(&$javascript) {
  // Set the ding_popup.js to the popup-hijack.js instead.
  $ding_popup = drupal_get_path('module', 'ding_popup') . '/ding_popup.js';
  if (isset($javascript[$ding_popup])) {
    $javascript[$ding_popup]['data'] = drupal_get_path('theme', 'ddbasic') . '/scripts/popup-hijack.js';
  }

  // Remove the opening_hours files, so they dont't cause a JavaScript error
  // when outputting the theme specific opening_hours template.
  $opening_hours_path = drupal_get_path('module', 'opening_hours');
  foreach ($javascript as $key => $value) {
    if (strpos($key, $opening_hours_path) !== FALSE) {
      unset($javascript[$key]);
    }
  }
}

/**
 * Implements hook_theme_script().
 *
 * Since Drupal 7 does not (yet) support the 'browser' option in drupal_add_js()
 * ddbasic provides a way to load scripts inside conditional comments.
 * This function wraps a file in script elements and returns a string.
 */
function ddbasic_theme_script($filepath) {
  $script = '';

  // We need the default query string for cache control finger printing.
  $query_string = variable_get('css_js_query_string', '0');

  if (file_exists($filepath)) {
    $file = file_create_url($filepath);
    $script = '<script src="' . $file . '?' . $query_string . '"></script>';
  }

  return $script;
}

/**
 * Return the info file array for a particular theme, usually the active theme.
 *
 * Simple wrapper function for list_themes().
 *
 * @param string $theme_name
 *   Name of the current theme.
 */
function ddbasic_get_info($theme_name) {
  $info = &drupal_static(__FUNCTION__, array());
  if (empty($info)) {
    $themes = list_themes();
    foreach ($themes as $key => $value) {
      if ($theme_name == $key) {
        $info = $themes[$theme_name]->info;
      }
    }
  }

  return $info;
}

/**
 * Implements theme_item_list().
 *
 * This is the default theme function. With the wrapper div removed.
 */
function ddbasic_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];
  $output = '';

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    foreach ($items as $i => $item) {
      $attributes = array();
      $children = array();
      $data = '';
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array(
          'items' => $children,
          'title' => NULL,
          'type' => $type,
          'attributes' => $attributes,
        ));
      }
      if ($i == 0) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items - 1) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }
  return $output;
}

/**
 * Implements hook_process_page().
 */
function ddbasic_process_page(&$vars) {
  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}

/**
 * Implements hook_preprocess_ting_object().
 *
 * Adds wrapper classes to the different groups on the ting object.
 */
function ddbasic_preprocess_ting_object(&$vars) {
  //
  // Add tpl suggestions for node view modes.
  if (isset($vars['elements']['#view_mode'])) {
    $vars['theme_hook_suggestions'][] = $vars['elements']['#bundle'] . '__view_mode__' . $vars['elements']['#view_mode'];
  }

  switch ($vars['elements']['#entity_type']) {
    case 'ting_collection':
      // Add a reference to the ting_object if it's included in a
      // ting_collection.
      foreach ($vars['object']->entities as &$ting_entity) {
        $ting_entity->in_collection = $vars['object'];
      }
      break;

    case 'ting_object':

      $uri_collection = entity_uri('ting_collection', $vars['object']);
      $vars['ting_object_url_collection'] = url($uri_collection['path']);

      $uri_object = entity_uri('ting_object', $vars['object']);
      $vars['ting_object_url_object'] = url($uri_object['path']);

      switch ($vars['elements']['#view_mode']) {
        case 'teaser':
          if ($vars['object']->is('reservable')) {
            //$vars['content']['reserve_button'] = array(ding_provider_get_form('ding_reservation_reserve_form', new DingReservationReservableEntity($vars['object']), TRUE));
            drupal_add_library('system', 'drupal.ajax');

            $vars['content']['group_text']['read_more_button'] = array(
              array(
                '#theme' => 'link',
                '#text' => t('Read more'),
                '#path' => $uri_object['path'],
                '#options' => array(
                  'attributes' => array(
                    'class' => array(
                      'action-button',
                      'read-more-button',
                    ),
                  ),
                  'html' => FALSE,
                ),
              ),
              '#weight' => 9998,
            );

            $vars['content']['group_text']['reserve_button'] = array(
              array(
                '#theme' => 'link',
                '#text' => t('Reserve'),
                '#path' => 'ting/object/' . $vars['object']->id . '/reserve',
                '#options' => array(
                  'attributes' => array(
                    'class' => array(
                      'action-button',
                      'reserve-button',
                      'use-ajax',
                    ),
                    'id' => 'reservation-' . $vars['object']->id,
                  ),
                  'html' => FALSE,
                ),
              ),
              '#weight' => 9999,
            );
          }
          break;
      }

      break;
    //case '':
    //  break;
  }

  // Inject the availability from the collection into the actual ting object.
  // Notice it's only done on the "search_result" view mode.
  if ($vars['elements']['#entity_type'] == 'ting_object' && isset($vars['object']->in_collection)
      && isset($vars['elements']['#view_mode'])
      && in_array($vars['elements']['#view_mode'], array('search_result', 'collection_list'))) {
    if (isset($vars['content']['group_ting_right_col_search'])) {
      $right_col = 'group_ting_right_col_search';
    } else {
      $right_col = 'group_ting_right_col_collection';
    }
    $vars['content'][$right_col]['availability'] = field_view_field(
      'ting_collection',
      $vars['object']->in_collection,
      'ting_collection_types',
      array(
        'type' => 'ding_availability_with_labels',
        //'label' => 'hidden',
        'weight' => 9999,
      )
    );
    $vars['content'][$right_col]['availability']['#title'] = t('Borrowing options');
  }

  if (isset($vars['elements']['#view_mode']) && $vars['elements']['#view_mode'] == 'full') {
    switch ($vars['elements']['#entity_type']) {
      case 'ting_object':
        $content = $vars['content'];
        $vars['content'] = array();

        if (isset($content['group_ting_object_left_column']) && $content['group_ting_object_left_column']) {
          $vars['content']['ting-object'] = array(
            '#prefix' => '<div class="ting-object-wrapper">',
            '#suffix' => '</div>',
            'content' => array(
              '#prefix' => '<div class="ting-object-inner-wrapper">',
              '#suffix' => '</div>',
              'left_column' => $content['group_ting_object_left_column'],
              'right_column' => $content['group_ting_object_right_column'],
            ),
          );

          unset($content['group_ting_object_left_column']);
          unset($content['group_ting_object_right_column']);
        }

        if (isset($content['group_material_details']) && $content['group_material_details']) {
          $vars['content']['material-details'] = array(
            '#prefix' => '<div class="ting-object-wrapper">',
            '#suffix' => '</div>',
            'content' => array(
              '#prefix' => '<div class="ting-object-inner-wrapper">',
              '#suffix' => '</div>',
              'details' => $content['group_material_details'],
            ),
          );
          unset($content['group_material_details']);
        }

        if (isset($content['content']['ding_availability_holdings'])) {

          $vars['content']['holdings-available'] = array(
            '#prefix' => '<div class="ting-object-wrapper">',
            '#suffix' => '</div>',
            'content' => array(
              '#prefix' => '<div class="ting-object-inner-wrapper">',
              '#suffix' => '</div>',
              'details' => $content['group_holdings_available'],
            ),
          );
          unset($content['content']['ding_availability_holdings']);
        }

        if (isset($content['group_periodical_issues']) && $content['group_periodical_issues']) {
          $vars['content']['periodical-issues'] = array(
            '#prefix' => '<div class="ting-object-wrapper">',
            '#suffix' => '</div>',
            'content' => array(
              '#prefix' => '<div class="ting-object-inner-wrapper">',
              '#suffix' => '</div>',
              'details' => $content['group_periodical_issues'],
            ),
          );
          unset($content['group_periodical_issues']);
        }

        if (isset($content['group_on_this_site']) && $content['group_on_this_site']) {
          $vars['content']['on_this_site'] = array(
            '#prefix' => '<div class="ting-object-wrapper">',
            '#suffix' => '</div>',
            'content' => array(
              '#prefix' => '<div id="ting_reference" class="ting-object-inner-wrapper">',
              '#suffix' => '</div>',
              'details' => $content['group_on_this_site'],
            ),
          );
          unset($content['group_on_this_site']);
        }

        if (isset($content['ting_relations']) && $content['ting_relations']) {
          $vars['content']['ting-relations'] = array(
            'content' => array(
              'details' => $content['ting_relations'],
            ),
          );
          unset($content['ting_relations']);
        }

        // Move the reset over if any have been defined in the UI.
        if (!empty($content)) {
          $vars['content'] += $content;
        }

        break;
      // @TODO Remove unused code
      //case 'ting_collection':
      //  // Assumes that field only has one value.
      //  foreach ($vars['content']['ting_entities'][0] as &$type) {
      //    $type['#prefix'] = '<div class="ting-collection-wrapper"><div class="ting-collection-inner-wrapper">' . $type['#prefix'];
      //    $type['#suffix'] = '</div></div>';
      //  }
      //  break;
    }
  }
}

/**
 * Preprocess function for material_item theme function.
 */
function ddbasic_preprocess_material_item(&$variables) {

  //Add label for styling to checkbox
  $element = $variables['element'];

  $element[$element['#id']]['#title'] = ".";

  // Render the checkbox.
  $variables['checkbox'] = drupal_render($element[$element['#id']]);

  // Get url to ting object
  $variables['ting_object_url_object'] = $variables['element']['#information']['ting_object_url_object']['url'];

  $variables['information']['expiry']['#weight'] = 1;

  //$variables['information']['ting_object_url_object']['#visibility'] = 'hidden';

  unset($variables['information']['ting_object_url_object']);

}

/**
 * Preprocess function form element
 */

function ddbasic_preprocess_form_element(&$variables) {
  //remove label to profile date field
  if($variables['element']['#id'] == 'edit-profile-provider-alma-field-alma-reservation-pause-und-0-value2') {
    $variables['element']['#title'] = '';
  }
  //Change label for date picker
  if($variables['element']['#id'] == 'edit-profile-provider-alma-field-alma-reservation-pause-und-0-value2-datepicker-popup-0') {
    $variables['element']['#title'] = 'Til dato:';
  }
  //Change label for date picker
  if($variables['element']['#id'] == 'edit-profile-provider-alma-field-alma-reservation-pause-und-0-value-datepicker-popup-0') {
    $variables['element']['#title'] = 'Fra dato:';
  }

}

/**
 * Implements hook_preprocess_ting_search_carousel
 */
function ddbasic_preprocess_ting_search_carousel(&$variables) {
  // Add ajax to make reserve links work
  drupal_add_library('system', 'drupal.ajax');
}
/**
 * Implements hook_preprocess_ting_search_carousel_collection().
 */
function ddbasic_preprocess_ting_search_carousel_collection(&$variables) {
  $object = ding_entity_load($variables['collection']->id, 'ting_object');
  $variables['content'] = ting_object_view($object, 'teaser');
}

/**
 * @TODO Missing description
 */
function ddbasic_date_display_range($variables) {
  $date1 = $variables['date1'];
  $date2 = $variables['date2'];
  $timezone = $variables['timezone'];
  $attributes_start = $variables['attributes_start'];
  $attributes_end = $variables['attributes_end'];

  $start_date = '<span class="date-display-start"' . drupal_attributes($attributes_start) . '>' . $date1 . '</span>';
  $end_date = '<span class="date-display-end"' . drupal_attributes($attributes_end) . '>' . $date2 . $timezone . '</span>';

  // If microdata attributes for the start date property have been passed in,
  // add the microdata in meta tags.
  if (!empty($variables['add_microdata'])) {
    $start_date .= '<meta' . drupal_attributes($variables['microdata']['value']['#attributes']) . '/>';
    $end_date .= '<meta' . drupal_attributes($variables['microdata']['value2']['#attributes']) . '/>';
  }

  // Wrap the result with the attributes.
  return t('!start-date - !end-date', array(
    '!start-date' => $start_date,
    '!end-date' => $end_date,
  ));
}
