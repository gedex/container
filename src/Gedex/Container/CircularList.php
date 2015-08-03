<?php
/**
 * This file is part of Container package.
 *
 * For copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Gedex\Container;

/**
 * CircularList implements circular list and its operations.
 *
 * CircularList
 *
 * @author Akeda Bagus <admin@gedex.web.id>
 *
 * @api
 */
class CircularList
{
    /**
     * Cursor of element in list.
     *
     * @var CircularListElement
     */
    protected $cursor;

    /**
     * Constructor.
     *
     * @param int $n Number of elements to create
     *
     * @api
     */
    public function __construct($n = 1)
    {
        if ($n <= 0) {
            return;
        }

        $root = new CircularListElement();
        $el = $root;
        for ($i = 1; $i < $n; $i++) {
            $next = new CircularListElement();
            $next->prevElement = $el;
            $el->nextElement = $next;

            $el = $next;
        }
        $el->nextElement = $root;
        $root->prevElement = $el;

        $this->cursor = $root;
    }

    /**
     * Go to the next element and returns it.
     *
     * @return CircularListElement|null Next element
     *
     * @api
     */
    public function next()
    {
        $this->cursor = $this->cursor->getNext();
        return $this->cursor;
    }


    /**
     * Go to the previous element and returns it.
     *
     * @return CircularListElement|null Previous element
     *
     * @api
     */
    public function prev()
    {
        $this->cursor = $this->cursor->getPrev();
        return $this->cursor;
    }

    /**
     * Returns element pointed by cursor.
     *
     * @return CircularListElement|null Element pointed by cursor
     *
     * @api
     */
    public function cursor()
    {
        return $this->cursor;
    }

    /**
     * Moves n % CircularList::length elements backward (n < 0) or forward
     * (n >= 0) in the circular list and returns that element.
     *
     * @param int $n Number of movement
     *
     * @return CircularListElement Element
     *
     * @api
     */
    public function move($n)
    {
        if ($n < 0) {
            for (; $n < 0; $n++) {
                $this->prev();
            }
        } else if ($n > 0) {
            for (; $n > 0; $n--) {
                $this->next();
            }
        }

        return $this->cursor;
    }

    /**
     * Returns the number of elements in circular list.
     *
     * This executes in time proportional to the number of elements.
     *
     * @return int Number of elements in circular list
     *
     * @api
     */
    public function len()
    {
        $len = 0;

        if ($this->cursor !== null) {
            $len = 1;
            $el = $this->cursor;
            for ($el = $el->getNext(); $el !== $this->cursor; $el = $el->getNext()) {
                $len++;
            }
        }

        return $len;
    }

    /**
     * Connects circular list cursor element with other element such that
     * $this->next() becomes $other and returns the original value for $this->next().
     *
     * If $this->cursor() and $other are in the same circular list, linking them
     * removes the elements between $this->cursor() and $other. The return value
     * is the element $this->cursor()->getNext().
     *
     * If $this->cursor() and $other are not in the same ciruclar list, linking
     * them is the same as inserting $other and its list elements to current
     * circular list. The return value is the last element following the last
     * element of of $other's list after insertion.
     *
     * @param CircularListElement|CircularList $other Other element
     *
     * @return CircularListElement Returned element after linking
     *
     * @api
     */
    public function link($other)
    {
        $n = $this->cursor()->getNext();

        if (is_a($other, 'Gedex\Container\CircularList')) {
            $other = $other->cursor();
        }

        if (is_a($other, 'Gedex\Container\CircularListElement')) {
            $p = $other->getPrev();

            $this->cursor()->nextElement = $other;
            $other->prevElement = $this->cursor();

            $n->prevElement = $p;
            $p->nextElement = $n;
        }

        return $n;
    }

    /**
     * Removes n % $this->len() elements from the circular list, starting at
     * $this->cursor()->next(). If n % $this->len() == 0, circular list remains
     * unchanged. The return value is the removed sub circular list.
     *
     * @param int $n Number of elements
     *
     * @return CircularListElement|null Returned element after unlinking
     *
     * @api
     */
    public function unlink($n)
    {
        if ($n <= 0) {
            return null;
        }

        $startCursor = $this->cursor;
        $moveCursor = $this->move($n + 1);
        $this->cursor = $startCursor;

        return $this->link($moveCursor);
    }

    /**
     * Calls callback on each element of the circular list, in forward order.
     *
     * @param mixed $callback Callback function to run for each element
     *
     * @api
     */
    public function walk($callback)
    {
        if ($this->cursor !== null && is_callable($callback)) {
            $el = $this->cursor;
            call_user_func($callback, $el->getValue());
            for ($el = $el->getNext(); $el !== $this->cursor; $el = $el->getNext()) {
                call_user_func($callback, $el->getValue());
            }
        }
    }
}
