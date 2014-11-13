<?php
/* 요약에서 auto p 제거 */
remove_filter( 'the_excerpt', 'wpautop' );

/* 요약에 URL 명시 */
function akaiv_insert_content_footnote($content) {
  if( is_feed() ) :
    $content.= '<br>원문 바로가기: <a href='.akaiv_get_url().'>'.akaiv_get_url().'</a>';
  endif;
  return $content;
}
add_filter( 'the_excerpt', 'akaiv_insert_content_footnote' );
