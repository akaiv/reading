<?php akaiv_before_page(); ?>

<header class="entry-header">
  <h1 class="entry-title">
    <a href="<?php akaiv_the_url(); ?>" target="_blank" rel="bookmark"><?php akaiv_the_title(); ?></a>
  </h1>
</header>
<div class="entry-summary">
  <p><?php the_excerpt(); ?></p>
</div>
<div class="entry-meta">
  <?php akaiv_post_meta( 'category' ); ?>
  <?php akaiv_the_url_hostname(); ?>
  <?php akaiv_post_meta( 'tag' ); ?>
  <?php akaiv_post_meta( 'date' ); ?>
  <?php akaiv_edit_post_link(); ?>
</div>

<?php akaiv_after_page(); ?>
