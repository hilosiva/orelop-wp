<?php get_header(); ?>
<main>


  <?php if (have_posts()) : ?>
    <?php while (have_posts()): the_post(); ?>
      <!-- 繰り返し処理する内容 -->
      <?php the_title(); ?>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
