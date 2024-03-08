<?php

function combinationSum($candidates, $target)
{
    $result = [];
    findCombinations($candidates, $target, 0, [], $result);
    return $result;
}

function findCombinations($candidates, $target, $start, $current, &$result)
{
    if ($target == 0) {
        $result[] = $current;
        return;
    }

    for ($i = $start; $i < count($candidates); $i++) {
        if ($candidates[$i] > $target) {
            continue;
        }
        $current[] = $candidates[$i];
        findCombinations($candidates, $target - $candidates[$i], $i, $current, $result);
        array_pop($current);
    }
}

// Example 1
$array = [2, 3, 6, 7];
$target = 7;
echo "Example 1:\n";
print_r(combinationSum($array, $target));

// Example 2
$array = [2, 3, 5];
$target = 8;
echo "Example 2:\n";
print_r(combinationSum($array, $target));

// Example 3
$array = [2];
$target = 1;
echo "Example 3:\n";
print_r(combinationSum($array, $target));
