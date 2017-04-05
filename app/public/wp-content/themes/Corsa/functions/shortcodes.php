<?php

// Avoid direct calls to this file where wp core files not present
if (!function_exists ('add_action')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

$auto_open = FALSE;
$first_tab = FALSE;
$first_tab_title = FALSE;

class US_Shortcodes {

	public function __construct()
	{
		add_filter('the_content', array($this, 'paragraph_fix'));
		add_filter('the_content', array($this, 'subsections_fix'));
		add_filter('the_content', array($this, 'a_to_img_magnific_pupup'));

		add_shortcode('row', array($this, 'row'));
		add_shortcode('one_half', array($this, 'one_half'));
		add_shortcode('one_third', array($this, 'one_third'));
		add_shortcode('two_third', array($this, 'two_third'));
		add_shortcode('one_quarter', array($this, 'one_quarter'));
		add_shortcode('three_quarter', array($this, 'three_quarter'));
		add_shortcode('one_fourth', array($this, 'one_fourth'));
		add_shortcode('three_fourth', array($this, 'three_fourth'));

		add_shortcode('subsection', array($this, 'subsection'));

		add_shortcode('button', array($this, 'button'));

		add_shortcode('tabs', array($this, 'tabs'));
		add_shortcode('accordion', array($this, 'accordion'));
		add_shortcode('toggle', array($this, 'toggle'));
		add_shortcode('item', array($this, 'item'));
		add_shortcode('item_title', array($this, 'item_title'));

		add_shortcode('separator', array($this, 'separator'));

		add_shortcode('icon', array($this, 'icon'));
		add_shortcode('iconbox', array($this, 'iconbox'));

		add_shortcode('testimonial', array($this, 'testimonial'));

		add_shortcode('team', array($this, 'team'));
		add_shortcode('member', array($this, 'member'));

		remove_shortcode('gallery');
		add_shortcode('gallery', array($this, 'gallery'));

		add_shortcode('simple_slider', array($this, 'simple_slider'));
		add_shortcode('simple_slide', array($this, 'simple_slide'));

		add_shortcode('portfolio', array($this, 'portfolio'));
		add_shortcode('blog', array($this, 'blog'));

		add_shortcode('home_heading', array($this, 'home_heading'));
		add_shortcode('heading_line', array($this, 'heading_line'));

		add_shortcode('contacts', array($this, 'contacts'));
		add_shortcode('contact_item', array($this, 'contact_item'));
		add_shortcode('contacts_form', array($this, 'contacts_form'));

		add_shortcode('subtitle', array($this, 'subtitle'));
		add_shortcode('paragraph_big', array($this, 'paragraph_big'));
		add_shortcode('highlight', array($this, 'highlight'));

		add_shortcode('pricing_table', array($this, 'pricing_table'));
		add_shortcode('pricing_column', array($this, 'pricing_column'));
		add_shortcode('pricing_row', array($this, 'pricing_row'));
		add_shortcode('pricing_footer', array($this, 'pricing_footer'));

		add_shortcode('responsive_video', array($this, 'responsive_video'));
		add_shortcode('clients', array($this, 'clients'));

		add_shortcode('actionbox', array($this, 'actionbox'));
		add_shortcode('counter', array($this, 'counter'));
		add_shortcode('social_links', array($this, 'social_links'));
		add_shortcode('message_box', array($this, 'message_box'));

		add_shortcode('fullscreen_slider', array($this, 'fullscreen_slider'));
		add_shortcode('fullscreen_slide', array($this, 'fullscreen_slide'));

		add_shortcode('gmaps', array($this, 'gmaps'));
	}

	public function paragraph_fix($content)
	{
		$array = array (
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
			']<br>' => ']',
		);

		$content = strtr($content, $array);
		return $content;
	}

	public function subsections_fix($content)
	{
		$link_pages_args = array(
			'before'           => '<div class="w-blog-pagination"><nav class="navigation pagination" role="navigation">',
			'after'            => '</nav></div>',
			'next_or_number'   => 'next_and_number',
			'nextpagelink'     => '>',
			'previouspagelink' => '<',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'echo'             => 0,
		);

		if (strpos($content, '[subsection') !== FALSE)
		{
			$content = strtr($content, array('[subsection' => '[/subsection automatic_end_subsection="1"][subsection'));

			$content = strtr($content, array('[/subsection]' => '[/subsection][subsection]'));

			$content = strtr($content, array('[/subsection automatic_end_subsection="1"]' => '[/subsection]'));

			$content = '[subsection]'.$content.us_wp_link_pages($link_pages_args).'[/subsection]';
		}
		else
		{
			$content = '[subsection]'.$content.us_wp_link_pages($link_pages_args).'[/subsection]';
		}

		$content = preg_replace('%\[subsection\](\\s)*\[/subsection\]%i', '', $content);//echo '<textarea>'.$content.'</textarea>';

		return $content;
	}

	public function a_to_img_magnific_pupup ($content)
	{
		$pattern = "/<a(.*?)href=('|\")([^>]*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
		$replacement = '<a$1ref="magnificPopup" href=$2$3.$4$5$6>';
		$content = preg_replace($pattern, $replacement, $content);

		return $content;
	}

	public function subsection($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'color' => '',
				'full_width' => FALSE,
				'full_height' => FALSE,
				'full_screen' => FALSE,
				'valign_center' => FALSE,
				'background' => FALSE,
				'parallax' => FALSE,
				'video' => FALSE,
				'video_mp4' => FALSE,
				'video_ogg' => FALSE,
				'video_webm' => FALSE,

			), $attributes);

		$output_type = ($attributes['color'] != '')?' color_'.$attributes['color']:'';
		$full_width_type = ($attributes['full_width'] == 1)?' full_width':'';
		$full_height_type = ($attributes['full_height'] == 1)?' full_height':'';
		$full_screen_type = ($attributes['full_screen'] == 1)?' full_screen':'';
		$valign_center_type = ($attributes['valign_center'] == 1)?' valign_center':'';
		$background_style = '';
		if ($attributes['background'] != '')
		{
			if (is_numeric($attributes['background']))
			{
				$img_id = preg_replace('/[^\d]/', '', $attributes['background']);
				$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'full' ));

				if ( $img != NULL )
				{
					$img = wp_get_attachment_image_src( $img_id, 'full');
					$img = $img[0];
				}

				$background_style = ' style="background-image: url('.$img.')"';
			}
			else
			{
				$background_style = ' style="background-image: url('.$attributes['background'].')"';
			}

		}

		$parallax_class = '';
		$parallax_data_output = '';
		if ($attributes['parallax']) {
			// We need parallax script for this, but only once per page
			if ( ! wp_script_is('us-parallax', 'enqueued')){
				wp_enqueue_script('us-parallax');
			}
			$parallax_class = ' with_parallax';
//			$parallax_data_output = ' data-prlx-xpos="50%" data-prlx-speed="'.$attributes['parallax_speed'].'"';
		}

		$video_html = $video_class = '';

		if ($attributes['video'] AND ($attributes['video_mp4'] != '' OR $attributes['video_ogg'] != '' OR $attributes['video_webm'] != '' )) {
			// We need mediaelement script for this, but only once per page
			if ( ! wp_script_is('us-mediaelement', 'enqueued')){
				wp_enqueue_script('us-mediaelement');
			}
			$video_class = ' with_video';
			$parallax_class = '';
			$video_mp4_part = ($attributes['video_mp4'] != '')?'<source type="video/mp4" src="'.$attributes['video_mp4'].'"></source>':'';
			$video_ogg_part = ($attributes['video_ogg'] != '')?'<source type="video/ogg" src="'.$attributes['video_ogg'].'"></source>':'';
			$video_webm_part = ($attributes['video_webm'] != '')?'<source type="video/webm" src="'.$attributes['video_webm'].'"></source>':'';
			$video_poster_part = ($attributes['background'] != '')?' poster="'.$attributes['background'].'"':'';
			$video_img_part = ($attributes['background'] != '')?'<img src="'.$attributes['background'].'" alt="">':'';
			$video_html = '<div class="video-background"><video loop="loop" autoplay="autoplay" preload="auto"'.$video_poster_part.'>'.$video_mp4_part.$video_ogg_part.$video_webm_part.$video_img_part.'</video></div>';
		}


		$output =	'<div class="l-subsection'.$full_height_type.$full_width_type.$full_screen_type.$valign_center_type.
					 $output_type.$parallax_class.$video_class.'"'.$background_style.$parallax_data_output.'>'.
			$video_html.
			'<div class="l-subsection-h g-html i-cf">'.
			do_shortcode($content).
			'</div>'.
			'</div>';

		return $output;
	}

	public function subsection_dummy ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'type' => FALSE,
				'with' => FALSE,

			), $attributes);

		$output = do_shortcode($content);

		return $output;
	}

	public function gmaps ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'address' => '',
				'latitude' => '',
				'longitude' => '',
				'marker' => '',
				'height' => 400,
				'zoom' => 13,
				'type' => 'ROADMAP',
				'api_key' => '',

			), $attributes);

		$map_id = rand(99999, 999999);

		if ($attributes['latitude'] != '' AND $attributes['longitude'] != '') {
			$map_location_options = 'latitude: "'.$attributes['latitude'].'", longitude: "'.$attributes['longitude'].'", ';
		} elseif ($attributes['address'] != '') {
			$map_location_options = 'address: "'.$attributes['address'].'", ';
		} else {
			return null;
		}

		$map_marker_options = '';
		if ($attributes['marker'] != '') {
			$map_marker_options = 'html: "'.$attributes['marker'].'", popup: true';
		}


		// Enqueued the script only once
		if ( $attributes['api_key'] != '' ) {
			wp_register_script( 'us-google-maps-with-key', '//maps.googleapis.com/maps/api/js?key=' . $attributes['api_key'], array(), '', FALSE );
			wp_enqueue_script( 'us-google-maps-with-key' );
		} else {
			wp_enqueue_script('us-google-maps');
		}
		wp_enqueue_script('us-gmap');

		$output = '<div class="w-map" id="map_'.$map_id.'" style="height: '.$attributes['height'].'px">
				<div class="w-map-h">

				</div>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#map_'.$map_id.'").gMap({
						'.$map_location_options.'
						zoom: '.$attributes['zoom'].',
						maptype: "'.$attributes['type'].'",
						markers:[
							{
								'.$map_location_options.$map_marker_options.'
							}
						]
					});
				});
			</script>';

		return $output;
	}

	public function simple_slider($attributes, $content = null)
	{
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty($attributes['ids']))
		{
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attributes['orderby'] ) )
			{
				$attributes['orderby'] = 'post__in';
			}
			$attributes['include'] = $attributes['ids'];
		}

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attributes['orderby'] ) )
		{
			$attributes['orderby'] = sanitize_sql_orderby( $attributes['orderby'] );
			if ( !$attributes['orderby'] )
			{
				unset( $attributes['orderby'] );
			}
		}

		extract(shortcode_atts(array(
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
			'id' => $post->ID,
			'include' => '',
			'exclude' => '',
			'auto_rotation' => null,
			'arrows' => null,
			'nav' => null,
			'transition' => null,
			'fullscreen' => null,
			'stretch' => null,
			'width' => null,
			'height' => null,
		), $attributes));

		$size = 'gallery-s';

		$id = intval($id);

		if ( ! empty($include) )
		{
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			if (is_array($_attachments))
			{
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			}
		}
		elseif ( ! empty($exclude) )
		{
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		$data_autoplay = '';
		if ($auto_rotation == 'yes' OR $auto_rotation == 1) {
			$data_autoplay = ' data-autoplay="true"';
		}

		$data_arrows = ' data-arrows="always"';
		if ($arrows == 'hide') {
			$data_arrows = ' data-arrows="false"';
		} elseif ($arrows == 'hover') {
			$data_arrows = ' data-arrows="true"';
		}

		$data_nav =  ' data-nav="none"';
		if ($nav == 'dots') {
			$data_nav = ' data-nav="dots"';
		} elseif ($nav == 'thumbs') {
			$data_nav = ' data-nav="thumbs"';
		}

		$data_transition =  ' data-transition="slide"';
		if ($transition == 'fade') {
			$data_transition = ' data-transition="crossfade"';
		} elseif ($transition == 'dissolve') {
			$data_transition = ' data-transition="dissolve"';
		}

		$data_allowfullscreen = '';
		if ($fullscreen == 'yes' OR $fullscreen == 1) {
			$data_allowfullscreen = ' data-allowfullscreen="true"';
		}

		$data_fit = '';
		if ($stretch == 'yes' OR $stretch == 1) {
			$data_fit = ' data-fit="cover"';
		}elseif ($stretch == 'none'){
			$data_fit = ' data-fit="none"';
		}

		$data_width = '';
		if ($width === NULL){
			$data_width = ' data-width="100%"';
		}else{
			$data_width = ' data-width="'.$width.'"';
		}

		$data_height = '';
		if ($height !== NULL){
			$data_height = ' data-height="'.$height.'"';
		}

		$rand_id = rand(100000, 999999);

		$i = 1;
		$attachments_output = '';
		$data_ratio = '';
		if (isset($attachments) AND is_array($attachments))
		{
			foreach ( $attachments as $id => $attachment ) {
				if ($data_ratio == null) {
					$first_img =  wp_get_attachment_image_src( $id, 'full' );
					if (is_array($first_img)) {
						$data_ratio = ' data-ratio="'.$first_img[1].'/'.$first_img[2].'"';
					} else {
						$data_ratio = -1;
					}
				}

				$attachments_output .= '<a href="'.wp_get_attachment_url($id).'">';
				$attachments_output .= wp_get_attachment_image( $id, $size, 0 );
				$attachments_output .= '</a>';

				$i++;
			}

			if ($data_ratio == -1 OR $data_ratio == ' data-ratio="/"') {
				$data_ratio = '';
			}
		}

		// We need fotorama script for this, but only once per page
		if ( ! wp_script_is('us-fotorama', 'enqueued')){
			wp_enqueue_script('us-fotorama');
		}

		$output = '<div class="w-slider">
						<div class="fotorama" id="slider_'.$rand_id.'"
							data-shadows="false"
							data-glimpse="0"
							data-margin="0"
							data-loop="true"
							data-swipe="true"'.$data_width.$data_height.$data_autoplay.$data_arrows.$data_nav.$data_transition.
							$data_allowfullscreen.$data_fit.$data_ratio.'>'.
							$attachments_output.do_shortcode($content).
						"</div>
					</div>";

		return $output;
	}

	public function simple_slide($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'img' => '',
				'alt' => '',
			), $attributes);

		$output = 	'<a href="'.$attributes['img'].'"><img src="'.$attributes['img'].'" alt="'.$attributes['alt'].'"></a>';

		return $output;
	}

	public function fullscreen_slider($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'interval' => 5000,
				'transition' => 2,
				'speed' => 400,
			), $attributes);

		global $first_slide;
		$first_slide = TRUE;

		$interval = (is_numeric($attributes['interval']))?round($attributes['interval']):5000;
		$speed = (is_numeric($attributes['speed']))?round($attributes['speed']):400;
		$transition = (in_array($attributes['transition'], array(0, 1, 2, 3, 4, 5, 6, 7)))?$attributes['transition']:2;

		$output = '<div class="us_supersized">
						<a id="prevslide" class="load-item"><i class="fa fa-chevron-left"></i></a>
						<a id="nextslide" class="load-item"><i class="fa fa-chevron-right"></i></a>
						<div class="slidecaption">
							<div id="slidecaption"></div>
						</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery.supersized({
								// Functionality
								slide_interval : '.$interval.', // Length between transitions
								transition : '.$transition.', // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
								transition_speed : '.$speed.', // Speed of transition
								// Components
								slides  : [ // Slideshow Images
									'.do_shortcode($content).'
								]
							});
						});
					</script>';

		return $output;
	}

	public function fullscreen_slide($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'img' => '',
			), $attributes);

		global $first_slide;
		if ( ! $first_slide) {
			$output = ',';
		} else {
			$output = '';
		}
		$first_slide = FALSE;

		$output .= '{thumb: "", image: "'.$attributes['img'].'", title: "'.trim(str_replace('"', "'", preg_replace('/\s+/', ' ', do_shortcode($content)))).'", url: ""}';

		return $output;
	}

	public function actionbox ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'color' => '',
				'title' => 'ActionBox title',
				'description' => '',
				'btn_label' => '',
				'btn_link' => '',
				'btn_color' => 'default',
				'btn_size' => '',
				'btn_icon' => '',
				'btn_external' => '',
			), $attributes);

		$color_class = ($attributes['color'] != '')?' color_'.$attributes['color']:'';


		$output = 	'<div class="w-actionbox '.$color_class.'">'.
						'<div class="w-actionbox-text">';
		if ($attributes['title'] != '')
		{
			$output .= 			'<h3>'.html_entity_decode($attributes['title']).'</h3>';
		}
		if ($attributes['description'] != '')
		{
			$output .= 			'<p>'.html_entity_decode($attributes['description']).'</p>';
		}
		$output .=		'</div>'.
						'<div class="w-actionbox-controls">';
		if ($attributes['btn_label'] != '' AND $attributes['btn_link'] != '')
		{
			$colour_class = ($attributes['btn_color'] != '')?' color_'.$attributes['btn_color']:'';
			$size_class = ($attributes['btn_size'] != '')?' size_'.$attributes['btn_size']:'';
			$icon_part = ($attributes['btn_icon'] != '')?'<i class="fa fa-'.$attributes['btn_icon'].'"></i>':'';
			$external_part = ($attributes['btn_external'] == 1)?' target="_blank"':'';
			$output .= 			'<a class="w-actionbox-button g-btn'.$size_class.$colour_class.'" href="'.$attributes['btn_link'].'"'.$external_part.'><span>'.$icon_part.$attributes['btn_label'].'</span></a>';
		}
		$output .=		'</div>'.
					'</div>';
		return $output;
	}

	public function counter ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'count' => '99',
				'suffix' => '',
				'prefix' => '',
				'title' => '',
			), $attributes);

		$output = 	'<div class="w-counter" data-count="'.$attributes['count'].'" data-prefix="'.$attributes['prefix'].'" data-suffix="'.$attributes['suffix'].'">
						<div class="w-counter-h">
							<div class="w-counter-number">'.$attributes['prefix'].$attributes['count'].$attributes['suffix'].'</div>
							<h6 class="w-counter-title">'.$attributes['title'].'</h6>
						</div>
					</div>';

		return $output;

	}

	public function responsive_video ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'link' => 'http://vimeo.com/23237102',

			), $attributes);

		$regexes = array (
			array (
				'regex' => '~
        https?://
        (?:[0-9A-Z-]+\.)?
        (?:
          youtu\.be/
        | youtube
          (?:-nocookie)?
          \.com
          \S*
          [^\w\s-]
        )
        ([\w-]{11})
        (?=[^\w-]|$)
        (?!
          [?=&+%\w.-]*
          (?:
            [\'"][^<>]*>
          | </a>
          )
        )
        [?=&+%\w.-]*
        ~ix',
				'provider' => 'youtube',
				'id' => 1,
			),
			array (
				'regex' => '/^http(?:s)?:\/\/(?:.*?)\.?vimeo\.com\/(\d+).*$/i',
				'provider' => 'vimeo',
				'id' => 1,
			),
		);
		$result = false;

		foreach ($regexes as $regex) {
			if (preg_match($regex['regex'], $attributes['link'], $matches)) {
				$result = array ('provider' => $regex['provider'], 'id' => $matches[$regex['id']]);
			}
		}

		if ($result) {
			if ($result['provider'] == 'youtube') {
				$output = '<div class="w-video"><div class="w-video-h"><iframe width="420" height="315" src="//www.youtube.com/embed/' . $result['id'] . '" frameborder="0" allowfullscreen></iframe></div></div>';
			} elseif ($result['provider'] == 'vimeo') {
				$output = '<div class="w-video"><div class="w-video-h"><iframe src="//player.vimeo.com/video/' . $result['id'] . '?byline=0&amp;color=cc2200" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div></div>';
			}
		} else {
			global $wp_embed;
			$embed = $wp_embed->run_shortcode('[embed]'.$attributes['link'].'[/embed]');

			$output = '<div class="w-video"><div class="w-video-h">' . $embed . '</div></div>';
		}

		return $output;
	}

	public function pricing_table($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		$output = '<div class="w-pricing">'.do_shortcode($content).'</div>';

		return $output;
	}

	public function pricing_column($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'title' => '',
				'type' => '',
				'price' => '',
				'time' => '',
			), $attributes);

		$featured_class = ($attributes['type'] == 'featured')?' type_featured':'';

		$output = 	'<div class="w-pricing-item'.$featured_class.'"><div class="w-pricing-item-h">
						<div class="w-pricing-item-header">
							<div class="w-pricing-item-title"><h5>'.$attributes['title'].'</h5></div>
							<div class="w-pricing-item-price">'.$attributes['price'].'<small>'.$attributes['time'].'</small></div>
						</div>
						<ul class="w-pricing-item-features">'.
			do_shortcode($content).
			'</div></div>';

		return $output;
	}

	public function pricing_row($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		$output = 	'<li class="w-pricing-item-feature">'.do_shortcode($content).'</li>';

		return $output;

	}

	public function pricing_footer($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'url' => '',
				'type' => 'default',
				'size' => '',
				'icon' => '',
			), $attributes);

		if ($attributes['url'] == '') $attributes['url'] = 'javascript:void(0)';

		$output = 	'</ul><div class="w-pricing-item-footer">
						<a class="w-pricing-item-footer-button g-btn';
		$output .= ($attributes['type'] != '')?' color_'.$attributes['type']:'';
		$output .= ($attributes['size'] != '')?' size_'.$attributes['size']:'';
		$output .= '" href="'.$attributes['url'].'"><span>'.do_shortcode($content).'</span></a>
					</div>';

		return $output;

	}

	public function tabs($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		global $first_tab, $first_tab_title, $auto_open;
		$auto_open = TRUE;
		$first_tab_title = TRUE;
		$first_tab = TRUE;

		$content_titles = str_replace('[item', '[item_title', $content);
		$content_titles = str_replace('[/item', '[/item_title', $content_titles);

		$output = '<div class="w-tabs"><div class="w-tabs-list">'.do_shortcode($content_titles).'</div>'.do_shortcode($content).'</div>';

		$auto_open = FALSE;
		$first_tab_title = FALSE;
		$first_tab = FALSE;

		return $output;
	}

	public function accordion($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		global $first_tab, $first_tab_title, $auto_open;
		$auto_open = TRUE;
		$first_tab_title = TRUE;
		$first_tab = TRUE;

		$output = '<div class="w-tabs layout_accordion">'.do_shortcode($content).'</div>';

		$auto_open = FALSE;
		$first_tab_title = FALSE;
		$first_tab = FALSE;

		return $output;
	}

	public function toggle($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'open' => (@in_array('open', $attributes) OR (isset($attributes['open']) AND $attributes['open'] == 1))
			), $attributes);

		$output = 	'<div class="w-tabs layout_accordion type_toggle">'.do_shortcode($content).'</div>';

		return $output;
	}

	public function item_title($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'title' => '',
				'open' => (@in_array('open', $attributes) OR (isset($attributes['open']) AND $attributes['open'] == 1)),
				'icon' => '',
			), $attributes);

		global $first_tab_title, $auto_open;
		if ($auto_open) {
			$active_class = ($first_tab_title)?' active':'';
			$first_tab_title = FALSE;
		} else {
			$active_class = ($attributes['open'])?' active':'';
		}


		$icon_class = ($attributes['icon'] != '')?' fa fa-'.$attributes['icon']:'';
		$item_icon_class = ($attributes['icon'] != '')?' with_icon':'';

		$output = 	'<div class="w-tabs-item'.$active_class.$item_icon_class.'">'.
			'<span class="w-tabs-item-icon'.$icon_class.'"></span>'.
			'<span class="w-tabs-item-title">'.$attributes['title'].'</span>'.
			'</div>';

		return $output;
	}

	public function item($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'title' => '',
				'open' => (@in_array('open', $attributes) OR (isset($attributes['open']) AND $attributes['open'] == 1)),
				'icon' => '',
			), $attributes);

		global $first_tab, $auto_open;
		if ($auto_open) {
			$active_class = ($first_tab)?' active':'';
			$first_tab = FALSE;
		} else {
			$active_class = ($attributes['open'])?' active':'';
		}
		$icon_class = ($attributes['icon'] != '')?' fa fa-'.$attributes['icon']:'';
		$item_icon_class = ($attributes['icon'] != '')?' with_icon':'';

		$output = 	'<div class="w-tabs-section'.$active_class.$item_icon_class.'">'.
				'<div class="w-tabs-section-header">'.
					'<span class="w-tabs-section-icon'.$icon_class.'"></span>'.
					'<h4 class="w-tabs-section-title">'.$attributes['title'].'</h4>'.
					'<div class="w-tabs-section-control"><i class="fa fa-angle-down"></i></div>'.
				'</div>'.
				'<div class="w-tabs-section-content">'.
					'<div class="w-tabs-section-content-h i-cf">'.
						do_shortcode($content).
					'</div>'.
				'</div>'.
			'</div>';

		return $output;
	}

	public function subtitle($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'align' => '',
			), $attributes);

		$align_class = ($attributes['align'] != '')?' align_'.$attributes['align']:'';

		$output = '<p class="subtitle'.$align_class.'">'.do_shortcode($content).'</p>';

		return $output;
	}

	public function paragraph_big($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'align' => '',
			), $attributes);

		$align_class = ($attributes['align'] != '')?' align_'.$attributes['align']:'';

		$output = '<p class="size_big'.$align_class.'">'.do_shortcode($content).'</p>';

		return $output;
	}

	public function highlight($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);


		$output = '<span class="highlight">'.do_shortcode($content).'</span>';

		return $output;
	}

	public function home_heading($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		$output = 	'<h1 class="home-heading">';
		$output .= 	do_shortcode($content);
		$output .= 	'</h1>';

		return $output;
	}

	public function heading_line($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'type' => '',
				'new_line' => '0',
				'bold' => '0',
			), $attributes);

		$type_class = ($attributes['type'] != '')?' type_'.$attributes['type']:'';
		$type_class .= ($attributes['bold'] == '1')?' bold':'';

		$output = 	'';
		if ($attributes['new_line'] == '1') {
			$output .= 		'<br>';
		}
		$output .= 		'<span class="home-heading-line'.$type_class.'">'.do_shortcode($content).'</span>';

		return $output;
	}

	public function row ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
			), $attributes);

		$output = '<div class="g-cols offset_default">'.do_shortcode($content).'</div>';

		return $output;
	}

	public function one_half ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="one-half">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function one_third ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="one-third">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function two_third ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="two-thirds">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function one_quarter ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="one-quarter">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function three_quarter ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="three-quarters">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function one_fourth ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="one-quarter">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function three_fourth ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);



		$output = '<div class="three-quarters">'.do_shortcode($content).'</div>';

		return $output;

	}

	public function contacts($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'phone' => '',
				'email' => '',
				'address' => '',
				'align' => '',
			), $attributes);

		$align_class = ($attributes['align'] != '')?' align_'.$attributes['align']:'';

		$output = 	'<div class="w-contacts'.$align_class.'">
						<div class="w-contacts-list">';
		if ($attributes['address'] != ''){
			$output .= 		'<div class="w-contacts-item">
								<i class="fa fa-map-marker"></i>
								<span class="w-contacts-item-value">'.$attributes['address'].'</span>
							</div><br>';
		}
		if ($attributes['phone'] != ''){
			$output .= 		'<div class="w-contacts-item">
								<i class="fa fa-phone"></i>
								<span class="w-contacts-item-value">'.$attributes['phone'].'</span>
							</div>';
		}
		if ($attributes['email'] != ''){
			$output .= 		'<div class="w-contacts-item">
								<i class="fa fa-envelope-o"></i>
								<span class="w-contacts-item-value"><a href="mailto:'.$attributes['email'].'">'.$attributes['email'].'</a></span>
							</div>';
		}
		$output .= 		do_shortcode($content);
		$output .= 		'</div>
					</div>';

		return $output;
	}

	public function contact_item($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'icon' => '',
				'new_line' => '0',
			), $attributes);

		$output = 	'';
		if ($attributes['new_line'] == '1') {
			$output .= 		'<br>';
		}

		$output .= 			    '<div class="w-contacts-item">
									<i class="fa fa-'.$attributes['icon'].'"></i>
									<span class="w-contacts-item-value">'.$content.'</span>
								</div>';

		return $output;
	}

	public function contacts_form($attributes, $content = null)
	{
		global $smof_data;
		$attributes = shortcode_atts(
			array(
				'btn_color' => 'primary',
				'btn_align' => '',
			), $attributes);

		$colors = array (
			'primary' => 'Primary (theme color)',
			'secondary' => 'Secondary (theme color)',
			'default' => 'Default (theme color)',
		);

		$colors = array_flip($colors);

		$alignment = array (
			'left' => 'Left',
			'center' => 'Center',
			'right' => 'Right',
		);

		$alignment = array_flip($alignment);
		$btn_color_class = ($smof_data['contact_form_button_color'] != '')?' color_'.@$colors[$smof_data['contact_form_button_color']]:'';
		$btn_align_class = ($smof_data['contact_form_button_align'] != '')?' align_'.@$alignment[$smof_data['contact_form_button_align']]:'';
		$btn_text =  (@$smof_data['contact_form_button_text'] != '')?$smof_data['contact_form_button_text']:__('Send Message', 'us');

		$use_mailchimp = (@$smof_data['contact_form_mailchimp'] == 1 AND @$smof_data['contact_form_mailchimp_api_key'] != '' AND @$smof_data['contact_form_mailchimp_list_id'] != '')?1:0;

		$output = 	'<div class="w-form'.$btn_align_class.'">
						<form action="" method="post" id="contact_form" class="contact_form">';
		if (in_array(@$smof_data['contact_form_name_field'], array('Shown, required', 'Shown, not required'))  OR $use_mailchimp)
		{
			$name_required = (@$smof_data['contact_form_name_field'] == 'Shown, required'  OR $use_mailchimp)?1:0;
			$name_required_label = '';
			if ($name_required) {
				$name_required_label = ' *';
			}
			$output .= 		'<div class="w-form-row" id="name_row">
								<div class="w-form-label">
									<label for="name">'.__('Your name', 'us').$name_required_label.'</label>
								</div>
								<div class="w-form-field">
									<input id="name" type="text" name="name" data-required="'.$name_required.'" placeholder="'.__('Your name', 'us').$name_required_label.'">
									<i class="fa fa-user"></i>
								</div>
								<div class="w-form-state" id="name_state"></div>
							</div>';
		}

		if (in_array(@$smof_data['contact_form_email_field'], array('Shown, required', 'Shown, not required'))  OR $use_mailchimp)
		{
			$email_required = (@$smof_data['contact_form_email_field'] == 'Shown, required'  OR $use_mailchimp)?1:0;
			$email_required_label = '';
			if ($email_required) {
				$email_required_label = ' *';
			}
			$output .= 		'<div class="w-form-row" id="email_row">
								<div class="w-form-label">
									<label for="email">'.__('Email', 'us').$email_required_label.'</label>
								</div>
								<div class="w-form-field">
									<input id="email" type="email" name="email" data-required="'.$email_required.'" placeholder="'.__('Email', 'us').$email_required_label.'">
									<i class="fa fa-envelope"></i>
								</div>
								<div class="w-form-state" id="email_state"></div>
							</div>';
		}
		if ( ! $use_mailchimp) {
			if (in_array(@$smof_data['contact_form_phone_field'], array('Shown, required', 'Shown, not required')))
			{
				$phone_required = (@$smof_data['contact_form_phone_field'] == 'Shown, required')?1:0;
				$phone_required_label = '';
				if ($phone_required) {
					$phone_required_label = ' *';
				}
				$output .= 		'<div class="w-form-row" id="phone_row">
								<div class="w-form-label">
									<label for="phone">'.__('Phone Number', 'us').$phone_required_label.'</label>
								</div>
								<div class="w-form-field">
									<input id="phone" type="text" name="phone" data-required="'.$phone_required.'" placeholder="'.__('Phone Number', 'us').$phone_required_label.'">
									<i class="fa fa-phone"></i>
								</div>
								<div class="w-form-state" id="phone_state"></div>
							</div>';
			}

			if (in_array(@$smof_data['contact_form_message_field'], array('Shown, required', 'Shown, not required')))
			{
				$message_required = (@$smof_data['contact_form_message_field'] == 'Shown, required')?1:0;
				$message_required_label = '';
				if ($message_required) {
					$message_required_label = ' *';
				}
				$output .= 		'<div class="w-form-row" id="message_row">
								<div class="w-form-label">
									<label for="message">'.__('Message', 'us').$message_required_label.'</label>
								</div>
								<div class="w-form-field">
									<textarea id="message" name="message" cols="30" rows="10" data-required="'.$message_required.'" placeholder="'.__('Message', 'us').$message_required_label.'"></textarea>
									<i class="fa fa-pencil"></i>
								</div>
								<div class="w-form-state" id="message_state"></div>
							</div>';
			}
		}

		$output .= 			'<div class="w-form-row for_submit">
								<div class="w-form-field">
									<button class="g-btn '.$btn_color_class.'" id="message_send"><i class="fa fa-spinner fa-spin"></i><span>'.$btn_text.'</span></button>
									<div class="w-form-field-success"></div>
								</div>
							</div>
						</form>
					</div>';

		return $output;
	}

	public function portfolio($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'category' => null,
				'items' => null,
				'ratio' => '3:2',
			), $attributes);

		if ( ! in_array($attributes['ratio'], array('3:2', '4:3', '1:1', '2:3', '3:4')))
		{
			$attributes['ratio'] = '3:2';
		}

		if (is_numeric($attributes['items']) AND $attributes['items'] > 0)
		{
			$attributes['items'] = ceil($attributes['items']);
		} else
		{
			$attributes['items'] = -1;
		}

		$attributes['ratio'] = str_replace(':', '-', $attributes['ratio']);

		$categories_slugs = '';

		if ( ! empty($attributes['category'])) {

			$categories_slugs = explode(',', $attributes['category']);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'us_portfolio_category',
					'field' => 'slug',
					'terms' => $categories_slugs
				)
			);
		}

		$args = array(
			'post_type' => 'us_portfolio',
			'posts_per_page' => $attributes['items'],
			'post__not_in' => get_option('sticky_posts')
		);

		if ( ! empty($attributes['category'])) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'us_portfolio_category',
					'field' => 'slug',
					'terms' => $categories_slugs
				)
			);
		}

		$portfolio = new WP_Query($args);

		$output = 	'<div class="w-portfolio ratio_'.$attributes['ratio'].'">
						<div class="w-portfolio-list">';
		while($portfolio->have_posts())
		{
			$portfolio->the_post();
			$post = get_post();

			$link = 'javascript:void(0);';
			$link_class = $link_target = '';

			if (rwmb_meta('us_custom_link') != '')
			{
				$link = rwmb_meta('us_custom_link');
				$link_class = ' external-link';
				if (rwmb_meta('us_custom_link_blank') == 1)
				{
					$link_target = ' target="_blank"';
				}
			}

			if (rwmb_meta('us_preview_fullwidth') == 1)
			{

				$additional_class = '';
				if (rwmb_meta('us_additional_class') != '') {
					$additional_class = ' '.rwmb_meta('us_additional_class');
				}

				if (has_post_thumbnail()) {
					$the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio-list-'.$attributes['ratio']);
					$the_thumbnail = $the_thumbnail[0];
					$the_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$the_image = '<img src="'.$the_image[0].'" alt="'.get_the_title().'">';
				} else {
					$the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
					$the_image = '<img src="'.get_template_directory_uri().'/img/placeholder/1200x800.gif" alt="'.get_the_title().'">';
				}

				remove_shortcode('subsection');
				add_shortcode('subsection', array($this, 'subsection_dummy'));

				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$content = str_replace('<textarea', '<us_not_textarea', $content);
				$content = str_replace('</textarea', '</us_not_textarea', $content);

				remove_shortcode('subsection');
				add_shortcode('subsection', array($this, 'subsection'));

				$output .= 		'<div class="w-portfolio-item'.$additional_class.'">
									<a class="w-portfolio-item-anchor'.$link_class.'" href="'.$link.'" data-id="'.$post->ID.'"'.$link_target.'>
										<div class="w-portfolio-item-image"><img src="'.$the_thumbnail.'" alt="'.get_the_title().'"></div>
										<div class="w-portfolio-item-meta">
											<div class="w-portfolio-item-meta-h">
												<h2 class="w-portfolio-item-title">'.get_the_title().'</h2>
												<span class="w-portfolio-item-arrow"></span>
												<span class="w-portfolio-item-text"></span>
											</div>
										</div>
										<div class="w-portfolio-item-hover"><i class="fa fa-plus"></i></div>
									</a>
									<div class="w-portfolio-item-details" style="display: none;">
										<div class="w-portfolio-item-details-h">
											<div class="w-portfolio-item-details-content"></div>
											<div class="w-portfolio-item-details-close"></div>
											<div class="w-portfolio-item-details-arrow to_prev"><i class="fa fa-angle-left"></i></div>
											<div class="w-portfolio-item-details-arrow to_next"><i class="fa fa-angle-right"></i></div>
										</div>
									</div>
									<textarea class="w-portfolio-hidden-content" style="display:none">'.$content.'</textarea>
								</div>';
			}
			else
			{
				$extended_class = $additional_class = '';
				if (has_post_thumbnail()) {
					$the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'portfolio-list-'.$attributes['ratio']);
					$the_thumbnail = $the_thumbnail[0];
					$the_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
					$the_image = '<img src="'.$the_image[0].'" alt="'.get_the_title().'">';
				} else {
					$the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
					$the_image = '<img src="'.get_template_directory_uri().'/img/placeholder/1200x800.gif" alt="'.get_the_title().'">';
				}

				if (rwmb_meta('us_preview_image') != '')
				{
					$extended_class = ' type_extended';
					$preview_img_id = preg_replace('/[^\d]/', '', rwmb_meta('us_preview_image'));
					$preview_img = wp_get_attachment_image_src($preview_img_id, 'full');

					if ( $preview_img != NULL )
					{
						$the_image = '<img src="'.$preview_img[0].'" alt="'.get_the_title().'">';
					}
				} elseif (rwmb_meta('us_preview_video') != '') {
					$extended_class = ' type_extended';
					$the_image = do_shortcode('[responsive_video link="'.rwmb_meta('us_preview_video').'"]');
				}

				if (rwmb_meta('us_additional_class') != '') {
					$additional_class = ' '.rwmb_meta('us_additional_class');
				}

				remove_shortcode('subsection');
				add_shortcode('subsection', array($this, 'subsection_dummy'));

				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$content = str_replace('<textarea', '<us_not_textarea', $content);
				$content = str_replace('</textarea', '</us_not_textarea', $content);

				remove_shortcode('subsection');
				add_shortcode('subsection', array($this, 'subsection'));

				$output .= 		'<div class="w-portfolio-item'.$extended_class.$additional_class.'">
									<div class="w-portfolio-item-h">
										<a class="w-portfolio-item-anchor'.$link_class.'" href="'.$link.'" data-id="'.$post->ID.'"'.$link_target.'>
											<div class="w-portfolio-item-image"><img src="'.$the_thumbnail.'" alt="'.get_the_title().'"></div>
											<div class="w-portfolio-item-meta">
												<div class="w-portfolio-item-meta-h">
													<h2 class="w-portfolio-item-title">'.get_the_title().'</h2>
													<span class="w-portfolio-item-arrow"></span>
													<span class="w-portfolio-item-text"></span>
												</div>
											</div>
											<div class="w-portfolio-item-hover"><i class="fa fa-plus"></i></div>
										</a>
										<div class="w-portfolio-item-details" style="display: none;">
											<div class="w-portfolio-item-details-h">
												<div class="w-portfolio-item-details-content"></div>

												<div class="w-portfolio-item-details-close"></div>
												<div class="w-portfolio-item-details-arrow to_prev"><i class="fa fa-angle-left"></i></div>
												<div class="w-portfolio-item-details-arrow to_next"><i class="fa fa-angle-right"></i></div>

											</div>
										</div>
										<textarea class="w-portfolio-hidden-content" style="display:none">
											<div class="w-portfolio-item-details-content-preview">
												'.$the_image.'
											</div>
											<div class="w-portfolio-item-details-content-text">
												<h3>'.get_the_title().'</h3>
												'.$content.'
											</div>
										</textarea>
									</div>
								</div>';
			}
		}
		$output .= 		'</div>
					</div>';

		return $output;
	}

	public function blog($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'posts' => 6,
				'category' => null,
				'ajax' => 0,
			), $attributes);

		if (is_numeric($attributes['posts']) AND $attributes['posts'] > 0)
		{
			$attributes['posts'] = ceil($attributes['posts']);
		} else
		{
			$attributes['posts'] = 6;
		}

		$args = array(
			'post_status' => 'publish',
			'post_type' => 'post',
			'posts_per_page' => $attributes['posts'],
			'post__not_in' => get_option('sticky_posts')
		);

		if ( ! empty($attributes['category'])) {
			$args['category_name'] = $attributes['category'];
		} else {
			$attributes['category'] = '';
		}

		$posts = new WP_Query($args);
		$max_num_pages = $posts->max_num_pages;

		$output = 	'<div class="w-blog imgpos_atleft">
						<div class="w-blog-list">';

		while($posts->have_posts())
		{
			$posts->the_post();

			if (has_post_thumbnail()) {
				$the_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-list');
				$the_thumbnail = $the_thumbnail[0];
			} else {
				$the_thumbnail =  get_template_directory_uri() .'/img/placeholder/500x500.gif';
			}

			$output .= 		'<div class="w-blog-entry">
								<div class="w-blog-entry-h">
									<a class="w-blog-entry-link" href="'.get_permalink(get_the_ID()).'">
										<span class="w-blog-entry-preview">
											<img src="'.$the_thumbnail.'" alt="'.get_the_title().'">
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
		$output .=		'</div>
					</div>';

		if ($max_num_pages > 1 AND $attributes['ajax'] == 1) {
			$output .=
				'<script type="text/javascript">
var page = 1,
	max_page = '.$max_num_pages.'
jQuery(document).ready(function(){
	jQuery("#blog_load_more").click(function(){
		jQuery(".w-loadmore").addClass("loading");
		jQuery.ajax({
			type: "POST",
			url: "'.admin_url('admin-ajax.php').'",
			data: {
				action: "blogPagination",
				page: page+1,
				per_page: '.$attributes['posts'].',
				category: "'.$attributes['category'].'"
			},
			success: function(data, textStatus, XMLHttpRequest){
				page++;

				var newItems = jQuery("<div>", {html:data}),
					blogList = jQuery(".w-blog-list");

				newItems.imagesLoaded(function() {
					newItems.children().each(function(childIndex,child){
						blogList.append(jQuery(child));

					});
				});

				jQuery(".w-loadmore").removeClass("loading");

				if (max_page <= page) {
					jQuery(".w-loadmore").addClass("done");
				}

				jQuery(window).resize();
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				jQuery(".w-loadmore").removeClass("loading");
			}
		});
	});
});
</script>
<div class="w-loadmore">
	<a href="javascript:void(0);" id="blog_load_more" class="g-btn color_default size_small"><span>'.__('Load More Posts', 'us').'</span></a>
	<i class="fa fa-refresh fa-spin"></i>
</div>';
		}

		return $output;
	}

	public function clients($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'amount' => 1000,
				'auto_scroll' => false,
				'interval' => 1,
				'arrows' => false,
				'indents' => false,
				'columns' => 5,
			), $attributes);

		$args = array(
			'post_type' => 'us_client',
			'paged' => 1,
			'posts_per_page' => $attributes['amount'],
		);

		$clients = new WP_Query($args);

		$columns = (in_array($attributes['columns'], array(5, 4, 3, 2, 1)))?$attributes['columns']:5;

		$arrows_class = ($attributes['arrows'] == 1 OR $attributes['arrows'] == 'yes')?' nav_arrows':'';
		$indents_class = ($attributes['indents'] == 1 OR $attributes['indents'] == 'yes')?' with_indents':'';
		$auto_scroll = ($attributes['auto_scroll'] == 1 OR $attributes['auto_scroll'] == 'yes')?'1':'0';
		$interval = intval($attributes['interval']);
		if ($interval < 1) {
			$interval = 1;
		}
		$interval = $interval*1000;

		// We need slick script for this, but only once per page
		if ( ! wp_script_is('us-slick', 'enqueued')){
			wp_enqueue_script('us-slick');
		}

		$output = '<div class="w-clients'.$arrows_class.$indents_class.'">
						<div class="w-clients-list slick-loading" data-columns="'.$columns.'" data-autoPlay="'.$auto_scroll.'" data-autoPlaySpeed="'.$interval.'">';

		while ($clients->have_posts())
		{
			$clients->the_post();
			if(has_post_thumbnail())
			{
				$thumb_src =  wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID() ), 'carousel-thumb');
				if (rwmb_meta('us_client_url') != '')
				{
					$client_new_tab = (rwmb_meta('us_client_new_tab') == 1)?' target="_blank"':'';
					$client_url = (rwmb_meta('us_client_url') != '')?rwmb_meta('us_client_url'):'javascript:void(0);';
					$output .= '<div class="w-clients-item"><a class="w-clients-item-h" href="'.$client_url.'"'.$client_new_tab.'>'.
						'<img data-lazy="'.$thumb_src[0].'" alt="'.get_the_title().'"></a></div>';
				}
				else
				{
					$output .= '<div class="w-clients-item"><span class="w-clients-item-h">'.
						'<img data-lazy="'.$thumb_src[0].'" alt="'.get_the_title().'"></span></div>';
				}

			}
		}

		$output .= '</div>
					</div>';
		return $output;
	}

	public function button($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'text' => '',
				'url' => '',
				'external' => '',
				'type' => 'default',
				'size' => '',
				'icon' => '',
			), $attributes);

		$icon_part = '';
		if ($attributes['icon'] != '') {
			$icon_part = '<i class="fa fa-'.$attributes['icon'].'"></i>';
		}

		$output = '<a href="'.$attributes['url'].'"';
		$output .= ($attributes['external'] == '1')?' target="_blank"':'';
		$output .= ' class="g-btn';
		$output .= ($attributes['type'] != '')?' color_'.$attributes['type']:'';
		$output .= ($attributes['size'] != '')?' size_'.$attributes['size']:'';
		$output .= '">'.$icon_part.'<span>'.$attributes['text'].'</span></a>';

		return $output;
	}

	public function separator($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'type' => "",
				'size' => "",
				'icon' => "star",
			), $attributes);

		$simple_class = '';
		if ($attributes['icon'] == '') {
			$simple_class = ' type_simple';
		}

		$type_class = ($attributes['type'] != '')?' type_'.$attributes['type']:'';
		$size_class = ($attributes['size'] != '')?' size_'.$attributes['size']:'';

		$output = 	'<div class="g-hr'.$type_class.$size_class.$simple_class.'">
						<span class="g-hr-h">
							<i class="fa fa-'.$attributes['icon'].'"></i>
						</span>
					</div>';

		return $output;
	}

	public function icon($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'icon' => "",
				'color' => "",
				'size' => "",
				'with_circle' => "",
				'link' => "",
			), $attributes);

		$color_class = ($attributes['color'] != '')?' color_'.$attributes['color']:'';
		$size_class = ($attributes['size'] != '')?' size_'.$attributes['size']:'';
		$with_circle_class = ($attributes['with_circle'] == 1)?' with_circle':'';

		if ($attributes['link'] != '') {
			$link = $attributes['link'];
			$link_start = '<a class="w-icon-link" href="'.$link.'">';
			$link_end = '</a>';
		}
		else
		{
			$link_start = '<span class="w-icon-link">';
			$link_end = '</span>';
		}

		$output = 	'<span class="w-icon'.$color_class.$size_class.$with_circle_class.'">
						'.$link_start.'
							<i class="fa fa-'.$attributes['icon'].'"></i>
						'.$link_end.'
					</span>';

		return $output;
	}

	public function iconbox($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'icon' => '',
				'img' => '',
				'title' => '',
				'with_circle' => 'h2',
				'link' => '',
				'iconpos' => 'top',
				'external' => 'top',

			), $attributes);

		$img_class = ($attributes['img'] != '')?' custom_img':'';
		$iconpos_class = ($attributes['iconpos'] != '')?' iconpos_'.$attributes['iconpos']:'';
		$with_circle_class = ($attributes['with_circle'] == 1)?' with_circle':'';

		if ($attributes['link'] != '') {
			$link = $attributes['link'];
			$link_start = '<a class="w-iconbox-link" href="'.$link.'"';
			$link_start .= ($attributes['external'] == '1')?' target="_blank"':'';
			$link_start .= '>';
			$link_end = '</a>';
		}
		else
		{
			$link_start = '<div class="w-iconbox-link">';
			$link_end = '</div>';
		}

		$output =	'<div class="w-iconbox'.$img_class.$iconpos_class.$with_circle_class.'">
						'.$link_start.'
							<div class="w-iconbox-icon">
								<i class="fa fa-'.$attributes['icon'].'"></i>';
		if ($attributes['img'] != '') {
			$output .=			'<img src="'.$attributes['img'].'" alt="">';
		}
		$output .=	'		</div>
							<h4 class="w-iconbox-title">'.$attributes['title'].'</h4>
						'.$link_end.'
						<div class="w-iconbox-text">
							<p>'.do_shortcode($content).'</p>
						</div>
					</div>';

		return $output;
	}

	public function social_links($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'size' => '',
				'align' => '',
				'email' => '',
				'facebook' => '',
				'twitter' => '',
				'google' => '',
				'linkedin' => '',
				'youtube' => '',
				'vimeo' => '',
				'flickr' => '',
				'instagram' => '',
				'behance' => '',
				'pinterest' => '',
				'skype' => '',
				'tumblr' => '',
				'dribbble' => '',
				'vk' => '',
				'rss' => '',
				'xing' => '',
				'twitch' => '',
				'yelp' => '',
				'soundcloud' => '',
				'deviantart' => '',
				'foursquare' => '',
				'github' => '',
			), $attributes);

		$socials = array (
			'email' => 'Email',
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'google' => 'Google+',
			'linkedin' => 'LinkedIn',
			'youtube' => 'YouTube',
			'vimeo' => 'Vimeo',
			'flickr' => 'Flickr',
			'instagram' => 'Instagram',
			'behance' => 'Behance',
			'pinterest' => 'Pinterest',
			'skype' => 'Skype',
			'tumblr' => 'Tumblr',
			'dribbble' => 'Dribbble',
			'vk' => 'Vkontakte',
			'xing' => 'Xing',
			'twitch' => 'Twitch',
			'yelp' => 'Yelp',
			'soundcloud' => 'SoundCloud',
			'deviantart' => 'DeviantArt',
			'foursquare' => 'Foursquare',
			'github' => 'GitHub',
			'rss' => 'RSS',
		);

		$align_class = ($attributes['align'] != '')?' align_'.$attributes['align']:'';
		$size_class = ($attributes['size'] != '')?' size_'.$attributes['size']:'';

		$output = '<div class="w-socials'.$size_class.$align_class.'">
				<div class="w-socials-list">';

		foreach ($socials as $social_key => $social)
		{
			if ($attributes[$social_key] != '')
			{
				if ($social_key == 'email')
				{
					$output .= '<div class="w-socials-item '.$social_key.'">
					<a class="w-socials-item-link" href="mailto:'.$attributes[$social_key].'">
						<i class="fa fa-envelope"></i>
					</a>
					<div class="w-socials-item-popup">
						<div class="w-socials-item-popup-h">
							<span class="w-socials-item-popup-text">'.$social.'</span>
						</div>
					</div>
					</div>';

				}
				elseif ($social_key == 'google')
				{
					$output .= '<div class="w-socials-item gplus">
					<a class="w-socials-item-link" target="_blank" href="'.$attributes[$social_key].'">
						<i class="fa fa-google-plus"></i>
					</a>
					<div class="w-socials-item-popup"><span>'.$social.'</span></div>
					</div>';

				}
				elseif ($social_key == 'youtube')
				{
					$output .= '<div class="w-socials-item '.$social_key.'">
					<a class="w-socials-item-link" target="_blank" href="'.$attributes[$social_key].'">
						<i class="fa fa-youtube-play"></i>
					</a>
					<div class="w-socials-item-popup"><span>'.$social.'</span></div>
					</div>';

				}
				elseif ($social_key == 'vimeo')
				{
					$output .= '<div class="w-socials-item '.$social_key.'">
					<a class="w-socials-item-link" target="_blank" href="'.$attributes[$social_key].'">
						<i class="fa fa-vimeo-square"></i>
					</a>
					<div class="w-socials-item-popup"><span>'.$social.'</span></div>
					</div>';

				}
				else
				{
					$output .= '<div class="w-socials-item '.$social_key.'">
					<a class="w-socials-item-link" target="_blank" href="'.$attributes[$social_key].'">
						<i class="fa fa-'.$social_key.'"></i>
					</a>
					<div class="w-socials-item-popup"><span>'.$social.'</span></div>
					</div>';
				}
			}
		}

		$output .= '</div></div>';

		return $output;
	}

	public function testimonial($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'author' => '',
				'description' => '',

			), $attributes);

		$output = 	'<div class="w-testimonial">
						<blockquote>
							<q class="w-testimonial-text">'.do_shortcode($content).'</q>
							<div class="w-testimonial-person">
								<i class="fa fa-user"></i>
								<span class="w-testimonial-person-name">'.$attributes['author'].'</span>
								<span class="w-testimonial-person-meta">'.$attributes['description'].'</span>
							</div>
						</blockquote>
					</div>';



		return $output;
	}

	public function message_box ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(
				'type' => 'info',
			), $attributes);

		$output = '<div class="g-alert with_close type_'.$attributes['type'].'"><div class="g-alert-close">&#10005;</div><div class="g-alert-body"><p>'.do_shortcode($content).'</p></div></div>';

		return $output;
	}

	public function team ($attributes, $content)
	{
		$attributes = shortcode_atts(
			array(

			), $attributes);

		$output = 	'<div class="w-team">';
		$output .= 		do_shortcode($content);
		$output .=	'</div>';

		return $output;
	}

	public function member ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'name' => '',
				'role' => '',
				'img' => '',
				'email' => '',
				'facebook' => '',
				'twitter' => '',
				'linkedin' => '',
				'custom_icon' => '',
				'custom_link' => '',
				'custom_link_external' => '',
			), $attributes
		);

		if ( is_numeric( $attributes['img'] ) ) {
			$img_id = preg_replace( '/[^\d]/', '', $attributes['img'] );
			$img = wp_get_attachment_image_src( $img_id, 'gallery-l' );

			if ( $img != NULL ) {
				$attributes['img'] = $img[0];
			}
		}

		if ( $attributes['img'] == NULL OR $attributes['img'] == '' ) {
			$attributes['img'] = get_template_directory_uri() . '/img/placeholder/500x500.gif';
		}

		$social_output = '';

		if ($attributes['facebook'] != '' OR $attributes['twitter'] != '' OR $attributes['linkedin'] != '' OR $attributes['email'] != '' OR ($attributes['custom_icon'] != '' AND $attributes['custom_link'] != ''))
		{
			$social_output .=		'<div class="w-team-member-links">'.
				'<div class="w-team-member-links-list">';

			if ($attributes['email'] != '')
			{
				$social_output .= 			'<a class="w-team-member-links-item" href="mailto:'.$attributes['email'].'" target="_blank"><i class="fa fa-envelope"></i></a>';
			}
			if ($attributes['facebook'] != '')
			{
				$social_output .= 			'<a class="w-team-member-links-item" href="'.$attributes['facebook'].'" target="_blank"><i class="fa fa-facebook"></i></a>';
			}
			if ($attributes['twitter'] != '')
			{
				$social_output .= 			'<a class="w-team-member-links-item" href="'.$attributes['twitter'].'" target="_blank"><i class="fa fa-twitter"></i></a>';
			}
			if ($attributes['linkedin'] != '')
			{
				$social_output .= 			'<a class="w-team-member-links-item" href="'.$attributes['linkedin'].'" target="_blank"><i class="fa fa-linkedin"></i></a>';
			}
			if ($attributes['custom_icon'] != '' AND $attributes['custom_link'] != '')
			{
				$external_part = ($attributes['custom_link_external'] == '1')?' target="_blank"':'';
				$social_output .= '<a class="w-team-member-links-item" href="'.$attributes['custom_link'].'"'.$external_part.'><i class="fa fa-'.$attributes['custom_icon'].'"></i></a>';
			}
			$social_output .=			'</div>'.
				'</div>';
		}

		$output = 	'<div class="w-team-member">
						<div class="w-team-member-h">
							<div class="w-team-member-image">
								<img src="'.$attributes['img'].'" alt="'.$attributes['name'].'" />
							</div>
							<div class="w-team-member-meta">
								<div class="w-team-member-meta-h">
									<h4 class="w-team-member-name">'.$attributes['name'].'</h4>
									<div class="w-team-member-role">'.$attributes['role'].'</div>
									'.$social_output.'
								</div>
							</div>
						</div>
					</div>';

		return $output;
	}

	public function gallery($attributes)
	{
		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty($attributes['ids']))
		{
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if (empty($attributes['orderby']))
			{
				$attributes['orderby'] = 'post__in';
			}
			$attributes['include'] = $attributes['ids'];
		}

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if (isset($attributes['orderby']))
		{
			$attributes['orderby'] = sanitize_sql_orderby($attributes['orderby']);
			if ( !$attributes['orderby'])
			{
				unset($attributes['orderby']);
			}
		}

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'type'       => 's',
			'include'    => '',
			'exclude'    => ''
		), $attributes));

		if ( ! in_array($type, array('s', 'm', 'l', 'masonry'))) {
			$type = "s";
		}

		$size = 'gallery-'.$type;
		if ($type == 'masonry') {
			$type_classes = ' type_masonry';
		} else {
			$columns_to_size = array(
				1 => 'l',
				2 => 'l',
				3 => 'l',
				4 => 'm',
				5 => 'm',
				6 => 'm',
				7 => 'm',
				8 => 's',
				9 => 's',
				10 => 's',
			);

			$size = 'gallery-'.$columns_to_size[$columns];
			$type_classes = ' columns_'.$columns;
		}


		$id = intval($id);
		if ('RAND' == $order)
		{
			$orderby = 'none';
		}

		if ( !empty($include))
		{
			$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

			$attachments = array();
			if (is_array($_attachments))
			{
				foreach ($_attachments as $key => $val) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			}
		}
		elseif ( !empty($exclude))
		{
			$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		}
		else
		{
			$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
		}

		if (empty($attachments))
		{
			return '';
		}

		if (is_feed())
		{
			$output = "\n";
			if (is_array($attachments))
			{
				foreach ($attachments as $att_id => $attachment)
					$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			}
			return $output;
		}

		$rand_id = rand(99999, 999999);

		$output = '<div id="gallery_'.$rand_id.'" class="w-gallery'.$type_classes.'"><div class="w-gallery-tnails">';

		$i = 1;
		if (is_array($attachments))
		{
			foreach ($attachments as $id => $attachment) {

				$title = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
				if (empty($title))
				{
					$title = trim(strip_tags($attachment->post_excerpt)); // If not, Use the Caption
				}
				if (empty($title))
				{
					$title = trim(strip_tags($attachment->post_title)); // Finally, use the title
				}

				$output .= '<a class="w-gallery-tnail order_'.$i.'" href="'.wp_get_attachment_url($id).'">';
				$output .= wp_get_attachment_image($id, $size, 0);
				$output .= '<span class="w-gallery-tnail-title"><i class="fa fa-search"></i></span>';
				$output .= '</a>';

				$i++;

			}
		}

		$output .= "</div></div>\n";

		$output .= "<script>
		jQuery(document).ready(function(){
		jQuery('#gallery_".$rand_id."').magnificPopup({
			type: 'image',
			delegate: 'a',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			removalDelay: 300,
			fixedBgPos: true,
			fixedContentPos: false,
			mainClass: 'mfp-fade'

		});
		});
		</script>";

		return $output;
	}
}

global $us_shortcodes;

$us_shortcodes = new US_Shortcodes;

// Add buttons to tinyMCE
function us_add_buttons() {
	if (current_user_can('edit_posts') &&  current_user_can('edit_pages'))
	{
		add_filter('mce_external_plugins', 'us_tinymce_plugin');
		add_filter('mce_buttons_3', 'us_tinymce_buttons');
	}
}

function us_tinymce_buttons($buttons) {
	array_push($buttons, "subsection", "columns", "typography", "separator_btn", "us_button", "tabs", "accordion", "toggle", "icon", "iconbox", "fullscreen_slider", "simple_slider", "portfolio", "blog", "testimonial", "team", "contacts", "contacts_form", "social_links", "gmaps", "actionbox", "pricing_table", "responsive_video", "message_box", "counter", "clients");
	return $buttons;
}

function us_tinymce_plugin($plugin_array) {
	$plugin_array['columns'] = get_template_directory_uri().'/functions/tinymce/buttons.js';

	$plugin_array['responsive_video'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['team'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['us_button'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['tabs'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['accordion'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['toggle'] = get_template_directory_uri().'/functions/tinymce/buttons.js';

	$plugin_array['separator_btn'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['icon'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['iconbox'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['testimonial'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['portfolio'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['blog'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['simple_slider'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['fullscreen_slider'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['subsection'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['contacts'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['contacts_form'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['typography'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['actionbox'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['pricing_table'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['social_links'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['gmaps'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['counter'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['message_box'] = get_template_directory_uri().'/functions/tinymce/buttons.js';
	$plugin_array['clients'] = get_template_directory_uri().'/functions/tinymce/buttons.js';

	return $plugin_array;
}

add_action('admin_init', 'us_add_buttons');


