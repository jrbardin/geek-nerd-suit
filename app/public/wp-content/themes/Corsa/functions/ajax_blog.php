<?php

if ( ! function_exists('blogAjaxPagination'))
{
	function blogAjaxPagination() {
		global $smof_data, $us_thumbnail_size;

		if (isset($_POST['page']) AND $_POST['page'] > 1)
		{
			$page = intval($_POST['page']);
		}
		else
		{
			return;
		}

		$posts = new WP_Query();

		$category_param = $lang_param = $per_page_param = '';

		if (defined('ICL_LANGUAGE_CODE'))
		{
			$lang_param = '&lang=' . ICL_LANGUAGE_CODE;
		}

		if ( isset($_POST['per_page']) ) {
			$per_page_param = '&posts_per_page=' . intval($_POST['per_page']);
		}

		if ( isset($_POST['category']) ) {
			$category_param = '&category_name=' . trim($_POST['category']);
		}

//echo 'paged='.$page.'&post_type=post'.$per_page_param.$lang_param;
		$posts->query('paged='.$page.'&post_type=post&post_status=publish'.$per_page_param.$lang_param.$category_param);

		$output = '';

		while($posts->have_posts())
		{
			$posts->the_post();

			if (has_post_thumbnail()) {
				$the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-list');
				$the_thumbnail = $the_thumbnail[0];
			} else {
				$the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
			}

			$output .= 			'<div class="w-blog-entry">
									<div class="w-blog-entry-h">
										<a class="w-blog-entry-link" href="'.get_permalink(get_the_ID()).'">
											<span class="w-blog-entry-preview">
												<img src="'.$the_thumbnail.'" alt="">
											</span>
											<h2 class="w-blog-entry-title"><span>'.get_the_title().'</span></h2>
										</a>
										<div class="w-blog-entry-body">
											<div class="w-blog-meta">
												<div class="w-blog-meta-date">
													<span class="w-blog-meta-date-month">'.get_the_date('M').'</span>
													<span class="w-blog-meta-date-day">'.get_the_date('d').'</span>
													<span class="w-blog-meta-date-year">'.get_the_date('Y').'</span>
												</div>
											</div>
											<div class="w-blog-entry-short">
												'.apply_filters('the_excerpt', get_the_excerpt()).'
											</div>
										</div>
									</div>
								</div>';
		}

		echo $output;

		die();

	}

	add_action( 'wp_ajax_nopriv_blogPagination', 'blogAjaxPagination' );
	add_action( 'wp_ajax_blogPagination', 'blogAjaxPagination' );
}
