<?php
/**
 * This file is part of Container package.
 *
 * For copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Gedex\Container;

/**
 * DoublyLinkedListElement is an element of a linked list.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 *
 * @api
 */
class DoublyLinkedListElement implements Element
{
    /**
     * Value stored with this element.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Next element.
     *
     * @var DoublyLinkedListElement
     */
    public $nextElement;

    /**
     * Previous element.
     *
     * @var DoublyLinkedListElement
     */
    public $prevElement;

    /**
     * The list to which this element belongs.
     *
     * @var DoublyLinkedList
     */
    public $listContainer;

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
    }
 
    /**
     * Returns the next list element or null.
     *
     * @return DoublyLinkedListElement|null Next element
     *
     * @api
     */
    public function getNext()
    {
        $el = $this->nextElement;
        if ($this->listContainer !== null && $el !== $this->listContainer->root) {
            return $el;
        }
        return null;
    }

    /**
     * Returns the previous list element or null.
     *
     * @return DoublyLinkedListElement|null Previous element
     *
     * @api
     */
    public function getPrev()
    {
        $el = $this->prevElement;
        if ($this->listContainer !== null && $el !== $this->listContainer->root) {
            return $el;
        }
        return null;
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
}

