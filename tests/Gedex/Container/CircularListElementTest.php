<?php

namespace Gedex\Container;

class CircularListElementTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->ring = new CircularList(3);

        $this->el1 = $this->ring->cursor();
        $this->el2 = $this->ring->next();
        $this->el3 = $this->ring->next();
    }

    public function testConstruct()
    {
        $el = new CircularListElement();
        $this->assertNull($el->getValue());
        $this->assertEquals($el, $el->getNext());
        $this->assertEquals($el, $el->getPrev());
    }

    public function testNext()
    {
        $this->assertEquals($this->el2, $this->el1->getNext());
        $this->assertEquals($this->el3, $this->el2->getNext());
        $this->assertEquals($this->el1, $this->el3->getNext());
    }

    public function testPrev()
    {
        $this->assertEquals($this->el3, $this->el1->getPrev());
        $this->assertEquals($this->el1, $this->el2->getPrev());
        $this->assertEquals($this->el2, $this->el3->getPrev());
    }
}
