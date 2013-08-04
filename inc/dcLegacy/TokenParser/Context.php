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

class dcLegacy_TokenParser_Context extends Twig_TokenParser
{
  public function parse(Twig_Token $token) {
    $lineno = $token->getLine();
    $stream = $this->parser->getStream();
    $name = $stream->expect(Twig_Token::BLOCK_END_TYPE);

    return new dcLegacy_Node_Context($lineno);
  }

  public function getTag() {
    return dcLegacy_Twigit::DC_TAG_CONTEXT;
  }
}