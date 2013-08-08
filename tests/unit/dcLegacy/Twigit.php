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

namespace tests\unit;

include_once __DIR__  . '/../../../vendor/autoload.php';

use atoum;

class dcLegacy_Twigit extends atoum
{
  private static $dirs = array('legacy' => '/data/legacy/',
			       'twig' => '/data/twig/'
			       );

  public function testTransforms() {
    foreach (glob(__DIR__.self::$dirs['legacy'].'*.html') as $filename) {
      $twig_tpl = new \dcLegacy_Twigit($filename);
      $twig_content = $twig_tpl->transform();

      $this
	->string($twig_tpl->transform())
	->isIdenticalTo($this->getTwigFile($filename));
    }
  }

  /*
  **/
  private function getTwigFile($filename) {
    return file_get_contents(str_replace('legacy', 'twig', $filename));
  }
}