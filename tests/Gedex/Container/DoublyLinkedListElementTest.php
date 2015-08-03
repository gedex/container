<?php

namespace Gedex\Container;

class DoublyLinkedListElementTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->listContainer = new DoublyLinkedList();

        $this->el = new DoublyLinkedListElement();
        $this->el->listContainer = $this->listContainer;

        $this->nextEl = new DoublyLinkedListElement();
        $this->nextEl->listContainer = $this->listContainer;

        $this->prevEl = new DoublyLinkedListElement();
        $this->prevEl->listContainer = $this->listContainer;
    }

    public function testConstruct()
    {
        $el = new DoublyLinkedListElement();
        $this->assertNull($el->getValue());
        $this->assertNull($el->getNext());
        $this->assertNull($el->getPrev());

        $el = new DoublyLinkedListElement(10);
        $this->assertEquals(10, $el->getValue());
    }

    public function testNext()
    {
        $this->el->nextElement = $this->nextEl;
        $this->assertEquals($this->nextEl, $this->el->getNext());
    }

    public function testPrev()
    {
        $this->el->prevElement = $this->prevEl;
        $this->assertEquals($this->prevEl, $this->el->getPrev());
    }
}
