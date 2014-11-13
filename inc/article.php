<?php
/* 요약에서 auto p 제거 */
remove_filter( 'the_excerpt', 'wpautop' );

/* 본문에 URL 명시(feed) */
function akaiv_insert_content_footnote($content) {
  if( is_feed() ) :
    $content.= '<p>원문 바로가기: <a href="'.akaiv_get_url().'">'.akaiv_get_url().'</a></p>';
  endif;
  return $content;
}
add_filter( 'the_content', 'akaiv_insert_content_footnote' );
