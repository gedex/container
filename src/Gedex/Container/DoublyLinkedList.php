<?php
/**
 * This file is part of Container package.
 *
 * For copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Gedex\Container;

/**
 * DoublyLinkedList implements a doubly linked list.
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 *
 * @api
 */
class DoublyLinkedList
{
    /**
     * Sentinel list element.
     *
     * @var Element
     */
    public $root;

    /**
     * Current list length excluding (this) sentinel element.
     *
     * @var int
     */
    private $length;

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct()
    {
        $this->root = new DoublyLinkedListElement();
        $this->root->nextElement = $this->root;
        $this->root->prevElement = $this->root;
        $this->length = 0;
    }

    /**
     * Returns the number of elements in the list.
     *
     * The complexity is O(1).
     *
     * @return int Number of elements in the list.
     *
     * @api
     */
    public function len()
    {
        return $this->length;
    }

    /**
     * Returns the first element in the list.
     *
     * @return DoublyLinkedListElement|null The first element in the list
     *
     * @api
     */
    public function getFront()
    {
        if ($this->length === 0) {
            return null;
        }

        return $this->root->nextElement;
    }

    /**
     * Returns the last element in the list.
     *
     * @return DoublyLinkedListElement|null The last element in the list
     *
     * @api
     */
    public function getBack()
    {
        if ($this->length === 0) {
            return null;
        }

        return $this->root->prevElement;
    }

    /**
     * Inserts a after b, increments list length, and returns a.
     *
     * @param DoublyLinkedListElement $a Element to insert
     * @param DoublyLinkedListElement $b Mark element
     *
     * @return DoublyLinkedListElement New inserted element
     */
    protected function insert(DoublyLinkedListElement $a, DoublyLinkedListElement $b)
    {
        $bNext = $b->nextElement;
        $b->nextElement = $a;
        $a->prevElement = $b;
        $a->nextElement = $bNext;
        $bNext->prevElement = $a;
        $a->listContainer = $this;
        $this->length++;

        return $a;
    }

    /**
     * Convenience wrapper for insert.
     *
     * Creates new value with given value and insert it after b.
     *
     * @param mixed $value Value of new element
     * @param DoublyLinkedListElement Mark element
     *
     * @return DoublyLinkedListElement New inserted element
     */
    protected function insertValue($value, DoublyLinkedListElement $b)
    {
        $el = new DoublyLinkedListElement($value);
        return $this->insert($el, $b);
    }

    /**
     * Removes element from its list, decrement list length, and returns removed
     * element.
     *
     * @return DoublyLinkedListElement Removed element
     */
    protected function removeEl(DoublyLinkedListElement $el)
    {
        $el->prevElement->nextElement = $el->nextElement;
        $el->nextElement->prevElement = $el->prevElement;
        $el->nextElement = null;
        $el->prevElement = null;
        $el->listContainer = null;

        $this->length--;

        return $el;
    }

    /**
     * Removes element from list.
     *
     * @param DoublyLinkedListElement $el Element to remove from the list
     *
     * @return mixed Returns the element value
     *
     * @api
     */
    public function remove(DoublyLinkedListElement $el)
    {
        if ($el->listContainer === $this) {
            $this->removeEl($el);
        }

        return $el->getValue();
    }

    /**
     * Inserts a new element at the front of list and returns the new element.
     *
     * @param mixed $value Value of new element
     *
     * @return DoublyLinkedListElement New inserted element
     *
     * @api
     */
    public function pushFront($value)
    {
        return $this->insertValue($value, $this->root);
    }

    /**
     * Inserts a new element at the back of list and returns the new element.
     *
     * @param mixed $value Value of new element
     *
     * @return DoublyLinkedListElement New inserted element
     *
     * @api
     */
    public function pushBack($value)
    {
        return $this->insertValue($value, $this->root->prevElement);
    }

    /**
     * Inserts a new element immediately before specified element and returns
     * the new element.
     *
     * If specified element is not an element of list, the list is not modified.
     *
     * @param mixed                   $value Value of new element
     * @param DoublyLinkedListElement $el    Mark element
     *
     * @return DoublyLinkedListElement|null New inserted element or null
     *
     * @api
     */
    public function insertBefore($value, DoublyLinkedListElement $el)
    {
        if ($el->listContainer !== $this) {
            return null;
        }

        return $this->insertValue($value, $el->prevElement);
    }

    /**
     * Inserts a new element immediately after specified element and returns the
     * new element.
     *
     * If specified element is not an element of list, the list is not modified.
     *
     * @param mixed                   $value Value of new element
     * @param DoublyLinkedListElement $el    Mark element
     *
     * @return DoublyLinkedListElement|null New inserted element or null
     *
     * @api
     */
    public function insertAfter($value, DoublyLinkedListElement $el)
    {
        if ($el->listContainer !== $this) {
            return null;
        }

        return $this->insertValue($value, $el);
    }

    /**
     * Moves element to the front of list.
     *
     * If element is not an element of list, the list is not modified.
     *
     * @param DoublyLinkedListElement $el Element to be moved to the front of list
     *
     * @api
     */
    public function moveToFront(DoublyLinkedListElement $el)
    {
        if ($el->listContainer !== $this || $this->root->nextElement === $el) {
            return;
        }

        $this->insert($this->removeEl($el), $this->root);
    }

    /**
     * Moves element to the back of list.
     *
     * If element is not an element of list, the list is not modified.
     *
     * @param DoublyLinkedListElement $el Element to be moved to the back of list
     *
     * @api
     */
    public function moveToBack(DoublyLinkedListElement $el)
    {
        if ($el->listContainer !== $this || $this->root->prevElement === $el) {
            return;
        }

        $this->insert($this->removeEl($el), $this->root->prevElement);
    }

    /**
     * Moves element a to its new position before element b.
     *
     * @param DoublyLinkedListElement $a Element to move
     * @param DoublyLinkedListElement $b Mark element 
     *
     * @api
     */
    public function moveBefore(DoublyLinkedListElement $a, DoublyLinkedListElement $b)
    {
        if ($a->listContainer !== $this || $a === $b || $b->listContainer !== $this) {
            return;
        }

        $this->insert($this->removeEl($a), $b->prevElement);
    }

    /**
     * Moves element a to its new position after element b.
     *
     * @param DoublyLinkedListElement $a Element to move
     * @param DoublyLinkedListElement $b Mark element 
     *
     * @api
     */
    public function moveAfter(DoublyLinkedListElement $a, DoublyLinkedListElement $b)
    {
        if ($a->listContainer !== $this || $a === $b || $b->listContainer !== $this) {
            return;
        }

        $this->insert($this->removeEl($a), $b);
    }

    /**
     * Inserts a copy of an other list at the back of list.
     *
     * Other list and current list may be the same.
     *
     * @param DoublyLinkedList $other Other list to insert
     *
     * @api
     */
    public function pushBackList(DoublyLinkedList $other)
    {
        for ($i = $other->len(), $el = $other->getFront(); $i > 0; $i--, $el = $el->getNext()) {
            $this->insertValue($el->getValue(), $this->root->prevElement);
        }
    }

    /**
     * Inserts a copy of an other list at the front of list.
     *
     * Other list and current list may be the same.
     *
     * @param DoublyLinkedList $other Other list to insert
     *
     * @api
     */
    public function pushFrontList(DoublyLinkedList $other)
    {
        for ($i = $other->len(), $el = $other->getBack(); $i > 0; $i--, $el = $el->getPrev()) {
            $this->insertValue($el->getValue(), $this->root);
        }
    }

}
