<?php
/**
 * The template for displaying Categories
 */

get_header(); ?>

<div id="main" class="site-main categoryposts shows-archive" role="main">

	<div id="content" class="site-content">

		<div id="primary" class="content-area">

<?php
$args = array(
    'orderby' => 'name',
	'order'   => 'ASC',
	'category_name' => 'shows'
);
$query = new WP_Query( $args ); 

if ( $query->have_posts() ) : 
    
?>

<header class="page-header categorytitle" id="activeshows">

	<?php echo '<h1 class="page-title">Active shows</h1>';	?>

</header><!-- .page-header -->

<?php while ( $query->have_posts() ) : $query->the_post(); ?>

<article class="postslister shows">
	<h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_post_thumbnail()) : ?>
		<div class="newspic-container">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="newsimage">
		<?php the_post_thumbnail("nav_thumb"); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="description">
		<?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?>
	</div>
	<div class="clearfix"></div>

</article>

			<?php endwhile; ?>

			<?php maker_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

<?php wp_reset_query(); ?>

<?php
$args = array(
    'orderby' => 'name',
	'order'   => 'ASC',
	'category_name' => 'past-shows'
);
$query = new WP_Query( $args ); 

if ( $query->have_posts() ) : 
    
?>

	<header class="page-header categorytitle" id="pastshows">

		<?php echo '<h1 class="page-title">Past shows</h1>';	?>

	</header><!-- .page-header -->

<?php while ( $query->have_posts() ) : $query->the_post(); ?>

<article class="postslister shows">
	<h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_post_thumbnail()) : ?>
		<div class="newspic-container">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="newsimage">
		<?php the_post_thumbnail("nav_thumb"); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="description">
		<?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?>
	</div>
	<div class="clearfix"></div>

</article>

			<?php endwhile; ?>

			<?php maker_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- #primary -->

	</div><!-- #content -->

</div><!-- #main -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>