<?php
/**
 * @package pro
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-container-progression featured-blog-single">

		<?php if(get_post_meta($post->ID, 'pro_gallery', true) ): ?>
			<div class="featured-blog-progression">
				<div class="flexslider gallery-progression">
		      		<ul class="slides">
						<?php $gallery_pro = get_post_meta( get_the_id(), 'pro_gallery', false ); ?>
						<?php if($gallery_pro):  foreach($gallery_pro as $single_gallery_img): ?>
							<?php $image = wp_get_attachment_image_src($single_gallery_img, 'progression-blog'); ?>
							<?php $thumbnail = wp_get_attachment_image_src($single_gallery_img, 'large'); ?>
							<li class="gallery-item">
								<a href="<?php echo esc_attr($thumbnail[0]);?>" data-rel="prettyPhoto[gallery]"><img src="<?php echo esc_attr($image[0]);?>" alt="<?php echo esc_html_e('Photo', 'soundbyte-progression');?>-<?php echo esc_attr($single_gallery_img); ?>"></a>
							</li>
						<?php endforeach; endif; ?>
					</ul>
				</div><!-- close .flexslider -->
			</div><!-- close .single-blog-progression -->
		<?php else: ?>
			<?php if(get_post_meta($post->ID, 'pro_video_post', true)): ?>
				<div class="featured-blog-progression"><?php echo apply_filters('the_content', get_post_meta($post->ID, 'pro_video_post', true)); ?></div>
			<?php else: ?>
					<!--<?php if(has_post_thumbnail()): ?><?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large'); ?><div class="featured-blog-progression">
						<a href="<?php echo esc_attr($image[0]);?>" data-rel="prettyPhoto"><?php the_post_thumbnail('progression-blog'); ?></a></div><?php endif; ?>-->
			<?php endif; ?>
		<?php endif; ?>
		<div class="clearfix-progression"></div>
		<!--<h2 class="blog-title-progression"><?php the_title(); ?></h2>-->
		

		<div class="summary-post-progression"><?php the_content(); ?></div>

		<?php if ( 'post' == get_post_type() ) : ?>
					<div class="soundbyte-divider-progression"></div>

			<div class="category-meta-progression"><?php the_category(', '); ?></div>
			<div class="post-meta-progression">
				<span class="soundbyte-date-progression"><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php the_time(get_option('date_format')); ?></a></span>
				 <span class="author-meta-progression"><?php the_author_posts_link(); ?></span>
				<span class="meta-comments-progression"><?php comments_popup_link( '' . esc_html__( 'No Comments', 'soundbyte-progression' ) . '', esc_html__( '1 Comment', 'soundbyte-progression' ), esc_html__( '% Comments', 'soundbyte-progression' ) ); ?></span>
			</div>
		<?php endif; ?>

		<?php the_tags( '<div class="tags-progression"><i class="fa fa-tag"></i>', '', '</div>' ); ?>

		<div class="clearfix-progression"></div>
		<?php wp_link_pages( array(
				'before' => '<div class="page-nav-progression">' . esc_html__( 'Pages:', 'soundbyte-progression' ),
				'after'  => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>

	<div class="clearfix-progression"></div>
	</div><!-- close .post-container-pro -->
</article><!-- #post-## -->

<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
