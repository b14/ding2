<?php

/**
 * @TODO Variables list
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <div class="group-separator">
    <div class="separator-title">
      <?php print $title; ?>
    </div>
<?php endif; ?>
  <div class="view-elements">
    <div class="view-elements-inner">
      <?php foreach ($rows as $id => $row): ?>
        <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
          <?php print $row; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="grid-sizer"></div>
    <div class="grid-gutter"></div>
  </div>
<?php if (!empty($title)): ?>
  </div>
<?php endif; ?>
