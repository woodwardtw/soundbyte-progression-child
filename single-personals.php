<?php
/**
 * The template for displaying all single posts.
 *
 * @package pro
 */

get_header(); ?>

	<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?>

	<?php if(get_post_meta($cover_page->ID, 'progression_page_title', true) == 'hide' ) : ?><?php else: ?>
		<div id="soundbyte-page-title">
			<div class="width-container-progression">
				<?php if(function_exists('bcn_display')) { echo '<div id="bread-crumb-container"><div class="breadcrumbs-soundbyte"><ul id="breadcrumbs-pro"><li><a href="'; echo esc_url( home_url( '/' ) ); echo '">'; echo esc_html_e( 'Home', 'soundbyte-progression' );  echo '</a></li>'; bcn_display_list(); echo '</ul><div class="clearfix-progression"></div></div></div>'; }?>
				<h1 id="page-title" class="entry-title-pro"><?php $page_for_posts = get_option('page_for_posts'); ?><?php echo get_the_title($page_for_posts); ?></h1>
				<?php if(get_post_meta($cover_page->ID, 'progression_sub_title', true)) : ?><h2><?php echo esc_html( get_post_meta($cover_page->ID, 'progression_sub_title', true) );?></h2><?php endif; ?>
			</div>
		</div><!-- #page-title-pro -->
	<?php endif; ?>
	<?php else: ?>
		<div id="soundbyte-page-title" style="background-image:url(<?php
				the_post_thumbnail_url(); ?>) !important">
			<div class="width-container-progression">
				<h1 id="page-title" class="entry-title-pro"><?php the_title(); ?></h1>
			</div>
		</div><!-- #page-title-pro -->
	<?php endif; ?>

	<div id="content-pro" class="site-content">
		<div class="width-container-progression<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?><?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?> left-sidebar-pro<?php endif; ?><?php endif; ?>">

				<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?>
				<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'right-sidebar' ) : ?><div id="soundbyte-sidebar-container"><?php endif; ?>
				<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?><div id="soundbyte-sidebar-container"><?php endif; ?>
				<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

				<!-- ######################  stuff to show the student or course content ######################### -->
				<?php 
				$stu_id = get_post_meta( get_the_ID(), 'stu_id', true );
				// Check if the custom field has a value.				

				$the_query = new WP_Query( array( 'tag' => $stu_id ) );

				// The Loop
				if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) : $the_query->the_post();
				  $post_id = $post->ID;
        		   echo get_the_post_thumbnail($post_id,'medium');
				endwhile;
				endif;
				// Reset Post Data
				wp_reset_postdata();

				?>

			<?php endwhile; // end of the loop. ?>

			<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?>
			<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'right-sidebar' ) : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
			<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
			<?php endif; ?>

		<div class="clearfix-progression"></div>
		</div><!-- close .width-container-pro -->
	</div><!-- #content-pro -->
<?php get_footer(); ?>
