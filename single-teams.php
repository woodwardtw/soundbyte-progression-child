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
				</div>
				<?php
				$gss_url = get_post_meta( get_the_ID(), 'gss_url', true ); //get custom field value 
				$regGoog = preg_match("/\/[A-Za-z]\/(.*)\//", $gss_url, $match);	//regex match to get doc ID			
				
				if ($regGoog){
				$googleId = strval($match[1]);
				$json_gss = 'https://spreadsheets.google.com/feeds/list/'. $googleId . '/1/public/basic?alt=json';
					}
				// Check if the custom field has a value.				
				
				$json = @file_get_contents($json_gss);

				if ( $json === false )
					{
					   echo '<div class="warning">Looks like your Google spreadsheet might not be public or maybe the formatting is incorrect.<br> Try going back to the spreadsheet and choosing <em>File>Publish to the web.</em></div>';
					} else {
    								
				$data = json_decode($json, TRUE);
				$teamMembers = [];
				//print_r($obj);
				foreach ($data['feed']['entry'] as $item) {
				  array_push($teamMembers, $item['title']['$t']);  
				}

				$stu_id = get_post_meta( get_the_ID(), 'stu_id', true );
				// Check if the custom field has a value.		
			    
				?>

				<?php	

				if ($json){	

			    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

				$the_query = new WP_Query( array( 
					'posts_per_page' => 25, 
					'orderby' => 'date',     
					'post_type' => 'post',
					'nopaging' => false,   //(bool) - show all posts or use pagination. Default value is 'false', use paging.
    				'paged' => $paged,
					'meta_query' => array(
					        array(
					            'key' => 'stu_id',
					            'value' => $teamMembers, // ########################################look at this
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
				   echo '<div class="team-content"><div class="masonry">';
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

				    echo '</div></div>';
				endif;
				// Reset Post Data
				wp_reset_postdata();
			}
			// Custom query loop pagination
			echo '<div class="navigation">';
			if (previous_posts_link()){
				echo previous_posts_link( '<div class="back"><< Back', $the_query->max_num_pages ) . '</div>';
			}
			echo next_posts_link( '<div class="next">Next >>', $the_query->max_num_pages .'</div>' );
			echo '</div>';


			

			// Reset main query object
			$wp_query = NULL;
		    $wp_query = $temp_query;
		}
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
