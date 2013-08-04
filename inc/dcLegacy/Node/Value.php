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

class dcLegacy_Node_Value extends Twig_Node
{
  public function __construct($name, $attr, $attr_str, $lineno, $tag = null) {
    parent::__construct(array(), array(), $lineno, $tag);

    $this->name = $name;
    $this->attr = $attr;
    $this->attr_str = $attr_str;
  }

  public function compile(Twig_Compiler $compiler) {
    $compiler->addDebugInfo($this);
    $php_content = call_user_func($GLOBALS['core']->tpl->getValueCallback($this->name),
				  $this->attr,
				  $this->attr_str
				  );
    $compiler->write(" ?>".$php_content."<?php ");
  }
}