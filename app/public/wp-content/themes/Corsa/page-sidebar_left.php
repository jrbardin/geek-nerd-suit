<?php
/*
Template Name: Page: Sidebar Left
*/
define('NO_PAGESECTIONS', TRUE);
define('SIDEBAR_POS', 'left');

remove_shortcode('subsection');
add_shortcode('subsection', array($us_shortcodes, 'subsection_dummy'));

get_header();
if (have_posts()) : while(have_posts()) : the_post(); ?>
<section class="l-section">
	<div class="l-subsection">
		<div class="l-subsection-h g-html i-cf">

			<div class="l-content">

				<h2><?php the_title(); ?></h2>

				<div class="g-hr type_invisible"></div>

				<?php the_content(); ?>
				<?php
				$link_pages_args = array(
					'before'           => '<div class="w-blog-pagination"><nav class="navigation pagination" role="navigation">',
					'after'            => '</nav></div>',
					'next_or_number'   => 'next_and_number',
					'nextpagelink'     => '>',
					'previouspagelink' => '<',
					'link_before'      => '<span>',
					'link_after'       => '</span>',
					'echo'             => 1
				);
				if (function_exists('us_wp_link_pages')) {
					us_wp_link_pages($link_pages_args);
				} else {
					wp_link_pages();
				}
				?>
			</div>
			
			<div class="l-sidebar">
				<?php generated_dynamic_sidebar(); ?>
			</div>

		</div>
	</div>
</section>
<?php endwhile; endif;
get_footer();
