<?php get_header(); ?>

<div class="fv">
  <div class="fv-logo">
    <a href="">
      <img src="<?php echo $global_image_path ?>logo.png" alt="AURO" width="348" height="136">
    </a>
    <h2 class="fv-title">すまいの再発見マガジン。</h2>
  </div>
  <div class="fv-img">
    <img src="<?php echo $global_image_path ?>fv.png" alt="" width="1142" height="822">
  </div>
</div>

<div class="posts">
  <div class="posts-inner">
    <p class="posts-text">
AUROは化学物質に依存しない安心安全な製品を提供している会社です。<br>
そんなAUROが、自社の製品や、すまいについての情報を独自にピックアップして発信するウェブマガジンです。
    </p>
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


<div class="posts-list">
    <?php
  $paged = (get_query_var('page')) ? get_query_var('page') : 1;
  $args = array(
    'posts_per_page' => 9,
    'paged'          => $paged,
    'orderby'        => 'date', 
    'order'          => 'DESC'  
  );

  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) : $the_query->the_post();
?>

<div class="post-item">
  <a class="post-detail-link-img post-detail-link" href="<?php the_permalink(); ?>">
    <div class="post-img">
      <?php if (has_post_thumbnail()) : ?>
        <img class="post" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
      <?php endif; ?>
    </div>
  </a>
  <div class="post-contents-wrap">
    <p class="post-cat-name">
      <?php
        $category = get_the_category();
        if ($category[0]) {
          echo '<a href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->cat_name . '</a>';
        }
      ?>
    </p>
    <a class="post-detail-link" href="<?php the_permalink(); ?>">
      <h2 class="post-title"><?php the_title(); ?></h2>
      <div class="post-border"></div>
      <p class="post-excerpt">
        <?php echo wp_trim_words(get_the_excerpt(), 83); ?>
      </p>
    </a>
  </div>
</div>
<?php
  endwhile;
  endif;
  wp_reset_postdata();
?>
</div>
<div class="pagination">
  <?php
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
      'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
      'format' => '/page/%#%',
      'current' => max(1, get_query_var('page')),
      'total' => $the_query->max_num_pages
    ) );
  ?>
    </div>
  </div>
</div>



<?php get_footer(); ?>