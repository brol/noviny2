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
if (!defined('DC_RC_PATH')) { return; }

$this->registerModule(
    'Noviny2',
    'Fork de Noviny',
    'Pierre Van Glabeke',
    '1.2',
    [
        'requires' => [['core', '2.26']],
        'type'     => 'theme',
        'tplset'   => 'mustek',
    ]
);
