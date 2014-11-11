<?php
require_once 'inc/add-post.php';
get_header();
akaiv_before_content(); ?>

<?php
  /* 관리자: 새 항목 추가 폼 */
  if ( current_user_can( 'publish_posts' ) ) :
    require_once 'templates/form-add-post.php';
  endif;

  /* 최근 글 목록 */
  if ( have_posts() ) :
    while ( have_posts() ) : the_post();
      get_template_part( 'templates/content' );
      echo '<hr>';
    endwhile;
    akaiv_paginate_links();
  else :
    get_template_part( 'templates/content', 'none' );
  endif;
?>

<?php
akaiv_after_content();
get_footer();
