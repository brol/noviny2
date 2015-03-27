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

l10n::set(dirname(__FILE__).'/locales/'.$_lang.'/public');

# appel css select
if ($core->blog->settings->themes->noviny2_select)
{
	$core->addBehavior('publicHeadContent',
		array('tplnoviny2_select','publicHeadContent'));
}

class tplnoviny2_select
{
	public static function publicHeadContent($core)
	{
	$url = $core->blog->settings->system->themes_url.'/'.$core->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/select.css\" />\n";
	}
}

# appel css overview
if ($core->blog->settings->themes->noviny2_overview)
{
	$core->addBehavior('publicHeadContent',
		array('tplnoviny2_overview','publicHeadContent'));
}

class tplnoviny2_overview
{
	public static function publicHeadContent($core)
	{
	$url = $core->blog->settings->system->themes_url.'/'.$core->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/overview.css\" />\n";
	}
}

# appel css news
if ($core->blog->settings->themes->noviny2_news)
{
	$core->addBehavior('publicHeadContent',
		array('tplnoviny2_news','publicHeadContent'));
}

class tplnoviny2_news
{
	public static function publicHeadContent($core)
	{
	$url = $core->blog->settings->system->themes_url.'/'.$core->blog->settings->system->theme;
		echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$url."/css/news.css\" />\n";
	}
}

# We add some scripts in all pages
$core->addBehavior('publicHeadContent',array('behaviorsNoviny2','publicHeadContent'));

# All tags go to archives
//$core->url->unregister('tags');
//$core->url->register('tags','tags','^tags$',array('dcUrlHandlers','archive'));

# Ajax search URL
$core->url->register('ajaxsearch','ajaxsearch','^ajaxsearch(?:(?:/)(.*))?$',array('urlsNoviny2','ajaxsearch'));

class behaviorsNoviny2
{
	public static function publicHeadContent($core)
	{
		echo
		'<script type="text/javascript">'."\n".
		"//<![CDATA[\n".
		'var noviny2 = { '.
		"ajaxsearch: '".html::escapeJS($core->blog->url.$core->url->getBase('ajaxsearch'))."/' ".
		"};\n".
		"//]]>\n".
		"</script>\n".
		'<script type="text/javascript" src="'.$core->blog->settings->system->themes_url.'/'.$core->blog->settings->system->theme.'/search.js"></script>';
	}
}

class urlsNoviny2
{
	public static function ajaxsearch($args)
	{
		global $core;
		$res = '';

		try
		{
			if (!$args) {
				throw new Exception;
			}

			$q = rawurldecode($args);
			$rs = $core->blog->getPosts(array(
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