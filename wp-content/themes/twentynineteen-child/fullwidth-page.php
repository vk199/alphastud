<?php
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

get_header();
?>

<main id="main" class="site-main">

	<?php
	if ( have_posts() ) {

		// Load posts loop.
		while ( have_posts() ) {
			the_post();?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentynineteen' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'twentynineteen_child' ),
					'after'  => '</div>',
				)
			);
		?>
	</article>
	<!-- #post-<?php the_ID(); ?> -->
	<?php
		}

		// Previous/next page navigation.
		twentynineteen_the_posts_navigation();

	} else {

		// If no content, include the "No posts found" template.
		get_template_part( 'template-parts/content/content', 'none' );

	}
	?>

</main><!-- .site-main -->

<?php
get_footer();

