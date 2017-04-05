<?php

if(!function_exists('us_dataImport'))
{
	function us_dataImport()
	{
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

		require_once(get_template_directory().'/vendor/wordpress-importer/wordpress-importer.php');

		if(!is_file(get_template_directory().'/xml/demo_data.xml'))
		{

			echo "Automatic import failed. Please use the wordpress importer and import the XML file (Corsa/xml/demo_data.xml) manually.";
		}
		else
		{
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			$wp_import->import(get_template_directory().'/xml/demo_data.xml');

			// Set menu
			$locations = get_theme_mod('nav_menu_locations');
			$menus  = wp_get_nav_menus();

			if(!empty($menus))
			{
				foreach($menus as $menu)
				{
					if(is_object($menu) && $menu->name == 'Corsa Main Menu')
					{
						$locations['corsa-main-menu'] = $menu->term_id;
					}
				}
			}

			set_theme_mod('nav_menu_locations', $locations);

			//Import options
			$smof_data = unserialize(base64_decode(file_get_contents(get_template_directory().'/xml/demo_options.txt'))); //100% safe - ignore theme check nag
			of_save_options($smof_data);
			us_save_styles($smof_data);

			//Set Front Page
			$front_page = get_page_by_title('Home');

			if(isset($front_page->ID)) {
				update_option('show_on_front', 'page');
				update_option('page_on_front',  $front_page->ID);
			}
		}


		die();
	}

	add_action('wp_ajax_us_dataImport', 'us_dataImport');
}
