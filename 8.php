#!/usr/bin/php
<?php

// advent of code, day 8.

// follow the directions as long as it takes to get to ZZZ
// 19199 was the answer

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
	if (preg_match("@([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)@", $node, $matches)) {
		$nodes[$matches[1]] = array($matches[2], $matches[3]);
	}
}

//print_r($nodes);

$start = "AAA";
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
} while ($curNode != $stop);

echo "Required $steps steps to get to ZZZ\n";
