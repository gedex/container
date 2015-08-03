<?php
/**
 * This file is part of Container package.
 *
 * For copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Gedex\Container;

/**
 * Element interface.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 *
 * @api
 */
interface Element {
    public function getNext();
    public function getPrev();
    public function getValue();
}
