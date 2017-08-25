<?php if ($data->have_posts()): ?>
<?php while($data->have_posts()): $data->the_post(); ?>
<div class="item">
  <div class="wrapper">
    <div class="header">
      <h3><?php echo get_post_field( 'menu_order', get_the_ID()); ?>. <?php the_title(); ?></h3>
    </div>
    <div class="image">
      <div class="wrapper">
        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
      </div>
    </div>
    <div class="content">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php endwhile; wp_reset_postdata(); ?>
<?php endif; ?>
