<?php

namespace Gedex\Container;

class DoublyLinkedListTest extends \PHPUnit_Framework_TestCase {
    public function testConstruct()
    {
        $l = new DoublyLinkedList();
        $this->assertTrue($l->root instanceof DoublyLinkedListElement);
        $this->assertEquals(0, $l->len());

        // Empty list have root's prev and root's next points to root.
        $this->assertEquals($l->root, $l->root->prevElement);
        $this->assertEquals($l->root, $l->root->nextElement);
    }

    public function testLen()
    {
        $l = new DoublyLinkedList();
        $this->assertEquals(0, $l->len());

        // pushFront and pushBack will increases list's length.
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $e3 = $l->pushBack(3);
        $e4 = $l->pushBack('four');
        $this->assertEquals(4, $l->len());

        // remove will decreases list's length.
        $l->remove($e1);
        $this->assertEquals(3, $l->len());
        // remove inexistsent element won't decrease list's length.
        $l->remove($e1);
        $this->assertEquals(3, $l->len());

        $l->remove($e2);
        $l->remove($e3);
        $l->remove($e4);
        $this->assertEquals(0, $l->len());

    }

    public function testFront()
    {
        // Empty list's front is null.
        $l = new DoublyLinkedList();
        $this->assertNull($l->getFront());

        // pushFront returns new element at the front of list. When list is empty,
        // new element from pushFront has prev and next points to list's root.
        $firstEl = $l->pushFront('first element');
        $this->assertEquals($firstEl, $l->getFront());
        $this->assertEquals($l->root, $firstEl->prevElement);
        $this->assertEquals($l->root, $firstEl->nextElement);

        // pushFront returns new element at the front of list. When list is not
        // empty, new element from pushFront has prev points to list's root and
        // next points to the previous front element.
        $secondEl = $l->pushFront('second element');
        $this->assertEquals($secondEl, $l->getFront());
        $this->assertEquals($l->root, $secondEl->prevElement);
        $this->assertEquals($firstEl, $secondEl->nextElement);
    }

    public function testBack()
    {
        // Empty list's back is null.
        $l = new DoublyLinkedList();
        $this->assertNull($l->getBack());

        // pushBack returns new element at the back of list. When list is empty,
        // new element from pushBack has prev and next points to list's root.
        $firstEl = $l->pushBack('first element');
        $this->assertEquals($firstEl, $l->getBack());
        $this->assertEquals($l->root, $firstEl->prevElement);
        $this->assertEquals($l->root, $firstEl->nextElement);

        // pushBack returns new element at the back of list. When list is not 
        // empty, new element from pushBack has prev points to the previous back
        // element and next points to list's root.
        $secondEl = $l->pushBack('second element');
        $this->assertEquals($secondEl, $l->getBack());
        $this->assertEquals($firstEl, $secondEl->prevElement);
        $this->assertEquals($l->root, $secondEl->nextElement);
    }

    public function testRemove()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $e3 = $l->pushBack(3);
        $e4 = $l->pushBack(4);

        $this->assertEquals($l, $e1->listContainer);

        // remove will unlink reference to listContainer, prev element, and next
        // element. It also decreases list's length.
        $l->remove($e1); 
        $this->assertEquals(null, $e1->listContainer);
        $this->assertEquals(null, $e1->nextElement);
        $this->assertEquals(null, $e1->prevElement);
        $this->assertEquals(3, $l->len());

        // After remove, prev and next elements of existing elements should be
        // revised.
        $this->assertEquals($e2, $l->getFront());
        $this->assertEquals(null, $e2->getPrev());
        $this->assertEquals($l->root, $e2->prevElement);

        // remove will unlink reference to listContainer, prev element, and next
        // element. It also decreases list's length.
        $l->remove($e4);
        $this->assertEquals(null, $e4->listContainer);
        $this->assertEquals(null, $e4->nextElement);
        $this->assertEquals(null, $e4->prevElement);
        $this->assertEquals(2, $l->len());

        // After remove, prev and next elements of existing elements should be
        // revised.
        $this->assertEquals($e3, $l->getBack());
        $this->assertEquals($e2, $e3->getPrev());
    }

    public function testInsertBefore()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront('e1');
        $e2 = $l->insertBefore('e2', $e1);

        $this->assertEquals($e2, $e1->getPrev());
        $this->assertEquals($e1, $e2->getNext());

        // insertBefore element from different list will returns null and won't
        // alter existing list elements.
        $e3 = new DoublyLinkedListElement();
        $e4 = $l->insertBefore('e4', $e3);
        $this->assertNull($e4);
    }

    public function testInsertAfter()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront('e1');
        $e2 = $l->insertAfter('e2', $e1);

        $this->assertEquals($e2, $e1->getNext());
        $this->assertEquals($e1, $e2->getPrev());

        // insertAfter element from different list will returns null and won't
        // alter existing list elements.
        $e3 = new DoublyLinkedListElement();
        $e4 = $l->insertAfter('e4', $e3);
        $this->assertNull($e4);
    }

    public function testMoveToFront()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $this->assertEquals($e2, $l->getFront());

        $l->moveToFront($e1);
        $this->assertEquals($e1, $l->getFront());
        $this->assertEquals($e1, $e2->getPrev());
        $this->assertEquals($e2, $e1->getNext());
        $this->assertEquals(null, $e1->getPrev());

        // Moves inexistent element won't change existing elements.
        $e3 = new DoublyLinkedListElement();
        $l->moveToFront($e3);
        $this->assertEquals($e1, $l->getFront());
        $this->assertEquals($e2, $l->getBack());
    }

    public function testMoveToBack()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushBack(1);
        $e2 = $l->pushBack(2);
        $this->assertEquals($e2, $l->getBack());

        $l->moveToBack($e1);
        $this->assertEquals($e1, $l->getBack());
        $this->assertEquals($e1, $e2->getNext());
        $this->assertEquals($e2, $e1->getPrev());
        $this->assertEquals(null, $e1->getNext());

        // Moves inexsisetent element won't change existing elements.
        $e3 = new DoublyLinkedListElement();
        $l->moveToBack($e3);
        $this->assertEquals($e1, $l->getBack());
        $this->assertEquals($e2, $l->getFront());
    }

    public function testMoveBefore()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $e3 = $l->pushBack(3);

        $l->moveBefore($e2, $e1);
        $this->assertEquals($e2, $l->getFront());
        $this->assertEquals($e1, $e2->getNext());
        $this->assertNull($e2->getPrev());

        $l->moveBefore($e3, $e1);
        $this->assertEquals($e1, $l->getBack());
        $this->assertEquals($e2, $e3->getPrev());
        $this->assertEquals($e1, $e3->getNext());

        // Moves inexistent element won't change existing elements.
        $e4 = new DoublyLinkedListElement();
        $l->moveBefore($e2, $e4);
        $this->assertNotEquals($e4, $e2->getPrev());
        $this->assertNotEquals($e2, $e4->getNext());
    }

    public function testMoveAfter()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $e3 = $l->pushBack(3);

        $l->moveAfter($e1, $e2);
        $this->assertEquals($e2, $e1->getPrev());
        $this->assertEquals($e1, $e2->getNext());
        $this->assertNull($e2->getPrev());

        $l->moveAfter($e1, $e3);
        $this->assertEquals($e3, $e1->getPrev());
        $this->assertEquals($e1, $e3->getNext());
        $this->assertEquals($e2, $e3->getPrev());
        $this->assertNull($e1->getNext());

        // Moves inexistent element won't change existing elements.
        $e4 = new DoublyLinkedListElement();
        $l->moveAfter($e4, $e1);
        $this->assertNotEquals($e4, $e1->getNext());
        $this->assertNotEquals($e2, $e4->getPrev());
    } 

    public function testPushBackList()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushFront(2);
        $e3 = $l->pushBack(3);

        $other = new DoublyLinkedList();
        $e4 = $other->pushBack(4);
        $e5 = $other->pushBack(5);

        $l->pushBackList($other);
        $this->assertEquals(5, $l->len());
        $this->assertNotEquals($e5, $l->getBack());
        $this->assertEquals(5, $l->getBack()->getValue());
        $this->assertEquals(4, $l->getBack()->getPrev()->getValue());
        $this->assertEquals($e3, $l->getBack()->getPrev()->getPrev());

        // pushBackList the same list will double its elements.
        $other->pushBackList($other);
        $this->assertEquals(4, $other->len());
        $this->assertEquals(5, $other->getBack()->getValue());
        $this->assertEquals(4, $other->getBack()->getPrev()->getValue());
        $this->assertEquals(5, $other->getBack()->getPrev()->getPrev()->getValue());

        // pushBackList empty list won't alter the list.
        $emptyList = new DoublyLinkedList();
        $other->pushBackList($emptyList);
        $this->assertEquals(4, $other->len());
    }

    public function testPushFrontList()
    {
        $l = new DoublyLinkedList();
        $e1 = $l->pushFront(1);
        $e2 = $l->pushBack(2);
        $e3 = $l->pushBack(3);

        $other = new DoublyLinkedList();
        $e4 = $other->pushBack(4);
        $e5 = $other->pushBack(5);

        $l->pushFrontList($other);
        $this->assertEquals(5, $l->len());
        $this->assertEquals(4, $l->getFront()->getValue());
        $this->assertEquals(5, $l->getFront()->getNext()->getValue());
        $this->assertEquals($e1, $l->getFront()->getNext()->getnext());

        // pushFrontList the same list will double its elements.
        $other->pushFrontList($other);
        $this->assertEquals(4, $other->len());
        $this->assertEquals(4, $other->getFront()->getValue());
        $this->assertEquals(5, $other->getFront()->getNext()->getValue());
        $this->assertEquals(4, $other->getFront()->getNext()->getNext()->getValue());

        // pushFrontList empty list won't alter the list.
        $emptyList = new DoublyLinkedList();
        $other->pushFrontList($emptyList);
        $this->assertEquals(4, $other->len());
    }
}
