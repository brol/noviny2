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
if (!defined('DC_RC_PATH')) { return; }

l10n::set(dirname(__FILE__) . '/locales/' . dcCore::app()->lang. '/public');

# appel css menu
dcCore::app()->addBehavior('publicHeadContent','noviny2menu_publicHeadContent');

function noviny2menu_publicHeadContent()
{
	$style = dcCore::app()->blog->settings->themes->noviny2_menu;
	if (!preg_match('/^simplemenu|menu|nomenu$/', (string) $style)) {
		$style = 'simplemenu';
	}

	$url = dcCore::app()->blog->settings->system->themes_url.'/'.dcCore::app()->blog->settings->system->theme;
	echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/".$style.".css\" />\n";
}

# appel css select
if (dcCore::app()->blog->settings->themes->noviny2_select)
{
	dcCore::app()->addBehavior('publicHeadContent',
		['tplnoviny2_select','publicHeadContent']);
}

class tplnoviny2_select
{
	public static function publicHeadContent()
	{
	$url = dcCore::app()->blog->settings->system->themes_url.'/'.dcCore::app()->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/select.css\" />\n";
	}
}

# appel css overview
if (dcCore::app()->blog->settings->themes->noviny2_overview)
{
	dcCore::app()->addBehavior('publicHeadContent',
		['tplnoviny2_overview','publicHeadContent']);
}

class tplnoviny2_overview
{
	public static function publicHeadContent()
	{
	$url = dcCore::app()->blog->settings->system->themes_url.'/'.dcCore::app()->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/overview.css\" />\n";
	}
}

# appel css news
if (dcCore::app()->blog->settings->themes->noviny2_news)
{
	dcCore::app()->addBehavior('publicHeadContent',
		['tplnoviny2_news','publicHeadContent']);
}

class tplnoviny2_news
{
	public static function publicHeadContent()
	{
	$url = dcCore::app()->blog->settings->system->themes_url.'/'.dcCore::app()->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/news.css\" />\n";
	}
}

# We add some scripts in all pages
dcCore::app()->addBehavior('publicHeadContent',['behaviorsNoviny2','publicHeadContent']);

# All tags go to archives
//dcCore::app()->url->unregister('tags');
//dcCore::app()->url->register('tags','tags','^tags$',array('dcUrlHandlers','archive'));

# Ajax search URL
dcCore::app()->url->register('ajaxsearch','ajaxsearch','^ajaxsearch(?:(?:/)(.*))?$',array('urlsNoviny2','ajaxsearch'));

class behaviorsNoviny2
{
	public static function publicHeadContent()
	{
		echo
		'<script>'."\n".
		"//<![CDATA[\n".
		'var noviny2 = { '.
		"ajaxsearch: '".html::escapeJS(dcCore::app()->blog->url.dcCore::app()->url->getBase('ajaxsearch'))."/' ".
		"};\n".
		"//]]>\n".
		"</script>\n".
		'<script src="'.dcCore::app()->blog->settings->system->themes_url.'/'.dcCore::app()->blog->settings->system->theme.'/search.js"></script>';
	}
}

class urlsNoviny2
{
	public static function ajaxsearch($args)
	{
		dcCore::app();
		$res = '';

		try
		{
			if (!$args) {
				throw new Exception;
			}

			$q = rawurldecode($args);
			$rs = dcCore::app()->blog->getPosts(array(
				'search' => $q,
				'limit' => 5
			));

			if ($rs->isEmpty()) {
				throw new Exception;
			}

			$res = '<ul>';
			while ($rs->fetch())
			{
				$res .= '<li><a href="'.$rs->getURL().'">'.html::escapeHTML($rs->post_title).'</a></li>';
			}
			$res .= '</ul>';
		}
		catch (Exception $e) {}

		header('Content-Type: text/plain; charset=UTF-8');
		echo $res;
	}
}
