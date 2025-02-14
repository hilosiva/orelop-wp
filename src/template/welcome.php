<div class="hero">
  <div class="hero__body">
    <h1 class="hero__title">Orelop WP</h1>
    <p class="hero__text"><strong><?php echo (ViteHelper::IS_DEVELOPMENT) ? "development" : "production" ?></strong> mode.</p>
  </div>

  <figure class="hero__figure">
    <img src="<?php echo esc_url(THEME_URL); ?>/assets/images/cover.jpg" alt="">
  </figure>

  <div class="posts">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()): the_post(); ?>

        <article class="post">
          <?php the_title(); ?>
        </article>

      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>
