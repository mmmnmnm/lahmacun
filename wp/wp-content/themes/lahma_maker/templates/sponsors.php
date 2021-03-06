<?php
/**
 * The template for displaying Sponsors pages.
 *
 * Template Name: Sponsors
 *
 * @package Maker
 */

get_header(); ?>

<div id="main" class="site-main" role="main">
	<div id="content" class="site-content">
		<div id="primary" class="content-area fullwidth sponsors">

			<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', 'page' );

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}

				endwhile;
			?>

		</div>
	</div><!-- #content -->
</div><!-- #main -->

<?php get_footer(); ?>
