<?php
/**
 * The template for displaying Tags
 */

get_header(); ?>

<div id="main" class="site-main categoryposts" role="main">

	<div id="content" class="site-content">

		<div id="primary" class="content-area">

<?php if ( have_posts() ) : ?>

	<header class="page-header categorytitle">
        <h1 class="archive-title"><?php printf( __( 'Tagged by <em>%s</em>', 'pietergoosen' ), single_tag_title( '', false ) ); ?></h1>
	</header><!-- .page-header -->

<?php while ( have_posts() ) : the_post(); ?>

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
		<?php echo wp_trim_words( get_the_excerpt(), 12, '...' ); ?>
	</div>
	<div class="clearfix"></div>

</article>

			<?php endwhile; ?>

			<?php maker_posts_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	<header class="page-header othertags">
        <h3>All Lahmacun tags</h3>
	</header><!-- .page-header -->

		<div class="taglist">
            <?php
            $tags = get_tags('post_tag'); //taxonomy=post_tag

            if ( $tags ) :
                foreach ( $tags as $tag ) : ?>
                
                <a class="tag" href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" title="<?php echo esc_attr( $tag->name ); ?>">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
                <?php endforeach; ?>
                
            <?php endif; ?>
		</div>

		</div><!-- #primary -->
			
	</div><!-- #content -->
</div><!-- #main -->

<?php get_footer(); ?>