<?php
/* 시작 */
function akaiv_before_post($post = true) {
  if ( $post ) : ?>
    <article <?php post_class(); ?>><?php
  else : ?>
    <article class="hentry"><?php
  endif;
}

/* 끝 */
function akaiv_after_post() { ?>
  </article><?php
}

/* 제목 */
function akaiv_the_title() {
  $title = trim(get_the_title());
  if ( ! $title ) $title = '(제목이 없는 글)';
  echo $title;
}

/* URL */
function akaiv_get_url() {
  $url = akaiv_get_post_meta( 'website-url' );
  if ( ! $url ) $url = '#';
  return esc_url( $url );
}
function akaiv_the_url() {
  echo akaiv_get_url();
}

/* URL 호스트 */
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
    $urlHostName = empty( $urlHosts[$urlHost] ) ? $urlHost : $urlHosts[$urlHost]; ?>

    <span class="url-hostname"><i class="fa fa-fw fa-quote-left"></i> <a href="<?php akaiv_the_url(); ?>" target="_blank" class="url"><?php echo $urlHostName; ?></a></span><?php
  endif;
}

/* 썸네일 */
function akaiv_post_thumbnail() {
  if ( post_password_required() && ! is_singular() ) : /* 비밀 글 */ ?>
    <a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php akaiv_the_post_thumbnail_placeholder( 'thumbnail', 'thumbnail-lock' ); ?></a><?php
    return;
  endif;

  if ( is_singular() ) : /* 글, 페이지, 첨부파일 */
    if ( has_post_thumbnail() ) : ?>
      <div class="post-thumbnail">
        <?php the_post_thumbnail( 'full' ); ?>
      </div><?php
    endif;

  else : /* 보관함 */ ?>
    <a class="post-thumbnail" href="<?php akaiv_the_url(); ?>"><?php
      if ( has_post_thumbnail() ) :
        the_post_thumbnail( 'thumbnail' );
      else :
        akaiv_the_post_thumbnail_placeholder( 'thumbnail' );
      endif; ?>
    </a><?php

  endif;
}

/* 썸네일: 플레이스홀더 */
function akaiv_the_post_thumbnail_placeholder($size = 'thumbnail', $filename = 'thumbnail-post', $ext = 'png') {
  $src    = get_template_directory_uri().'/images/'.$filename.'.'.$ext;
  $srcset = get_template_directory_uri().'/images/'.$filename.'@2x.'.$ext.' 2x';
  $alt = get_the_title();
  list( $src_width, $src_height ) = getimagesize( $src );
  list( $width, $height ) = image_constrain_size_for_editor( $src_width, $src_height, $size );
  $hwstring = image_hwstring( $width, $height );
  $class = 'attachment-'.$size.' wp-post-image';
  echo '<img src="'.$src.'" alt="'.$alt.'" '.$hwstring.'class="'.$class.'" srcset="'.$srcset.'">';
}

/* 썸네일: 레티나 */
function akaiv_the_post_thumbnail_srcset($size1x, $size2x) {
  $attr = array( 'srcset' => akaiv_get_post_thumbnail_src( $size2x ).' 2x' );
  the_post_thumbnail( $size1x, $attr );
}

/* 썸네일: 소스 */
function akaiv_get_post_thumbnail_src($size = 'full') {
  $post_thumbnail_id = get_post_thumbnail_id();
  return akaiv_get_attachment_image_src( $post_thumbnail_id, $size );
}

/* 첨부 이미지: 소스 */
function akaiv_get_attachment_image_src($attachment_id, $size = 'full') {
  $image = wp_get_attachment_image_src( $attachment_id, $size );
  list( $src, $width, $height ) = $image;
  return $src;
}

/* 메타 */
function akaiv_entry_meta($meta = null, $icon = '') {
  if ( ! $meta ) return;
  if ( ! empty($icon) ) $icon = '<i class="fa fa-fw '.$icon.'"></i> ';

  if ( $meta == 'category' ) :
    $categories_list = get_the_category_list( ', ' );
    if ( $categories_list ) : ?>
      <span class="cat-links"><?php echo $icon.$categories_list; ?></span><?php
    endif;

  elseif ( $meta == 'tag' ) :
    $tags_list = get_the_tag_list( '', ', ', '' );
    if ( $tags_list ) : ?>
      <span class="tag-links"><?php echo $icon.$tags_list; ?></span><?php
    endif;

  elseif ( $meta == 'date' ) : ?>
    <span class="posted-on"><?php echo $icon; ?><a href="<?php echo get_month_link( get_the_time('Y'), get_the_time('m') ); ?>"><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></a></span><?php

  elseif ( $meta == 'author' ) : ?>
    <span class="author"><?php echo $icon; ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo esc_html( get_the_author() ); ?></a></span><?php

  endif;
}
/* 메타 (커스텀필드) */
function akaiv_post_meta( $meta ) {
  echo akaiv_get_post_meta( $meta );
}
function akaiv_get_post_meta( $meta ) {
  $value = get_post_meta( get_the_ID(), 'wpcf-'.$meta, true );
  return $value;
}

/* 편집 링크 */
function akaiv_edit_post_link($right = false, $icon = '') {
  if ( ! empty($icon) )
    $icon = '<i class="fa fa-fw '.$icon.'"></i> ';
  $before = '<span class="edit-link">'.$icon;
  $after = '</span>';
  if ( $right ) :
    $before = '<div class="text-right">'.$before;
    $after = $after.'</div>';
  endif;
  edit_post_link( '편집', $before, $after );
}

/* 내비게이션 버튼 */
function akaiv_post_nav() {
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

/* 도구: 레티나 이미지 */
function akaiv_retina_image( $filename, $ext = 'png', $alt ) {
  $src    = akaiv_get_image( $filename .    '.' . $ext );
  $srcset = akaiv_get_image( $filename . '@2x.' . $ext . ' 2x' );
  list( $src_width, $src_height ) = getimagesize( $src );
  $hwstring = image_hwstring( $src_width, $src_height );
  echo '<img src="'.$src.'" alt="'.$alt.'" '.$hwstring.'srcset="'.$srcset.'">';
}

/* 도구: 테마 디렉토리의 이미지파일 리턴 */
function akaiv_get_image( $image ) {
  return get_template_directory_uri() . '/images/' . $image;
}
