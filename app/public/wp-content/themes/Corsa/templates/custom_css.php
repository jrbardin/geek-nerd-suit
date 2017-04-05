<?php
global $smof_data, $output_styles_to_file;

// Compatibility with the previous version
if ( ! isset($smof_data['heading_font_family']) AND isset($smof_data['heading_font'])){
	$smof_data['heading_font_family'] = $smof_data['heading_font'];
}
if ( ! isset($smof_data['body_font_family']) AND isset($smof_data['body_text_font'])){
	$smof_data['body_font_family'] = $smof_data['body_text_font'];
}
if ( ! isset($smof_data['nav_font_family']) AND isset($smof_data['navigation_font'])){
	$smof_data['nav_font_family'] = $smof_data['navigation_font'];
}

$font_weights = array('200', '300', '400', '600', '700');
$prefixes = array('heading', 'body', 'nav');
foreach ( $prefixes as $prefix ){
	// Default font-family
	if ( ! isset($smof_data[$prefix.'_font_family']) OR $smof_data[$prefix.'_font_family'] == '') {
		$smof_data[$prefix.'_font_family'] = 'none';
	}
	// Add quotes for custom font namings
	elseif(strpos($smof_data[$prefix.'_font_family'], ',') === FALSE){
		$smof_data[$prefix.'_font_family'] = "'".$smof_data[$prefix.'_font_family']."'";
	}
	// Default font-weight
	$smof_data[$prefix.'_font_weight'] = '400';
	foreach ( $font_weights as $font_weight ) {
		if (isset($smof_data[$prefix.'_font_weight_'.$font_weight]) AND $smof_data[$prefix.'_font_weight_'.$font_weight] == 1) {
			$smof_data[$prefix.'_font_weight'] = $font_weight;
			break;
		}
	}
}

// Fault tolerance for missing options
$default_options = array(
	'nav_fontsize' => 17,
	'subnav_fontsize' => 15,
	'nav_fontsize_mobile' => 17,
	'subnav_fontsize_mobile' => 15,
	'regular_fontsize' => 16,
	'regular_lineheight' => 26,
	'regular_fontsize_mobile' => 14,
	'regular_lineheight_mobile' => 24,
	'h1_fontsize' => 54,
	'h2_fontsize' => 44,
	'h3_fontsize' => 36,
	'h4_fontsize' => 30,
	'h5_fontsize' => 24,
	'h6_fontsize' => 20,
	'h1_fontsize_mobile' => 30,
	'h2_fontsize_mobile' => 26,
	'h3_fontsize_mobile' => 24,
	'h4_fontsize_mobile' => 22,
	'h5_fontsize_mobile' => 20,
	'h6_fontsize_mobile' => 18,
);
foreach ( $default_options as $option_key => $option_value ) {
	if (empty($smof_data[$option_key])) {
		$smof_data[$option_key] = $option_value;
	}
}
?>
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
<style id="us_fonts_inline">
<?php endif; ?>
body {
	<?php if ($smof_data['body_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['body_font_family']; ?>;
	<?php endif; ?>
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight']; ?>px;
	font-weight: <?php echo $smof_data['body_font_weight']; ?>;
	}
.w-portfolio-item-details {
	font-size: <?php echo $smof_data['regular_fontsize']; ?>px;
	}
	
.l-header .menu-item-language,
.l-header .w-nav-item {
	<?php if ($smof_data['nav_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['nav_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['nav_font_weight']; ?>;
	}
.touch_disabled .menu-item-language > a,
.l-header .touch_disabled .w-nav-anchor.level_1,
.touch_disabled [class*="columns"] .has_sublevel .w-nav-anchor.level_2 {
	font-size: <?php echo $smof_data['nav_fontsize']; ?>px;
	}
.touch_disabled .submenu-languages .menu-item-language > a,
.l-header .touch_disabled .w-nav-anchor.level_2,
.l-header .touch_disabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize']; ?>px;
	}
.touch_enabled .menu-item-language > a,
.l-header .touch_enabled .w-nav-anchor.level_1 {
	font-size: <?php echo $smof_data['nav_fontsize_mobile']; ?>px;
	}
.l-header .touch_enabled .w-nav-anchor.level_2,
.l-header .touch_enabled .w-nav-anchor.level_3 {
	font-size: <?php echo $smof_data['subnav_fontsize_mobile']; ?>px;
	}
	
h1, h2, h3, h4, h5, h6,
.l-preloader-counter,
.w-blog-meta-date-day,
.w-counter-number,
.w-logo-title,
.w-pricing-item-price,
.w-tabs-item-title {
	<?php if ($smof_data['heading_font_family'] != 'none'): ?>
	font-family: <?php echo $smof_data['heading_font_family']; ?>;
	<?php endif; ?>
	font-weight: <?php echo $smof_data['heading_font_weight']; ?>;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize']; ?>px;
	}
h4 {
	font-size: <?php echo $smof_data['h4_fontsize']; ?>px;
	}
h5 {
	font-size: <?php echo $smof_data['h5_fontsize']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize']; ?>px;
	}
@media only screen and (max-width: 767px) {
body {
	font-size: <?php echo $smof_data['regular_fontsize_mobile']; ?>px;
	line-height: <?php echo $smof_data['regular_lineheight_mobile']; ?>px;
	}
h1 {
	font-size: <?php echo $smof_data['h1_fontsize_mobile']; ?>px;
	}
h2 {
	font-size: <?php echo $smof_data['h2_fontsize_mobile']; ?>px;
	}
h3 {
	font-size: <?php echo $smof_data['h3_fontsize_mobile']; ?>px;
	}
h4, .widgettitle, .comment-reply-title {
	font-size: <?php echo $smof_data['h4_fontsize_mobile']; ?>px;
	}
h5, .w-portfolio-item-title {
	font-size: <?php echo $smof_data['h5_fontsize_mobile']; ?>px;
	}
h6 {
	font-size: <?php echo $smof_data['h6_fontsize_mobile']; ?>px;
	}
}
<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
</style>
<style id="us_colors_inline">
<?php endif; ?>
/*************************** HEADER ***************************/

/* Header Background color */
.l-header,
.no-touch .l-header .menu-item-language > a:hover,
.no-touch .touch_disabled .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_2:hover > .w-nav-anchor,
.no-touch .l-header .w-nav-item.level_3:hover > .w-nav-anchor {
	background-color: <?php echo ($smof_data['header_background'] != '')?$smof_data['header_background']:'#fff'; ?>;
	}

/* Header Alternate Background Color */
.touch_disabled .submenu-languages,
.no-touch .touch_disabled .w-nav-list > .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_1 .w-nav-anchor.level_1:before,
.l-header .w-nav-list.level_2,
.l-header .w-nav-list.level_3 {
	background-color: <?php echo ($smof_data['header_background_alternative'] != '')?$smof_data['header_background_alternative']:'#f5f5f5'; ?>;
	}
	
/* Border Color */
.l-header .w-nav.touch_enabled .w-nav-anchor {
	border-color: <?php echo ($smof_data['header_border'] != '')?$smof_data['header_border']:'#e8e8e8'; ?>;
	}
	
/* Navigation Color */
.l-header {
	color: <?php echo ($smof_data['header_navigation'] != '')?$smof_data['header_navigation']:'#666'; ?>;
	}
	
/* Navigation Hover Color */
.no-touch .l-header .menu-item-language > a:hover,
.no-touch .touch_disabled .menu-item-language:hover > a,
.no-touch .w-logo-link:hover,
.no-touch .l-header .w-nav-control:hover,
.no-touch .l-header .w-nav-item:hover > .w-nav-anchor {
	color: <?php echo ($smof_data['header_navigation_hover'] != '')?$smof_data['header_navigation_hover']:'#444'; ?>;
	}
	
/* Navigation Active Color */
.l-header .w-nav-item.active > .w-nav-anchor,
.l-header .w-nav-item.current-menu-item > .w-nav-anchor,
.l-header .w-nav-item.current-menu-ancestor > .w-nav-anchor {
	color: <?php echo ($smof_data['header_navigation_active'] != '')?$smof_data['header_navigation_active']:'#31c5c7'; ?>;
	}



/*************************** MAIN CONTENT ***************************/

/* Background Color */
.l-section,
.l-preloader,
.w-preloader,
.color_primary .g-btn.color_primary,
.w-blog.imgpos_atleft .w-blog-meta-date,
.w-portfolio-item-anchor:after,
.w-tabs-item.active,
.no-touch .w-tabs-item.active:hover,
#lang_sel ul ul,
#lang_sel_click ul ul,
#lang_sel_footer {
	background-color: <?php echo ($smof_data['main_background'] != '')?$smof_data['main_background']:'#fff'; ?>;
	}
.w-icon.color_border.with_circle .w-icon-link,
.w-pricing-item-title {
	color: <?php echo ($smof_data['main_background'] != '')?$smof_data['main_background']:'#fff'; ?>;
	}

/* Alternate Background Color */
.l-preloader-bar,
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="tel"],
input[type="number"],
input[type="date"],
textarea,
select,
.pagination .page-numbers,
.w-actionbox,
.no-touch .w-blog.imgpos_atleft .w-blog-entry:hover,
.w-comments-item-icon,
.l-main .w-contacts-item > i,
.w-icon.with_circle .w-icon-link,
.no-touch .w-portfolio-item-details-close:hover,
.no-touch .w-portfolio-item-details-arrow:hover,
.w-tabs-list,
.no-touch .w-tabs-section-header:hover,
.w-tags-item-link,
.w-testimonial-text,
.no-touch #lang_sel a:hover,
.no-touch #lang_sel_click a:hover {
	background-color: <?php echo ($smof_data['main_background_alternative'] != '')?$smof_data['main_background_alternative']:'#f2f2f2'; ?>;
	}
.w-testimonial-person:after {
	border-top-color: <?php echo ($smof_data['main_background_alternative'] != '')?$smof_data['main_background_alternative']:'#f2f2f2'; ?>;
	}

/* Border Color */
.w-blog.imgpos_atleft .w-blog-list,
.w-blog.imgpos_atleft .w-blog-entry,
.w-blog-entry.sticky,
.w-comments,
.w-pricing-item-h,
.w-portfolio-item-meta,
.w-tabs.layout_accordion,
.w-tabs.layout_accordion .w-tabs-section,
#wp-calendar thead th,
#wp-calendar tbody td,
#wp-calendar tfoot td,
.widget.widget_nav_menu .menu-item a,
.no-touch .widget.widget_nav_menu .menu-item a:hover,
#lang_sel a,
#lang_sel_click a {
	border-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}
.g-hr-h:before,
.g-hr-h:after,
.g-btn.color_default,
.w-icon.color_border.with_circle .w-icon-link {
	background-color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}
.g-hr-h i,
.w-icon.color_border .w-icon-link {
	color: <?php echo ($smof_data['main_border'] != '')?$smof_data['main_border']:'#e8e8e8'; ?>;
	}

/* Text Color */
.l-preloader-spinner,
.l-section,
input[type="text"],
input[type="password"],
input[type="email"],
input[type="url"],
input[type="tel"],
input[type="number"],
input[type="date"],
textarea,
select,
.color_primary .g-btn.color_primary,
.l-preloader-counter,
.g-btn.color_default,
.w-blog.imgpos_atleft .w-blog-entry-meta-date,
.l-main .w-contacts-item > i,
.w-icon-link {
	color: <?php echo ($smof_data['main_text'] != '')?$smof_data['main_text']:'#444'; ?>;
	}
.w-pricing-item-title {
	background-color: <?php echo ($smof_data['main_text'] != '')?$smof_data['main_text']:'#444'; ?>;
	}

/* Primary Color */
a,
.home-heading-line.type_primary,
.g-html .highlight,
.w-counter-number,
.w-icon.color_primary .w-icon-link,
.w-iconbox-icon,
.no-touch .l-subsection.color_dark .w-icon-link:hover,
.w-iconbox.with_circle .w-iconbox-icon,
.w-tabs-item.active,
.w-tabs-section.active .w-tabs-section-header,
.w-team-member-name,
.w-testimonial-person-name,
.w-preloader {
	color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#31c5c7'; ?>;
	}
.l-subsection.color_primary,
.home-heading-line.type_primary_bg,
.g-btn.color_primary,
input[type="submit"],
.no-touch .g-btn.color_secondary:after,
.pagination .page-numbers.current,
.no-touch .pagination .page-numbers.current:hover,
.w-actionbox.color_primary,
.no-touch .slick-prev:hover,
.no-touch .slick-next:hover,
.w-icon.color_primary.with_circle .w-icon-link,
.w-iconbox.with_circle .w-iconbox-icon,
.w-pricing-item.type_featured .w-pricing-item-title,
.no-touch .w-team-member-links .w-team-member-links-item:hover {
	background-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#31c5c7'; ?>;
	}
.g-html blockquote,
.no-touch .w-clients-item-h:hover,
.w-tabs-item.active,
.fotorama__thumb-border {
	border-color: <?php echo ($smof_data['main_primary'] != '')?$smof_data['main_primary']:'#31c5c7'; ?>;
	}

/* Secondary Color */
.no-touch a:hover,
.no-touch a:active,
.home-heading-line.type_secondary,
.w-icon.color_secondary .w-icon-link,
.no-touch a.w-iconbox-link:hover .w-iconbox-icon,
.no-touch a.w-iconbox-link:hover .w-iconbox-title,
.no-touch .w-tags-item-link:hover,
.no-touch .widget.widget_tag_cloud .tagcloud a:hover {
	color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#444'; ?>;
	}
.home-heading-line.type_secondary_bg,
.no-touch .g-btn.color_default:after,
.no-touch .g-btn.color_primary:after,
.no-touch input[type="submit"]:hover,
.g-btn.color_secondary,
.no-touch .pagination .page-numbers:hover,
.w-actionbox.color_secondary,
.w-icon.color_secondary.with_circle .w-icon-link,
.no-touch .w-iconbox.with_circle a.w-iconbox-link:hover .w-iconbox-icon,
.no-touch .w-tags-item-link:hover {
	background-color: <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#444'; ?>;
	}
.no-touch .w-iconbox.with_circle .w-iconbox-icon:after {
	box-shadow: 0 0 0 3px <?php echo ($smof_data['main_secondary'] != '')?$smof_data['main_secondary']:'#444'; ?>;
	}
	
/* Fade Elements Color */
.w-blog.type_post .w-blog-meta,
.w-icon.color_fade .w-icon-link,
.w-socials-item-link,
.widget.widget_tag_cloud .tagcloud a {
	color: <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#999'; ?>;
	}
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="tel"]:focus,
input[type="number"]:focus,
input[type="date"]:focus,
textarea:focus,
select:focus {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['main_fade'] != '')?$smof_data['main_fade']:'#999'; ?>;
	}

	
	
/*************************** ALTERNATE CONTENT ***************************/

/* Background Color */
.l-subsection.color_alternate,
.color_alternate .color_primary .g-btn.color_primary,
.color_alternate .w-blog.imgpos_atleft .w-blog-meta-date,
.color_alternate .w-portfolio-item-anchor:after,
.color_alternate .w-tabs-item.active,
.no-touch .color_alternate .w-tabs-item.active:hover {
	background-color: <?php echo ($smof_data['alt_background'] != '')?$smof_data['alt_background']:'#f2f2f2'; ?>;
	}
.color_alternate .w-pricing-item-title,
.color_alternate .w-icon.color_border.with_circle .w-icon-link {
	color: <?php echo ($smof_data['alt_background'] != '')?$smof_data['alt_background']:'#f2f2f2'; ?>;
	}

/* Alternate Background Color */
.color_alternate .g-btn.color_default,
.color_alternate input[type="text"],
.color_alternate input[type="password"],
.color_alternate input[type="email"],
.color_alternate input[type="url"],
.color_alternate input[type="tel"],
.color_alternate input[type="number"],
.color_alternate input[type="date"],
.color_alternate textarea,
.color_alternate select,
.color_alternate .pagination .page-numbers,
.color_alternate .w-actionbox,
.no-touch .color_alternate .w-blog.imgpos_atleft .w-blog-entry:hover,
.color_alternate .w-comments-item-icon,
.color_alternate .w-contacts-item > i,
.color_alternate .w-icon.with_circle .w-icon-link,
.no-touch .color_alternate .w-portfolio-item-details-close:hover,
.no-touch .color_alternate .w-portfolio-item-details-arrow:hover,
.color_alternate .w-tabs-list,
.no-touch .color_alternate .w-tabs-section-header:hover,
.color_alternate .w-tags.layout_block .w-tags-item-link,
.color_alternate .w-testimonial-text {
	background-color: <?php echo ($smof_data['alt_background_alternative'] != '')?$smof_data['alt_background_alternative']:'#fff'; ?>;
	}
.color_alternate .w-testimonial-person:after {
	border-top-color: <?php echo ($smof_data['alt_background_alternative'] != '')?$smof_data['alt_background_alternative']:'#fff'; ?>;
	}

/* Border Color */
.color_alternate .w-blog.imgpos_atleft .w-blog-list,
.color_alternate .w-blog.imgpos_atleft .w-blog-entry,
.color_alternate .w-comments,
.color_alternate .w-pricing-item-h,
.color_alternate .w-portfolio-item-meta,
.color_alternate .w-tabs.layout_accordion,
.color_alternate .w-tabs.layout_accordion .w-tabs-section {
	border-color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}
.color_alternate .g-hr-h:before,
.color_alternate .g-hr-h:after,
.color_alternate .g-btn.color_default,
.color_alternate .w-icon.color_border.with_circle .w-icon-link {
	background-color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}
.color_alternate .g-hr-h i,
.color_alternate .w-icon.color_border .w-icon-link {
	color: <?php echo ($smof_data['alt_border'] != '')?$smof_data['alt_border']:'#ddd'; ?>;
	}

/* Text Color */
.color_alternate,
.color_alternate input[type="text"],
.color_alternate input[type="password"],
.color_alternate input[type="email"],
.color_alternate input[type="url"],
.color_alternate input[type="tel"],
.color_alternate input[type="number"],
.color_alternate input[type="date"],
.color_alternate textarea,
.color_alternate select,
.color_alternate .g-btn.color_default,
.color_alternate .w-blog.imgpos_atleft .w-blog-entry-meta-date,
.color_alternate .w-contacts-item > i,
.color_alternate .w-icon-link {
	color: <?php echo ($smof_data['alt_text'] != '')?$smof_data['alt_text']:'#444'; ?>;
	}
.color_alternate .w-pricing-item-title {
	background-color: <?php echo ($smof_data['alt_text'] != '')?$smof_data['alt_text']:'#444'; ?>;
	}

/* Primary Color */
.color_alternate a,
.color_alternate .home-heading-line.type_primary,
.color_alternate .g-html .highlight,
.color_alternate .w-counter-number,
.color_alternate .w-icon.color_primary .w-icon-link,
.color_alternate .w-iconbox-icon,
.color_alternate .w-tabs-item.active,
.color_alternate .w-tabs-section.active .w-tabs-section-header,
.color_alternate .w-team-member-name,
.color_alternate .w-testimonial-person-name {
	color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#31c5c7'; ?>;
	}
.color_alternate .home-heading-line.type_primary_bg,
.color_alternate .g-btn.color_primary,
.color_alternate input[type="submit"],
.no-touch .color_alternate .g-btn.color_secondary:after,
.color_alternate .pagination .page-numbers.current,
.no-touch .color_alternate .pagination .page-numbers.current:hover,
.color_alternate .w-actionbox.color_primary,
.no-touch .color_alternate .slick-prev:hover,
.no-touch .color_alternate .slick-next:hover,
.color_alternate .w-icon.color_primary.with_circle .w-icon-link,
.color_alternate .w-iconbox.with_circle .w-iconbox-icon,
.color_alternate .w-pricing-item.type_featured .w-pricing-item-title,
.no-touch .color_alternate .w-team-member-links .w-team-member-links-item:hover {
	background-color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#31c5c7'; ?>;
	}
.color_alternate .g-html blockquote,
.no-touch .color_alternate .w-clients-item-h:hover,
.color_alternate .w-tabs-item.active,
.color_alternate .fotorama__thumb-border {
	border-color: <?php echo ($smof_data['alt_primary'] != '')?$smof_data['alt_primary']:'#31c5c7'; ?>;
	}

/* Secondary Color */
.no-touch .color_alternate a:hover,
.no-touch .color_alternate a:active,
.color_alternate .home-heading-line.type_secondary,
.color_alternate .w-icon.color_secondary .w-icon-link,
.no-touch .color_alternate a.w-iconbox-link:hover .w-iconbox-icon,
.no-touch .color_alternate a.w-iconbox-link:hover .w-iconbox-title,
.no-touch .color_alternate .w-tags-item-link:hover {
	color: <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#444'; ?>;
	}
.color_alternate .home-heading-line.type_secondary_bg,
.no-touch .color_alternate .g-btn.color_default:after,
.no-touch .color_alternate .g-btn.color_primary:after,
.no-touch .color_alternate input[type="submit"]:hover,
.color_alternate .g-btn.color_secondary,
.no-touch .color_alternate .pagination .page-numbers:hover,
.color_alternate .w-icon.color_secondary.with_circle .w-icon-link,
.no-touch .color_alternate .w-iconbox.with_circle a.w-iconbox-link:hover .w-iconbox-icon,
.no-touch .color_alternate .w-tags.layout_block .w-tags-item-link:hover {
	background-color: <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#444'; ?>;
	}
.no-touch .color_alternate .w-iconbox.with_circle .w-iconbox-icon:after {
	box-shadow: 0 0 0 3px <?php echo ($smof_data['alt_secondary'] != '')?$smof_data['alt_secondary']:'#444'; ?>;
	}
	
/* Fade Elements Color */
.color_alternate .w-blog.type_post .w-blog-meta,
.color_alternate .w-icon.color_fade .w-icon-link,
.color_alternate .w-socials-item-link {
	color: <?php echo ($smof_data['alt_fade'] != '')?$smof_data['alt_fade']:'#999'; ?>;
	}
.color_alternate input[type="text"]:focus,
.color_alternate input[type="password"]:focus,
.color_alternate input[type="email"]:focus,
.color_alternate input[type="url"]:focus,
.color_alternate input[type="tel"]:focus,
.color_alternate input[type="number"]:focus,
.color_alternate input[type="date"]:focus,
.color_alternate textarea:focus,
.color_alternate select:focus {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['alt_fade'] != '')?$smof_data['alt_fade']:'#999'; ?>;
	}
	

	
/*************************** FOOTER ***************************/

/* Background Color */
.l-footer,
.l-footer #lang_sel ul ul,
.l-footer #lang_sel_click ul ul {
	background-color: <?php echo ($smof_data['footer_background'] != '')?$smof_data['footer_background']:'#333'; ?>;
	}

/* Border Color */
.l-subfooter.at_top,
.l-footer #wp-calendar thead th,
.l-footer #wp-calendar tbody td,
.l-footer #wp-calendar tfoot td,
.l-footer #lang_sel a,
.l-footer #lang_sel_click a,
.l-footer .widget.widget_nav_menu .menu-item a,
.no-touch .l-footer .widget.widget_nav_menu .menu-item a:hover {
	border-color: <?php echo ($smof_data['footer_border'] != '')?$smof_data['footer_border']:'#444'; ?>;
	}
.l-footer input[type="text"],
.l-footer input[type="password"],
.l-footer input[type="email"],
.l-footer input[type="url"],
.l-footer input[type="tel"],
.l-footer input[type="number"],
.l-footer input[type="date"],
.l-footer textarea,
.l-footer select {
	background-color: <?php echo ($smof_data['footer_border'] != '')?$smof_data['footer_border']:'#444'; ?>;
	}

/* Text Color */
.l-footer,
.l-footer .w-socials-item-link,
.l-footer .widget.widget_tag_cloud .tagcloud a {
	color: <?php echo ($smof_data['footer_text'] != '')?$smof_data['footer_text']:'#999'; ?>;
	}
.l-footer input[type="text"]:focus,
.l-footer input[type="password"]:focus,
.l-footer input[type="email"]:focus,
.l-footer input[type="url"]:focus,
.l-footer input[type="tel"]:focus,
.l-footer input[type="number"]:focus,
.l-footer input[type="date"]:focus,
.l-footer textarea:focus,
.l-footer select:focus {
	box-shadow: 0 0 0 2px <?php echo ($smof_data['footer_text'] != '')?$smof_data['footer_text']:'#999'; ?>;
	}

/* Link Color */
.l-footer a,
.l-footer input[type="text"],
.l-footer input[type="password"],
.l-footer input[type="email"],
.l-footer input[type="url"],
.l-footer input[type="tel"],
.l-footer input[type="number"],
.l-footer input[type="date"],
.l-footer textarea,
.l-footer select {
	color: <?php echo ($smof_data['footer_link'] != '')?$smof_data['footer_link']:'#31c5c7'; ?>;
	}

/* Link Hover Color */
.no-touch .l-footer a:hover,
.no-touch .l-footer .w-tags-item-link:hover,
.no-touch .l-footer .widget.widget_tag_cloud .tagcloud a:hover {
	color: <?php echo ($smof_data['footer_link_hover'] != '')?$smof_data['footer_link_hover']:'#fff'; ?>;
	}

<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?>
</style>
<?php endif; ?>
<?php if ($smof_data['custom_css'] != ''): ?>
	<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?><style><?php endif; ?>

	<?php echo $smof_data['custom_css']; ?>

	<?php if (empty($output_styles_to_file) OR $output_styles_to_file == FALSE): ?></style><?php endif; ?>
<?php endif; ?>
