<?php

namespace Gedex\Container;

class CircularListTest extends \PHPUnit_Framework_TestCase {
    public function setUp()
    {
        $this->ring = new CircularList(3);

        $this->el1 = $this->ring->cursor();
        $this->el2 = $this->ring->next();
        $this->el3 = $this->ring->next();

        $this->resetSum();
    }

    public function testConstruct()
    {
        // Create one element by default.
        $ring = new CircularList();
        $this->assertEquals(1, $ring->len());

        // One element will have prev and next refer to itself.
        $this->assertEquals($ring->cursor(), $ring->cursor()->getNext());
        $this->assertEquals($ring->cursor(), $ring->cursor()->getPrev());
    }

    public function testMove()
    {
        // No movement.
        $el = $this->ring->move(0);
        $this->assertEquals($el, $this->el1);

        // Moves forward.
        $el2 = $this->ring->move(1);
        $this->assertEquals($el2, $this->el2);
        $el3 = $this->ring->move(2);
        $this->assertEquals($el3, $this->el3);
        $el1 = $this->ring->move(6);
        $this->assertEquals($el1, $this->el1);

        // Moves Backward.
        $el3 = $this->ring->move(-1);
        $this->assertEquals($el3, $this->el3);
        $el2 = $this->ring->move(-2);
        $this->assertEquals($el2, $this->el2);
        $el1 = $this->ring->move(-6);
        $this->assertEquals($el1, $this->el1);
    }

    public function testLen()
    {
        $ring = new CircularList(0);
        $this->assertEquals(0, $ring->len());

        $ring = new CircularList(-1);
        $this->assertEquals(0, $ring->len());

        $this->assertEquals(3, $this->ring->len());
    }

    public function testLink()
    {
        $ringA = $this->makeRing(2);
        $elAfterLink = $ringA->cursor()->getNext();
        $ringB = $this->makeRing(3);

        $retEl = $ringA->link($ringB);
        $this->assertEquals($elAfterLink, $retEl);
        $this->assertEquals(5, $ringA->len());

        $ringA->walk(array($this, 'walkCallback'));
        $this->assertEquals(9, $this->sumOfValues);
        $this->resetSum();

        // This will removes one element.
        $removedEl = $ringA->link($ringA->cursor()->getNext()->getNext());
        $this->assertEquals(4, $ringA->len());
        $this->assertEquals(1, $removedEl->getValue());
        $ringA->walk(array($this, 'walkCallback'));
        $this->assertEquals(8, $this->sumOfValues);
    }


    public function testUnlink()
    {
        $ring = $this->makeRing(10);
        $second = $ring->cursor()->getNext();

        $el = $ring->unlink(0);
        $this->assertNull($el);
        $el = $ring->unlink(-10);
        $this->assertNull($el);

        $el = $ring->unlink(6);
        $this->assertEquals(4, $ring->len());
        $this->assertEquals($second, $el);
    }

    public function testWalk()
    {
        $n = 0;   // Number of elements.
        $sum = 0; // Sum of each element's value.

        $ring = $this->makeRing(0);
        $ring->walk(array($this, 'walkCallback'));
        $this->assertEquals(0, $this->sumOfValues);
        $this->resetSum();

        $ring = $this->makeRing(3);
        $ring->walk(array($this, 'walkCallback'));
        $this->assertEquals(6, $this->sumOfValues);
        $this->resetSum();
    }

    protected function makeRing($n)
    {
        $ring = new CircularList($n);
        for ($i = 1; $i <= $n; $i++) {
            $ring->cursor()->setValue($i);
            $ring->next();
        }

        return $ring;
    }

    public function walkCallback($value)
    {
        $this->sumOfValues += $value;
    }

    protected function resetSum()
    {
        $this->sumOfValues = 0;
    }
}
