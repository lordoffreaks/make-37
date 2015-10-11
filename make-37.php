<?php

ini_set('memory_limit', -1);

$box = [
	1,
	3,
	5,
	7,
];

$slots = 10;

$arrays = [];
for ($i=0; $i < $slots ; $i++) { 
	$arrays[] = $box;
}

// @see http://stackoverflow.com/a/8567199/1762823
function combinations($arrays, $i = 0, Callable $function = NULL) {
    if (!isset($arrays[$i])) {
        return array();
    }
    if ($i == count($arrays) - 1) {
        return $arrays[$i];
    }

    // get combinations from subsequent arrays
    $tmp = combinations($arrays, $i + 1);

    $result = array();

    // concat each array from tmp with each element from $arrays[$i]
    foreach ($arrays[$i] as $v) {
        foreach ($tmp as $t) {
            $result[] = is_array($t) ? 
                array_merge(array($v), $t) :
                array($v, $t);
        }
    }

    if ($function) {
        $result = array_filter($result, $function);
    }

    return $result;
}

$valid = combinations($arrays, 0, function ($array) {
    return array_sum($array) == 37;
});

echo "Valid: " . count($valid) . PHP_EOL;

if ($valid) {
	foreach ($valid as $key => $value) {
		echo implode(',', $value) . PHP_EOL;
	}	
}
