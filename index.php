<?php
// +-----------------------------------------------------------------------+
// | twigTpl  - a plugin for Dotclear                                      |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2013 Nicolas Roudaire             http://www.nikrou.net  |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License version 2 as     |
// | published by the Free Software Foundation.                            |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,            |
// | MA 02110-1301 USA.                                                    |
// +-----------------------------------------------------------------------+

if (!defined('DC_CONTEXT_ADMIN')) { exit; }

$core->blog->settings->addNameSpace('twigtpl');
$twigtpl_active = $core->blog->settings->twigtpl->active;

if (!empty($_POST['saveconfig'])) {
  try {
    $twigtpl_active = (empty($_POST['twigtpl_active']))?false:true;
    $core->blog->settings->twigtpl->put('active', $twigtpl_active, 'boolean');

    $message = __('Configuration successfully updated');
  } catch(Exception $e) {
    $core->error->add($e->getMessage());
  }
}

include(dirname(__FILE__).'/tpl/index.tpl');
