<?php
/* 요약에서 auto p 제거 */
remove_filter( 'the_excerpt', 'wpautop' );

/* 피드 */
function akaiv_insert_footnote($content) {
  $original  = '<p>원문 바로가기: <a href="'.akaiv_get_url().'" target="_blank" rel="bookmark">'.akaiv_get_url().'</a></p>';
  $content   = ( ! empty($content) ) ? '<p>'.$content.'</p>' : '';
  $content   = $original . $content;
  return $content;
}
add_filter( 'the_excerpt_rss', 'akaiv_insert_footnote' );
