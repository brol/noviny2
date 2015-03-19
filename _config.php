<?php
# ***** BEGIN LICENSE BLOCK *****
#
# Noviny2
# Theme by Pierre Van Glabeke
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# ***** END LICENSE BLOCK *****
if (!defined('DC_CONTEXT_ADMIN')) { return; }

// Load contextual help
if (file_exists(dirname(__FILE__).'/locales/'.$_lang.'/resources.php')) {
	require dirname(__FILE__).'/locales/'.$_lang.'/resources.php';
}

global $core;

//PARAMS

# Translations
l10n::set(dirname(__FILE__).'/locales/'.$_lang.'/main');

# Default values
$default_select = false;
$default_overview = false;
$default_news = false;

# Settings
$my_select = $core->blog->settings->themes->noviny2_select;
$my_overview = $core->blog->settings->themes->noviny2_overview;
$my_news = $core->blog->settings->themes->noviny2_news;

# Select
$html_fileselect = path::real($core->blog->themes_path).'/'.$core->blog->settings->system->theme.'/tpl/inc-select.html';

if (!is_file($html_fileselect) && !is_writable(dirname($html_fileselect))) {
	throw new Exception(
		sprintf(__('File %s does not exist and directory %s is not writable.'),
		$css_fileselect,dirname($html_fileselect))
	);
}

# Overview
$html_fileoverview = path::real($core->blog->themes_path).'/'.$core->blog->settings->system->theme.'/tpl/inc-overview.html';

$overview = $core->blog->settings->themes->noviny2_overview;

if (!is_file($html_fileoverview) && !is_writable(dirname($html_fileoverview))) {
	throw new Exception(
		sprintf(__('File %s does not exist and directory %s is not writable.'),
		$css_fileoverview,dirname($html_fileoverview))
	);
}

# Overview
$html_filenews = path::real($core->blog->themes_path).'/'.$core->blog->settings->system->theme.'/tpl/inc-news.html';

$news = $core->blog->settings->themes->noviny2_news;

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
		$core->blog->settings->addNamespace('themes');

		# select
		if (!empty($_POST['noviny2_select']))
		{
			$my_select = $_POST['noviny2_select'];


		} elseif (empty($_POST['noviny2_select']))
		{
			$my_select = $default_select;

		}
		$core->blog->settings->themes->put('noviny2_select',$my_select,'boolean', 'Display Select',true);

		if (isset($_POST['select']))
		{
			@$fp = fopen($html_fileselect,'wb');
			fwrite($fp,$_POST['select']);
			fclose($fp);
		}

		# Overview
		if (!empty($_POST['noviny2_overview']))
		{
			$my_overview = $_POST['noviny2_overview'];

		} elseif (empty($_POST['noviny2_overview']))
		{
			$my_overview = $default_overview;

		}
		$core->blog->settings->themes->put('noviny2_overview',$my_overview,'boolean', 'Display Overview',true);

		if (isset($_POST['overview']))
		{
			@$fp = fopen($html_fileoverview,'wb');
			fwrite($fp,$_POST['overview']);
			fclose($fp);
		}

		# News
		if (!empty($_POST['noviny2_news']))
		{
			$my_news = $_POST['noviny2_news'];

		} elseif (empty($_POST['noviny2_news']))
		{
			$my_news = $default_news;

		}
		$core->blog->settings->themes->put('noviny2_news',$my_news,'boolean', 'Display News',true);

		if (isset($_POST['news']))
		{
			@$fp = fopen($html_filenews,'wb');
			fwrite($fp,$_POST['news']);
			fclose($fp);
		}

		// Blog refresh
		$core->blog->triggerBlog();

		// Template cache reset
		$core->emptyTemplatesCache();

		dcPage::success(__('Theme configuration has been successfully updated.'),true,true);
	}
	catch (Exception $e)
	{
		$core->error->add($e->getMessage());
	}
}

$html_contentselect = is_file($html_fileselect) ? file_get_contents($html_fileselect) : '';
$html_contentoverview = is_file($html_fileoverview) ? file_get_contents($html_fileoverview) : '';
$html_contentnews = is_file($html_filenews) ? file_get_contents($html_filenews) : '';

// DISPLAY

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