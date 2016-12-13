<?php
/**
 * Template Name: Favs page
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
				
				<?php 
				$the_favs = get_user_favorites($user_id = null, $site_id = null, $filters = null);
				$fav_number = count($the_favs);
				$i = 0;
				echo '<div class="team-content"><div class="masonry">';

				while ($i <= $fav_number-1) {

					$fav_id = $the_favs[$i];	
					echo '<div class="item">';
					echo '<a href="' . get_the_permalink($fav_id) . '"';
					echo get_the_title($fav_id) . '<br>';
					$fav_img = get_the_post_thumbnail($fav_id, 'large' );
					if ($fav_img){
						echo $fav_img;
					}
					else {
						echo 'fish';
					}
					
					echo '</a></div>';
					$i++;

			     }
			     echo '</div></div>';
				?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php if( get_option( 'page_for_posts' ) ) : $cover_page = get_page( get_option( 'page_for_posts' ) ); ?>
			<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'right-sidebar' ) : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
			<?php if(get_post_meta($cover_page->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?></div><!-- close #main-container-pro --><?php get_sidebar(); ?><?php endif; ?>
			<?php endif; ?>

		<div class="clearfix-progression"></div>
		</div><!-- close .width-container-pro -->
	</div><!-- #content-pro -->
<?php get_footer(); ?>
