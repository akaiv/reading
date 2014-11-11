<?php

/* 본문 영역 시작 */
function akaiv_before_content() {
  // get_sidebar(); ?>
  <div id="content" class="site-content" role="main"><?php
}

/* 페이지 시작 */
function akaiv_before_page() { ?>
  <article <?php post_class(); ?>><?php
}

/* 페이지 끝 */
function akaiv_after_page() { ?>
  </article><?php
}

/* 본문 영역 끝 */
function akaiv_after_content() { ?>
  </div><!-- #content --><?php
}

/* 페이지 헤더: 글 및 보관함 */
function akaiv_page_header($str = null) { ?>
  <header class="page-header">
    <h1 class="page-title"><?php
      if ( $str ) :
        echo $str;

      elseif ( is_404() ) :
        echo 'Not Found';

      elseif ( is_search() ) :
        printf( '검색 결과: %s', get_search_query() );

      elseif ( is_archive()  ) :
            if ( is_tax( 'post_format', 'post-format-aside'   ) ) : echo '추가 정보';
        elseif ( is_tax( 'post_format', 'post-format-image'   ) ) : echo '이미지';
        elseif ( is_tax( 'post_format', 'post-format-video'   ) ) : echo '비디오';
        elseif ( is_tax( 'post_format', 'post-format-audio'   ) ) : echo '오디오';
        elseif ( is_tax( 'post_format', 'post-format-quote'   ) ) : echo '인용';
        elseif ( is_tax( 'post_format', 'post-format-link'    ) ) : echo '링크';
        elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) : echo '갤러리';
        elseif ( is_day()      ) : echo get_the_date();
        elseif ( is_month()    ) : echo get_the_date( 'Y년 F' );
        elseif ( is_year()     ) : echo get_the_date( 'Y년' );
        elseif ( is_author()   ) : the_post(); echo get_the_author().'의 모든 글'; rewind_posts();
        elseif ( is_tag()      ) : single_tag_title( '태그: ' );
        elseif ( is_category() ) : single_cat_title();
        else                     : echo '보관함';
        endif;

        /* Term Description */
        $term_description = term_description();
        if ( ! empty( $term_description ) ) : ?>
          <small class="taxonomy-description"><?php echo $term_description; ?></small><?php
        endif;

      elseif( is_home() ) :
        echo '최근 글 목록';

      else :
        echo get_the_title();

      endif; ?>
    </h1>
  </header><?php
}

/* 글: 제목 */
function akaiv_the_title() {
  $title = trim(get_the_title());
  if ( ! $title ) $title = '(제목이 없는 글)';
  echo $title;
}

/* 글: URL */
function akaiv_get_url() {
  $url = get_post_meta( get_the_ID(), 'wpcf-website-url', true );
  return esc_url( $url );
}
function akaiv_the_url() {
  echo akaiv_get_url();
}

/* 글: URL 호스트 */
function akaiv_the_url_hostname() {
  $url = akaiv_get_url();
  if ( $url ) :
    $urlHosts = array(
      # 미디어
      'www.venturesquare.net'   => '벤처스퀘어',
      'platum.kr'               => '플래텀',
      'besuccess.com'           => 'beSUCCESS',
      'www.bloter.net'          => '블로터닷넷',
      'www.etnews.com'          => '전자신문',
      'ppss.kr'                 => 'ㅍㅍㅅㅅ',

      # 블로그
      'www.thestartupbible.com' => '스타트업 바이블',
      'www.jimmyrim.com'        => '지미림\'s 블로그',
      'www.infuture.kr'         => '인퓨처컨설팅 &amp, 유정식',
      'sungmooncho.com'         => '조성문의 실리콘밸리 이야기',
      'estima.wordpress.com'    => '에스티마의 인터넷이야기'
    );

    $urlHost = parse_url($url)['host'];
    $urlHostName = empty( $urlHosts[$urlHost] ) ? $urlHost : $urlHosts[$urlHost];

    echo '<span class="url-hostname"><i class="fa fa-fw fa-quote-left"></i> <a href="<?php akaiv_the_url(); ?>" target="_blank" class="url">'.$urlHostName.'</a></span>';
  endif;
}

/* 글: 썸네일 */
function akaiv_post_thumbnail() {
  if ( is_singular() ) : /* 포스트, 페이지, 첨부파일의 경우 */
    if ( has_post_thumbnail() ) : ?>
      <div class="post-thumbnail">
        <?php the_post_thumbnail('full'); ?>
      </div><?php
    endif;

  else : /* 외부: a.post-thumbnail에 링크 부여하고 썸네일을 가져옴 */ ?>
    <a class="post-thumbnail" href="<?php akaiv_the_url(); ?>"><?php
      if ( has_post_thumbnail() ) :
        the_post_thumbnail('thumbnail');
      else : ?>
        <img width="150" height="150" src="<?php echo get_template_directory_uri(); ?>/images/thumbnail-post.png" class="attachment-thumbnail wp-post-image" alt="<?php echo get_the_title(); ?>"><?php
      endif; ?>
    </a><?php

  endif; /* End is_singular() */
}

/* 글: 메타 */
function akaiv_post_meta($str = null) {
  if ( ! $str ) :
    return false;

  elseif ( $str == 'category' ) : ?>
    <span class="cat-links"><i class="fa fa-fw fa-folder-open"></i> <?php echo get_the_category_list( ', ' ); ?></span><?php

  elseif ( $str == 'tag' ) :
    if ( has_tag() ) : ?>
      <span class="tag-links"><i class="fa fa-fw fa-tag"></i> <?php the_tags('', ', ', ''); ?></span><?php
    endif;

  elseif ( $str == 'date' ) : ?>
    <span class="posted-on"><i class="fa fa-fw fa-clock-o"></i> <a href="<?php echo get_month_link( get_the_time('Y'), get_the_time('m') ); ?>"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ) ?></time></a></span><?php

  elseif ( $str == 'author' ) : ?>
    <span class="byline author vcard"><i class="fa fa-fw fa-user"></i> <a class="url fn" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a></span><?php

  endif;
}

/* 글: 편집 링크 */
function akaiv_edit_post_link() {
  if ( is_page() ) : ?>
    <div class="text-right">
      <?php edit_post_link( '편집', '<span class="edit-link">', '</span>' ); ?>
    </div><?php
  else :
    edit_post_link( '편집', '<span class="edit-link"><i class="fa fa-fw fa-pencil"></i> ', '</span>' );
  endif;
}

/* 글: 내비게이션 버튼 */
function akaiv_post_nav() {
  // Don't print empty markup if there's nowhere to navigate.
  $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
  $next     = get_adjacent_post( false, '', false );

  if ( ! $next && ! $previous ) return; ?>

  <nav class="navigation post-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php echo 'Post navigation'; ?></h1>
    <div class="nav-links"><?php
      if ( is_attachment() ) : /* 첨부파일 페이지일 때 */ ?>
        <div class="published-in"><?php
          previous_post_link( '%link', '<i class="fa fa-fw fa-folder-open"></i> 발행 위치: ' . '%title' ); ?>
        </div><?php
      else : /* 첨부파일 페이지가 아닐 때 */
        previous_post_link( '%link', '<i class="fa fa-fw fa-angle-left"></i> 이전 글');
        next_post_link( '%link', '다음 글 <i class="fa fa-fw fa-angle-right"></i>' );
      endif; ?>
    </div>
  </nav><?php
}

/* 보관함: 페이지네이션 */
function akaiv_paginate_links() {
  global $wp_query;
  if ( $wp_query->max_num_pages > 1 ) :
    echo '<nav class="nav-pagination">';
    $big = 999999999;
    $args = array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'current' => max( 1, get_query_var('paged') ),
      'total' => $wp_query->max_num_pages,
      'after_page_number' => '<span class="screen-reader-text">번째 페이지</span>',
      'type' => 'array'
    );
    $paginate_links = paginate_links( $args );
    if( is_array( $paginate_links ) ) :
      $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
      echo '<ul class="pagination pagination-sm">';
      foreach ( $paginate_links as $page ) :
        if ( strpos($page, 'current') ) : echo '<li class="active">'.$page.'</li>';
        else : echo '<li>'.$page.'</li>';
        endif;
      endforeach;
      echo '</ul>';
    endif;
    echo '</nav>';
  endif;
}
