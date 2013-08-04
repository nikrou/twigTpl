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

class dcLegacy_Twigit
{
  const DC_TAG_VALUE = 'dcValue';
  const DC_TAG_BLOCK = 'dcBlock';
  const DC_END_TAG_BLOCK = 'enddcBlock';
  const DC_TAG_CONTEXT = 'dcContext';

  public function __construct($filename) {
    if (!file_exists($filename)) {
      throw new Exception(sprintf('File %s does not exist.', $filename));
    }

    $this->filename = $filename;
  }

  public function transform() {
    $html_content = file_get_contents($this->filename);

    $html_content = preg_replace('`{{tpl:lang ([^}]*)}}`', '{% '.self::DC_TAG_VALUE.' lang "$1" %}', $html_content);
    $html_content = preg_replace('`{{tpl:include src="([^"]*)"}}`', '{% include "$1" %}', $html_content);
    $html_content = preg_replace('`<tpl:([^ >]*) ([^>]*)>`', '{% '.self::DC_TAG_BLOCK.' $1=$2 %}', $html_content);
    $html_content = preg_replace('`<tpl:([^>]*)>`', '{% '.self::DC_TAG_BLOCK.' $1 %}', $html_content);
    $html_content = preg_replace('`</tpl:([^>]*)>`', '{% '.self::DC_END_TAG_BLOCK.' %}', $html_content);
    $html_content = preg_replace('`{{tpl:([^ }]*) ([^}]*)}}`', '{% '.self::DC_TAG_VALUE.' $1=$2 %}', $html_content);
    $html_content = preg_replace('`{{tpl:([^}]*)}}`', '{% dcValue $1 %}', $html_content);

    return '{% '.self::DC_TAG_CONTEXT.' %}'.$html_content;
  }
}