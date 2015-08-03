<?php
/**
 * This file is part of Container package.
 *
 * For copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Gedex\Container;

/**
 * CircularListElement is an element of circular list.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 *
 * @api
 */
class CircularListElement implements Element {
    /**
     * Value stored with this element.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Next element.
     *
     * @var CircularListElement
     */
    public $nextElement;

    /**
     * Previous element.
     *
     * @var CircularListElement
     */
    public $prevElement;

    /**
     * Constructor.
     *
     * @param mixed $value Value stored by this element
     *
     * @api
     */
    public function __construct($value = null)
    {
        $this->value = $value;
        $this->nextElement = $this;
        $this->prevElement = $this;
    }

    /**
     * Returns the next list element or null.
     *
     * @return DoublyLinkedListElement Next element
     *
     * @api
     */
    public function getNext()
    {
        return $this->nextElement;
    }

    /**
     * Returns the previous list element or null.
     *
     * @return DoublyLinkedListElement Previous element
     *
     * @api
     */
    public function getPrev()
    {
        return $this->prevElement;
    }

    /**
     * Get value stored by this element.
     *
     * @return mixed Value stored by this element 
     *
     * @api
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set value for this element.
     *
     * @param mixed $value Value for this element.
     *
     * @api
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
