<div class="contact">
  <h3><?=__('Segítségre van szüksége?', TD)?></h3>
  <h4><?=__('Állunk rendelkezésére<br>az alábbi elérhetőségeken', TD)?>:</h4>
  <div class="items">
    <div class="">
      <i class="fa fa-map-marker"></i> <?php echo get_option('address'); ?>
    </div>
    <div class="">
      <i class="fa fa-phone"></i> <strong><a href="tel:<?php echo get_option('phone'); ?>"><?php echo get_option('phone'); ?></a></strong>
    </div>
    <div class="">
      <i class="fa fa-envelope"></i> <a href="mailto:<?php echo get_option('admin_email'); ?>"><?php echo get_option('admin_email'); ?></a>
    </div>
    <div class="">
      <i class="fa fa-globe"></i> www.<?php echo DOMAIN; ?>
    </div>
  </div>
</div>
<div class="contact-form">
  <?php echo do_shortcode('[contact-form]'); ?>
</div>
