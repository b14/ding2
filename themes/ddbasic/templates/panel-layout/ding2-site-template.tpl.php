<?php

/**
 * @file
 * Ddbasic implementation to present a Panels layout.
 */
?>
<div id="page<?php print $css_id ? " $css_id" : ''; ?>" class="<?php print $classes; ?>">
  <?php if (!empty($content['branding']) || !empty($content['header']) || !empty($content['navigation'])): ?>
    <header class="site-header">
      <?php if (!empty($content['branding'])): ?>
        <section class="site-header-topbar">
          <div class="site-header-inner">
            <?php print render($content['branding']); ?>
          </div>
        </section>
      <?php endif; ?>

      <?php if (!empty($content['header'])): ?>
        <!-- @TODO denne klasse skal omdøbes hvis mobile menu ligger her -->
        <section class="site-header-search">
          <?php print render($content['header']); ?>
        </section>
      <?php endif; ?>

      <?php if (!empty($content['navigation'])): ?>
        <section class="site-header-navigation js-topbar-menu">
          <div class="site-header-inner">
            <?php print render($content['navigation']); ?>
          </div>
        </section>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <div class="content-wrapper js-content-wrapper">
    <div class="content-inner">
      <?php print render($content['content']); ?>
    </div>
  </div>

  <?php if (!empty($content['footer'])): ?>
    <footer class="footer">
      <div class="footer-inner">
        <?php print render($content['footer']); ?>
      </div>
    </footer>
  <?php endif; ?>

  <?php if (!empty($content['bottom'])): ?>
    <div class="bottom">
      <?php print render($content['bottom']); ?>
    </div>
  <?php endif; ?>

</div>
