<?php
/*
Template Name: Blog
*/
define('NO_PAGESECTIONS', TRUE);
define('IS_BLOG', TRUE);

remove_shortcode('subsection');
add_shortcode('subsection', array($us_shortcodes, 'subsection_dummy'));

get_header();
 ?>
<section class="l-section">
	<div class="l-subsection">
		<div class="l-subsection-h g-html i-cf">
		
			<div class="l-content">
				<?php if (have_posts()) : while(have_posts()) : the_post(); ?>
				<h2><?php the_title(); ?></h2>

				<div class="g-hr type_invisible"></div>

				<?php the_content(); ?>
				<?php endwhile; endif; ?>

				<div class="w-blog imgpos_atleft">
					<div class="w-blog-list">
					<?php
					$temp = $wp_query; $wp_query= null;
					$wp_query = new WP_Query(); $wp_query->query(array(
						'post_type' 		=> 'post',
						'post_status' 		=> 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'DESC',
						'paged' 			=> $paged
					));
					while ($wp_query->have_posts()) : $wp_query->the_post();
						if (has_post_thumbnail()) {
							$the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-list');
							$the_thumbnail = $the_thumbnail[0];
						} else {
							$the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
						}
					?>
						<div <?php post_class('w-blog-entry') ?>>
							<div class="w-blog-entry-h">
								<a class="w-blog-entry-link" href="<?php echo get_permalink(get_the_ID());?>">
									<span class="w-blog-entry-preview">
										<img src="<?php echo $the_thumbnail;?>" alt="<?php echo get_the_title();?>">
									</span>
									<h2 class="w-blog-entry-title"><span><?php echo get_the_title();?></span></h2>
								</a>
								<div class="w-blog-entry-body">
									<div class="w-blog-meta">
										<div class="w-blog-meta-date">
											<span class="w-blog-meta-date-month"><?php echo get_the_date('M');?></span>
											<span class="w-blog-meta-date-day"><?php echo get_the_date('d');?></span>
											<span class="w-blog-meta-date-year"><?php echo get_the_date('Y');?></span>
										</div>
									</div>
									<div class="w-blog-entry-short">
										<?php echo apply_filters('the_excerpt', get_the_excerpt());?>
									</div>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
					</div>
				</div>

				<div class="w-blog-pagination">
					<?php
					the_posts_pagination( array(
						'prev_text' => '<',
						'next_text' => '>',
						'before_page_number' => '<span>',
						'after_page_number' => '</span>',
					) );
					?>
				</div>
				<?php
				wp_reset_postdata();
				$wp_query= $temp;
				?>

			</div>
			
			<div class="l-sidebar">
				<?php if (@$smof_data['post_sidebar_pos'] != 'No Sidebar') {
					dynamic_sidebar('default_sidebar');
				} ?>
			</div>

		</div>
	</div>
</section>
<?php
get_footer();