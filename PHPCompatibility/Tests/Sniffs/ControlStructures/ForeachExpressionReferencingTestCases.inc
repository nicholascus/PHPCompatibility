<?php

/*
 * OK prior to PHP 5.5.
 */
foreach ($array as &$value) {}
foreach ($array as $key => $value) {}
foreach ($array as $key => &$value) {}

/*
 * PHP 5.5: referencing expressions in foreach.
 */
foreach (array(1, 2, 3, 4) as &$value) {}
foreach ([1, 2, 3, 4] as &$value) {}

foreach (array('a' => 1, 'b' => 2) as $key => &$value) {}
foreach (['a' => 1, 'b' => 2] as $key => &$value) {}

foreach (array_combine($array,$array) as &$value) {}
foreach (($array + [5]) as &$value) {}
