#!/usr/bin/php
<?php

// advent of code, day 8.

// follow the directions as long as it takes to get to ZZZ
// starting at EVERY node that ends in A, ending with everyone on a node that ends in z.

$lines = file("input8.txt");

$nodes = array();
$tmp_nodes = array();

for ($x = 0; $x < count($lines); $x++) {
	if ($x == 0) {
		$directions = str_split(trim($lines[$x]));	
	} else if ($x >= 2) {
		$tmp_nodes[] = trim($lines[$x]);
	} else {
		continue;
	}
}

foreach ($tmp_nodes as $node) {
	if (preg_match("@([0-9A-Z]{3}) = \(([0-9A-Z]{3}), ([0-9A-Z]{3})\)@", $node, $matches)) {
		$nodes[$matches[1]] = array($matches[2], $matches[3]);
	}
}

$starts = array();

foreach ($nodes as $node => $path) {
	if (strpos($node, "A", 2) !== false) {
		$starts[$node] = 0;
	}
}

print_r($starts);

/*
$starts = array_keys($starts);
$allZs = false;
$steps = 0;

do {
	for ($x = 0; $x < count($directions); $x++) {
		// for each direction, perform the action on the starts
		$newstarts = array();

		foreach ($starts as $start) {
			$move = $directions[$x];

			if ($move == "L") {
				$newstarts[] = $nodes[$start][0];
			} else if ($move == "R") {
				$newstarts[] = $nodes[$start][1];
			}	
		}
	
		$steps++;

		echo "On step $steps\n";
		$starts = $newstarts;
		$allZs = allZs($newstarts);
	}
} while ($allZs == false);

// pass in an array of numbers, determine if they are all ending in Z
function allZs($arr) {
	foreach ($arr as $node) {
		if (strpos($node, "Z", 2) == false) {
			return false;
		}
	}

	return true;
}

echo "Number of steps to get all onto ending in Z squares?  $steps\n";
*/

// now follow each path
foreach ($starts as $start => $count) {
	$stop = "ZZZ";
	$curNode = $start;
	$steps = 0;

	do {
		foreach ($directions as $move) {
			if ($move == "L") {
				$curNode = $nodes[$curNode][0];
			} else if ($move == "R") {
				$curNode = $nodes[$curNode][1];
			}	

			$steps++;
		}
	} while (strpos($curNode, "Z", 2) === false);

	$starts[$start] = $steps;
}

print_r($starts);
//echo "Required $steps steps to get to ZZZ\n";

// 13663968099527 was the answer.  we had to find the lcm for the numbers output above.
// did that using some python.
/*

from functools import reduce

def gcd(a, b):
    """Return greatest common divisor using Euclid's Algorithm."""
    while b:      
        a, b = b, a % b
    return a

def lcm(a, b):
    """Return lowest common multiple."""
    return a * b // gcd(a, b)

def lcmm(*args):
    """Return lcm of args."""   
    return reduce(lcm, args)
*/
