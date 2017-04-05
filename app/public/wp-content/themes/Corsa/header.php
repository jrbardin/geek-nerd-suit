<?php
global $smof_data;

$home_fullscreen_class = ($smof_data['fullscreen_home'] == '1')?' hometype_fullscreen':'';
$sticky_header_class = ($smof_data['header_is_sticky'] == '1' OR (defined('ONE_PAGE_HOME') AND ONE_PAGE_HOME))?' headertype_sticky':'';

$header_position_class = ' headerpos_top';
if ($smof_data['header_position'] == 'At the BOTTOM of the Home Section') {
	$header_position_class = ' headerpos_bottom';
} elseif ($smof_data['header_position'] == 'BELOW the Home Section') {
	$header_position_class = ' headerpos_outside';
}

$no_pagesections = '';
$sidebar_position_class = '';

if (defined('NO_PAGESECTIONS') AND NO_PAGESECTIONS)
{
	$no_pagesections = ' no_pagesections';
	$home_fullscreen_class = '';
	$header_position_class = ' headerpos_top';
	$sidebar_position_class = ' col_cont';
}

if (defined('SIDEBAR_POS') AND SIDEBAR_POS == 'left')
{
	$sidebar_position_class = ' col_sidecont';
}
if (defined('SIDEBAR_POS') AND SIDEBAR_POS == 'right')
{
	$sidebar_position_class = ' col_contside';
}
if (defined('IS_BLOG') AND IS_BLOG)
{
	switch(@$smof_data['blog_sidebar_pos']) {
		case 'Right': $sidebar_position_class = ' col_contside';
			break;
		case 'Left': $sidebar_position_class = ' col_sidecont';
			break;
		default: $sidebar_position_class = ' col_cont';
	}
}
if (defined('IS_POST') AND IS_POST)
{
	switch(@$smof_data['post_sidebar_pos']) {
		case 'Right': $sidebar_position_class = ' col_contside';
			break;
		case 'Left': $sidebar_position_class = ' col_sidecont';
			break;
		default: $sidebar_position_class = ' col_cont';
	}
}

$no_responsive_class = ( ! isset($smof_data['responsive_layout']) OR $smof_data['responsive_layout'] == 1) ? '':'no-responsive';
?><!DOCTYPE HTML>
<html class="<?php echo $no_responsive_class;?>" <?php language_attributes('html')?>>
<head>
	<meta charset="UTF-8">
	<title><?php bloginfo('name'); ?><?php wp_title(' - ', true, 'left'); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php if($smof_data['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo $smof_data['custom_favicon']; ?>"><?php } ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class("l-body".$home_fullscreen_class.$sticky_header_class.$header_position_class.$no_pagesections.$sidebar_position_class); ?>>
<?php if (defined('ONE_PAGE_HOME') AND ONE_PAGE_HOME AND ! (isset($smof_data['preloader']) AND $smof_data['preloader'] == 'Disabled')) {
	if ($smof_data['preloader'] == 'Shows Progress With Percentage') {
		?><div class='l-preloader'></div><?php
	} else {
		$preloader_type = substr($smof_data['preloader'], -1);
		if ( ! in_array($preloader_type, array(1, 2, 3, 4, 5, 6, 7, 8))) {
			$preloader_type = 1;
		}
		$preloader_type_class = ' type_'.$preloader_type;
		?><div class='l-preloader with_spinner'><?php echo "<div class='l-preloader-spinner'><div class='w-preloader ".$preloader_type_class."'><div class='w-preloader-h'></div></div></div>"; ?></div><?php
	}
}
	?>
<!-- HEADER -->
<div class="l-header<?php if (@$smof_data['header_full_width'] == 1) { echo ' full_width'; } ?>">
	<div class="l-header-h i-cf">

		<?php  if ( ! (@$smof_data['logo_as_text'] == 1 AND @$smof_data['logo_text'] == '')) { ?>
		<!-- logo -->
		<div class="w-logo<?php if (@$smof_data['logo_as_text'] == 1) { echo ' with_title'; } ?>">
			<a class="w-logo-link" href="<?php if (defined('ONE_PAGE_HOME') AND ONE_PAGE_HOME) { echo '#'; } else { if (function_exists('icl_get_home_url')) echo icl_get_home_url(); else echo esc_url(home_url('/')); } ?>">
				<img class="w-logo-img" src="<?php echo ($smof_data['custom_logo'])?$smof_data['custom_logo']:get_template_directory_uri().'/img/logo_0.png';?>"  alt="<?php bloginfo('name'); ?>"<?php if ( ! empty($smof_data['logo_height']) AND $smof_data['logo_height'] >= 20 AND $smof_data['logo_height'] <= 120) { echo ' style="height:'.$smof_data['logo_height'].'px;"'; } ?>>
				<span class="w-logo-title"><?php if (@$smof_data['logo_text'] != '') { echo $smof_data['logo_text']; } else { bloginfo('name'); } ?></span>
			</a>
		</div>
		<?php } ?>
		
<?php
$socials = array (
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
    'yelp' => 'Yelp',
    'twitch' => 'Twitch',
    'soundcloud' => 'SoundCloud',
    'deviantart' => 'DeviantArt',
    'foursquare' => 'Foursquare',
    'github' => 'GitHub',
);

$output = '';

foreach ($socials as $social_key => $social)
{
    if ($smof_data[$social_key.'_header_link'] != '')
    {
        if ($social_key == 'email')
        {
            $output .= '<div class="w-socials-item '.$social_key.'">
    <a class="w-socials-item-link" href="mailto:'.$smof_data[$social_key.'_header_link'].'">
        <i class="fa fa-envelope"></i>
    </a>
    <div class="w-socials-item-popup"><span>'.$social.'</span></div>
    </div>';

        }
        elseif ($social_key == 'google')
        {
            $output .= '<div class="w-socials-item gplus">
    <a class="w-socials-item-link" target="_blank" href="'.$smof_data[$social_key.'_header_link'].'">
        <i class="fa fa-google-plus"></i>
    </a>
    <div class="w-socials-item-popup"><span>'.$social.'</span></div>
    </div>';

        }
        elseif ($social_key == 'youtube')
        {
            $output .= '<div class="w-socials-item '.$social_key.'">
    <a class="w-socials-item-link" target="_blank" href="'.$smof_data[$social_key.'_header_link'].'">
        <i class="fa fa-youtube-play"></i>
    </a>
    <div class="w-socials-item-popup"><span>'.$social.'</span></div>
    </div>';

        }
        elseif ($social_key == 'vimeo')
        {
            $output .= '<div class="w-socials-item '.$social_key.'">
    <a class="w-socials-item-link" target="_blank" href="'.$smof_data[$social_key.'_header_link'].'">
        <i class="fa fa-vimeo-square"></i>
    </a>
    <div class="w-socials-item-popup"><span>'.$social.'</span></div>
    </div>';

        }
        else
        {
            $output .= '<div class="w-socials-item '.$social_key.'">
    <a class="w-socials-item-link" target="_blank" href="'.$smof_data[$social_key.'_header_link'].'">
        <i class="fa fa-'.$social_key.'"></i>
    </a>
    <div class="w-socials-item-popup"><span>'.$social.'</span></div>
    </div>';
        }

    }
}
if ($output != '' AND $smof_data['header_show_socials'] == 1) {
?>      <div class="w-socials">
			<div class="w-socials-list">
				<?php echo $output; ?>
			</div>
		</div>
<?php }?>

		<!-- NAV -->
		<nav class="w-nav layout_hor touch_disabled">
			<div class="w-nav-control">
				<i class="fa fa-bars"></i>
			</div>
			<ul class="w-nav-list level_1">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'corsa-main-menu',
						'container'       => 'ul',
						'container_class' => 'w-nav-list',
						'walker' => new Walker_Nav_Menu_us(),
						'items_wrap' => '%3$s',
						'fallback_cb' => false,
					));
				?>
			</ul>
		</nav>
		<!-- /NAV -->

	</div>
</div>
<!-- /HEADER -->

<?php
$l_main_classes = "";
if ( ! isset($smof_data['home_align_center']) OR $smof_data['home_align_center'] == '1'){
	$l_main_classes .= ' align_center';
}
?>
<!-- MAIN -->
<div class="l-main<?php echo $l_main_classes;?>">
