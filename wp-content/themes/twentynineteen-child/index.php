<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post(); ?>
			
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- 	<header class="entry-header">
			<?php
// 		if ( is_sticky() && is_home() && ! is_paged() ) {
// 			printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'twentynineteen' ) );
// 		}
// 		if ( is_singular() ) :
// 			the_title( '<h1 class="entry-title">', '</h1>' );
// 		else :
// 			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
// 		endif;
		?>
	</header> --><!-- .entry-header -->

	<?php // twentynineteen_post_thumbnail(); ?>

	<div class="entry-wrapper">
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
	</div><!-- .entry-wrapper -->

	<!-- <footer class="entry-footer">
		<?php // twentynineteen_entry_footer(); ?>
	</footer> .entry-footer -->
</article>
			<!-- #post-<?php the_ID(); ?> -->
			<?php }

			// Previous/next page navigation.
			twentynineteen_the_posts_navigation();

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
