<?php
/**
 * @brief Noviny2, a theme for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Theme
 *
 * @author Pierre Van Glabeke
 * @copyright https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
if (!defined('DC_CONTEXT_ADMIN')) { return; }

// Load contextual help
if (file_exists(dirname(__FILE__) . '/locales/' . dcCore::app()->lang . '/resources.php')) {
    require dirname(__FILE__) . '/locales/' . dcCore::app()->lang . '/resources.php';
}

//PARAMS

# Translations
l10n::set(__DIR__ . '/locales/' . dcCore::app()->lang . '/main');

# Default values
$default_menu = 'simplemenu';
$default_select = false;
$default_overview = false;
$default_news = false;

# Settings
$my_menu = dcCore::app()->blog->settings->themes->noviny2_menu;
$my_select = dcCore::app()->blog->settings->themes->noviny2_select;
$my_overview = dcCore::app()->blog->settings->themes->noviny2_overview;
$my_news = dcCore::app()->blog->settings->themes->noviny2_news;

# Menu type
$noviny2_menu_combo = array(
	__('SimpleMenu') => 'simplemenu',
	__('Menu') => 'menu',
	__('None') => 'nomenu'
);

# Select
$html_fileselect = path::real(dcCore::app()->blog->themes_path).'/'.dcCore::app()->blog->settings->system->theme.'/tpl/inc-select.html';
if (!is_file($html_fileselect) && !is_writable(dirname($html_fileselect))) {
	throw new Exception(
		sprintf(__('File %s does not exist and directory %s is not writable.'),
		$css_fileselect,dirname($html_fileselect))
	);
}

# Overview
$html_fileoverview = path::real(dcCore::app()->blog->themes_path).'/'.dcCore::app()->blog->settings->system->theme.'/tpl/inc-overview.html';

$overview = dcCore::app()->blog->settings->themes->noviny2_overview;

if (!is_file($html_fileoverview) && !is_writable(dirname($html_fileoverview))) {
	throw new Exception(
		sprintf(__('File %s does not exist and directory %s is not writable.'),
		$css_fileoverview,dirname($html_fileoverview))
	);
}

# News
$html_filenews = path::real(dcCore::app()->blog->themes_path).'/'.dcCore::app()->blog->settings->system->theme.'/tpl/inc-news.html';

$news = dcCore::app()->blog->settings->themes->noviny2_news;

if (!is_file($html_filenews) && !is_writable(dirname($html_filenews))) {
	throw new Exception(
		sprintf(__('File %s does not exist and directory %s is not writable.'),
		$css_filenews,dirname($html_filenews))
	);
}

// POST ACTIONS

if (!empty($_POST))
{
	try
	{
		dcCore::app()->blog->settings->addNamespace('themes');

		# Menu type
		if (!empty($_POST['noviny2_menu']) && in_array($_POST['noviny2_menu'],$noviny2_menu_combo))	{
			$my_menu = $_POST['noviny2_menu'];
		} elseif (empty($_POST['noviny2_menu'])) {
			$my_menu = $default_menu;
		}
		dcCore::app()->blog->settings->themes->put('noviny2_menu',$my_menu,'string','Menu to display',true);

		# select
		if (!empty($_POST['noviny2_select'])) {
			$my_select = $_POST['noviny2_select'];
		} elseif (empty($_POST['noviny2_select'])) {
			$my_select = $default_select;
		}
		dcCore::app()->blog->settings->themes->put('noviny2_select',$my_select,'boolean', 'Display Select',true);

		if (isset($_POST['select'])) {
			@$fp = fopen($html_fileselect,'wb');
			fwrite($fp,$_POST['select']);
			fclose($fp);
		}

		# Overview
		if (!empty($_POST['noviny2_overview']))	{
			$my_overview = $_POST['noviny2_overview'];
		} elseif (empty($_POST['noviny2_overview'])) {
			$my_overview = $default_overview;
		}
		dcCore::app()->blog->settings->themes->put('noviny2_overview',$my_overview,'boolean', 'Display Overview',true);

		if (isset($_POST['overview'])) {
			@$fp = fopen($html_fileoverview,'wb');
			fwrite($fp,$_POST['overview']);
			fclose($fp);
		}

		# News
		if (!empty($_POST['noviny2_news']))	{
			$my_news = $_POST['noviny2_news'];
		} elseif (empty($_POST['noviny2_news'])) {
			$my_news = $default_news;
		}
		dcCore::app()->blog->settings->themes->put('noviny2_news',$my_news,'boolean', 'Display News',true);

		if (isset($_POST['news'])) {
			@$fp = fopen($html_filenews,'wb');
			fwrite($fp,$_POST['news']);
			fclose($fp);
		}

		// Blog refresh
		dcCore::app()->blog->triggerBlog();

		// Template cache reset
		dcCore::app()->emptyTemplatesCache();

		dcPage::success(__('Theme configuration has been successfully updated.'),true,true);
	} catch (Exception $e) {
		dcCore::app()->error->add($e->getMessage());
	}
}

$html_contentselect = is_file($html_fileselect) ? file_get_contents($html_fileselect) : '';
$html_contentoverview = is_file($html_fileoverview) ? file_get_contents($html_fileoverview) : '';
$html_contentnews = is_file($html_filenews) ? file_get_contents($html_filenews) : '';

// DISPLAY

# Menu type
echo
'<div class="fieldset"><h4>'.__('Menu').'</h4>'.
'<p class="field"><label>'.__('Menu to display:').'</label>'.
form::combo('noviny2_menu',$noviny2_menu_combo,$my_menu).
'</p>'.
'</div>';

# Select
echo
'<div class="fieldset"><h4>'.__('Customizing the home page').'</h4>'.
'<p>'.
	form::checkbox('noviny2_select',1,$my_select).
	'<label class="classic" for="noviny2_select">'.
		__('Display Select').
	'</label>'.
'</p>';

echo
'<p class="area"><label for="select">'.__('Code:').' '.
form::textarea('select',60,27,html::escapeHTML($html_contentselect)).'</label></p>';

# Overview
echo
'<p>'.
	form::checkbox('noviny2_overview',1,$my_overview).
	'<label class="classic" for="noviny2_overview">'.
		__('Display Overview').
	'</label>'.
'</p>';

echo
'<p class="area"><label for="overview">'.__('Code:').' '.
form::textarea('overview',60,27,html::escapeHTML($html_contentoverview)).'</label></p>';

# News
echo
'<p>'.
	form::checkbox('noviny2_news',1,$my_news).
	'<label class="classic" for="noviny2_news">'.
		__('Display Breaking news').
	'</label>'.
'</p>';

echo
'<p class="area"><label for="news">'.__('Code:').' '.
form::textarea('news',60,15,html::escapeHTML($html_contentnews)).'</label></p>'.
'</div>';

dcPage::helpBlock('noviny2');
