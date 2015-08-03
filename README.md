Container
=========

Library for various data structure and its operations.

## Examples

### Doubly Linked List

~~~php
use Gedex\Container;

$ll = new Container\DoublyLinkedList();
$e1 = $ll->pushFront(1);
$e2 = $ll->pushFront(2);
$e3 = $ll->pushBack('e3');

$e4 = $ll->insertBefore('el before e3', $e3);
$e5 = $ll->insertAfter('el after e3', $e3);
printList($ll); // --> (2) --> (1) --> (el before e3) --> (e3) --> (el after e4)

printf("Remove element (%s)\n", $e3->getValue());
$ll->remove($e3);

printList($ll); // --> (2) --> (1) --> (el before e3) --> (el after e4)

function printList($ll) {
    $el = $ll->getFront();
    while (!is_null($el)) {
        printf('--> (%s) ', $el->getValue());
        $el = $el->getNext();
    }
    printf("\n");
}
~~~

### Circular List

~~~php
use Gedex\Container;

$cl = new Container\CircularList(5);
for ($i = 1; $i <= $cl->len(); $i++) {
    $el = $cl->cursor()->setValue($i);
    $cl->next();
}

$sum = 0;
$cl->walk(function($value) use(&$sum) {
    printf('--> (%s) ', $value);
    $sum += $value;
});
printf("\n");
printf("%d\n", $sum); // 15
~~~

## License

MIT License - See [LICENSE file](LICENSE).
