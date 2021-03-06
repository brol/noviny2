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

$this->registerModule(
	/* Name */			   "Noviny2",
	/* Description*/	 "Fork de Noviny",
	/* Author */		   "Pierre Van Glabeke",
	/* Version */		   "1.1",
	array(
		'type'	 =>	'theme',
		'tplset' => 'mustek',
		'dc_min' => '2.15'
	)
);