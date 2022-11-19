<?php
/*
Plugin Name:	E2E Company House API
Plugin URI:		https://e2estudios.com
Description:	Company House API is a system to allow wordpress elements to interact with Company House Data. Developed by E2E Studios LTD
Version:		1.0.0
Author:			E2E Studios
Author URI:		https://e2estudios.com
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if (!defined('WPINC')) {
    die;
}

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/e2es/company_house_api',
    __FILE__
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');

    include(plugin_dir_path(__FILE__) . 'admin/main.php');

?>
