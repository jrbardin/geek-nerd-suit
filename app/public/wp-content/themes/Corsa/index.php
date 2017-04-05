<?php
define('NO_PAGESECTIONS', TRUE);
define('IS_BLOG', TRUE);

get_header();
?>
<section class="l-section">
	<div class="l-subsection">
		<div class="l-subsection-h g-html i-cf">

				<div class="l-content">

					<div class="w-blog imgpos_atleft">
						<div class="w-blog-list">
						<?php while (have_posts()) : the_post();
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