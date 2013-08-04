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

class twigTplBehaviors
{
  /*
  * Find template in $core->tpl->getPath() array
  * Transform the html content in a twig template
  * Serve it to Twig Engine
  */
  public static function serveDocument($_ctx) {
    global $core;

    $tpl_file = null;
    $tpl_file = self::getFilePath($_ctx->current_tpl);

    if (!$tpl_file) {
      throw new Exception('No template found for '.$_ctx->current_tpl);
    }

    self::createIncludedTemplate($tpl_file);
    self::createTwigTemplate($tpl_file);

    $loader = new Twig_Loader_Filesystem(DC_TPL_CACHE.'/twigtpl');
    $twig = new Twig_Environment($loader, array('cache' => DC_TPL_CACHE.'/twig'));

    $twig->addExtension(new dcLegacy_Extension());
    $twig->addExtension(new Twig_Extensions_Extension_I18n());
    $twig->addExtension(new Twig_Extensions_Extension_Text());

    $template = $twig->loadTemplate($_ctx->current_tpl);
    $template->display(array('core' => &$core));
    exit();
  }

  private static function createTwigTemplate($tpl_file) {
    $dest_file = DC_TPL_CACHE.'/twigtpl/'.basename($tpl_file);
    clearstatcache();
    $stat_f = $stat_d = false;
    if (file_exists($dest_file)) {
      $stat_f = stat($tpl_file);
      $stat_d = stat($dest_file);
    }
    if (!$stat_d || $stat_d['size'] == 0 || $stat_f['mtime'] > $stat_d['mtime']) {
      files::makeDir(dirname($dest_file), true);

      if (($fp = @fopen($dest_file, 'wb')) === false) {
	throw new Exception('Unable to create twig template file');
      }

      $twig_tpl = new dcLegacy_Twigit($tpl_file);
      $twig_content = $twig_tpl->transform();
      fwrite($fp, $twig_content);
      fclose($fp);
      files::inheritChmod($dest_file);
    }
  }

  private static function createIncludedTemplate($tpl_file) {
    preg_match_all('`{{tpl:include src="([^"]*)"}}`', file_get_contents($tpl_file), $matches);

    if (!empty($matches[1])) {
      foreach ($matches[1] as $m) {
	$included_file = self::getFilePath($m);
	self::createIncludedTemplate($included_file);
	self::createTwigTemplate($included_file);
      }
    }
  }

  private static function getFilePath($file) {
    foreach ($GLOBALS['core']->tpl->getPath() as $p) {
      if (file_exists($p.'/'.$file)) {
	return $p.'/'.$file;
      }
    }

    return false;
  }
}
