<?php

/**
 * Template Name: Team Archive
 * The template for displaying team content
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 *
 * @package pro
 * @since pro 1.0
 */

get_header(); ?>


	<?php if(get_post_meta($post->ID, 'progression_page_title', true) == 'slider' ) : ?>
		<?php include( get_template_directory() . '/header/slider.php'); ?>
	<?php elseif(get_post_meta($post->ID, 'progression_page_title', true) == 'hide' ) : ?>
	<?php else: ?>
	<div id="soundbyte-page-title">
		<div class="width-container-progression">
			<?php if(function_exists('bcn_display')) { echo '<div id="bread-crumb-container"><div class="breadcrumbs-soundbyte"><ul id="breadcrumbs-pro"><li><a href="'; echo esc_url( home_url( '/' ) ); echo '">'; echo esc_html_e( 'Home', 'soundbyte-progression' );  echo '</a></li>'; bcn_display_list(); echo '</ul><div class="clearfix-progression"></div></div></div>'; }?>
			<?php the_title( '<h1 id="page-title" class="entry-title-pro">', '</h1>' ); ?>
			<?php if(get_post_meta($post->ID, 'progression_sub_title', true)) : ?><h2><?php echo esc_html( get_post_meta($post->ID, 'progression_sub_title', true) );?></h2><?php endif; ?>
		</div>
	</div><!-- #page-title-pro -->
	<?php endif; ?>

<?php		

				//$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
			    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

				$the_query = new WP_Query( array( 
					'posts_per_page' => 1,      //for testing purposes
					'post_type' => 'post',
					'paged' => $paged,
					'meta_query' => array(
					        array(
					            'key' => 'stu_id',
					            'value' => 'twwoodward@me.com', // ########################################look at this
					            'compare' => 'IN'
					        ),
					    )
					)
				  );

				$temp_query = $wp_query;
				$wp_query   = NULL;
				$wp_query   = $the_query;


  

				// The Loop				
				if ( $the_query->have_posts() ) :				
				   echo '<div class="team-content content"><div class="masonry">';
					while ( $the_query->have_posts() ) : $the_query->the_post();
					  $post_id = $post->ID;
					  //image previews across top 
					   echo '<div class="item"><a href="' . get_permalink() . '">';
					   echo get_the_post_thumbnail($post_id,'medium', array( 'class' => 'aligncenter personal-big' ));
					   echo '</a><h3><a href="' . get_permalink() . '">';
	        		   echo get_the_title();
	        		   echo '</a></h3>';
	        		   echo '<div class="meta">' . get_the_date() . '</div>';
					   
					   echo the_excerpt() . '</div>';
					endwhile;

				    echo '</div>';
				endif;
				// Reset Post Data
				wp_reset_postdata();
			
			// Custom query loop pagination

			echo '<div class="nav"><div class="previous">' . previous_posts_link( 'Older Posts', $the_query->max_num_pages ) . '</div>';
			echo '<div class="nav"><div class="previous">' . next_posts_link( 'Newer Posts', $the_query->max_num_pages ) . '</div>';
			echo '</div>';

			// Reset main query object
			$wp_query = NULL;
		    $wp_query = $temp_query;
				?>
	<div id="content-pro"<?php if(get_post_meta($post->ID, 'progression_page_title', true) == 'hide' ) : ?> class="no-padding-pro"<?php endif; ?>>
		<div class="width-container-progression<?php if(get_post_meta($post->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?> left-sidebar-pro<?php endif; ?>">

			<?php if(get_post_meta($post->ID, 'progression_page_sidebar', true) == 'right-sidebar' ) : ?><div id="soundbyte-sidebar-container"><?php endif; ?>
			<?php if(get_post_meta($post->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?><div id="soundbyte-sidebar-container"><?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php endwhile; ?>

			<?php if(get_post_meta($post->ID, 'progression_page_sidebar', true) == 'right-sidebar' ) : ?></div><!-- close #soundbyte-sidebar-container --><?php get_sidebar(); ?><?php endif; ?>
			<?php if(get_post_meta($post->ID, 'progression_page_sidebar', true) == 'left-sidebar' ) : ?></div><!-- close #soundbyte-sidebar-container --><?php get_sidebar(); ?><?php endif; ?>

		<div class="clearfix-progression"></div>
		</div><!-- close .width-container-pro -->
	</div><!-- #content-pro -->

<?php get_footer(); ?>
