<?php

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

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
