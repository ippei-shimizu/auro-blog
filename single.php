<?php get_header(); ?>

<div class="single">
  
  <div class="single-fv">
    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('large', ['class' => 'single-featured-image', 'alt' => get_the_title()]); ?>
    <?php endif; ?>
  </div>

  <ul class="single-nav-link">
    <li>
      <a href="<?php echo esc_url(home_url('/')); ?>">AURO「すまいの再発見マガジン」＞</a>
    </li>
    <li>
      <?php
        $category = get_the_category();
        if (!empty($category)) {
          $category_link = get_category_link($category[0]->term_id);
          echo '<a href="' . esc_url($category_link) . '">' . esc_html($category[0]->name) . '</a>';
        }
      ?>
    </li>
  </ul>

  <a class="single-logo" href="<?php echo esc_url(home_url('/')); ?>">
    <img src="<?php echo $global_image_path ?>logo.png" alt="AURO" width="348" height="136">
  </a>

  <div class="single-border"></div>

  <p class="single-cat-name">
    <?php
      if (!empty($category)) {
        echo '<a href="' . esc_url($category_link) . '">' . esc_html($category[0]->name) . '</a>';
      }
    ?>
  </p>

  <h2 class="single-title"><?php the_title(); ?></h2>

  <div class="single-contents">
    <?php the_content(); ?>
  </div>

  <div class="back-btn">
    <a href="javascript:history.back()">View Back</a>
  </div>

  <div class="single-cat-box">
    <ul class="posts-cat">
      <?php
        $args = array(
          'orderby' => 'ID',
          'order'   => 'ASC'
        );
        $categories = get_categories($args);
        foreach ($categories as $category) {
          $category_link = get_category_link($category->term_id);
          echo '<li class="posts-cat-name"><a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></li>';
        }
      ?>
    </ul>
  </div>

</div>


<?php get_footer(); ?>