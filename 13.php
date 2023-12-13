#!/usr/bin/php
<?php
// ash .
// rocks #
// 1915 is too low.

// the answer is 37113
$lines = file("input13.txt");

$maps = array();
$map = array();

foreach ($lines as $line) {
	if (trim($line) == "") {
		$maps[] = $map;
		$map = array();
	} else {
		$map[] = trim($line);
	}
}

$maps[] = $map;

//print_r($maps);

$sum = 0;

foreach ($maps as $map) {
	printArray($map);

	$found = false;

	// find a reflection either horizontally
	for ($x = 0; $x < count($map) - 1; $x++) {
		if (trim($map[$x]) == trim($map[$x + 1])) {
			//echo "Potentially found a mirror horizontally between $x and " . ($x + 1) . "\n";

			// we need to make sure it's a perfect mirror
			if (isMirroredHorizontally($x, $map)) {
				echo "Mirrored horizontally at $x - " . ($x + 1) . "\n";
				$found = true;
				$sum += 100 * ($x + 1);

				break;
			}
		}	
	}

	// or vertically
	if (!$found) {
		$map = shiftMapVertically($map);

		echo "Shifting 90d\n";
		printArray($map);

		// find a reflection either horizontally
		for ($x = 0; $x < count($map) - 1; $x++) {
			if (trim($map[$x]) == trim($map[$x + 1])) {
				echo "Potentially found a mirror vertically between $x and " . ($x + 1) . "\n";

				// we need to make sure it's a perfect mirror
				if (isMirroredHorizontally($x, $map)) {
					echo "Mirrored vertically at $x - " . ($x + 1) . "\n";
					$found = true;
					$sum += ($x + 1);

					break;
				}
			}	
		}
	}

	if (!$found) {
		echo "Couldn't find the mirror in this map!\n";
		exit;
	}
}

echo "We have a total of $sum!\n";

// ignore odd columns/rows out

// add up the number of columns to the left of each vertical line of reflection
// also add 100 * the number of rows above each horizontal line of reflection

function rotateCW($arr){
    return array_map(function($row, $i) use ($arr){
        return array_reverse(array_column($arr, $i));
    }, $arr[0], array_keys($arr[0]));
}

function shiftMapVertically($map) {
	//echo "Shifting the map 90 degrees\n";
/*
		x1	x2	x3     z1 y1 x1
		y1 y2 y3  => z2 y2 x2
		z1 z2 z3     z3 y3 x3

*/
	$ret = array();
	$bitmap = array();

	// convert to a true 2d array
	foreach ($map as $line) {
		$bits = str_split(trim($line));
		$bitmap[] = $bits;
	}

	//print_r($bitmap);
	//printMap($bitmap);

	$r = rotateCW($bitmap);

	// now lets put it back into lines of text
	foreach ($r as $line) {
		$ret[] = implode("", $line);
	}

	return $ret;
}

function printArray($map) {
	for ($x = 0; $x < count($map); $x++) {
		echo $map[$x] . "\n";
	}
	
	echo "\n";
}

function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			if (isset($map[$x][$y])) {
				echo $map[$x][$y];
			}
		}

		echo "\n";
	}

	echo "\n";
}

function isMirroredHorizontally($upTo, $map) {
	$y = $upTo + 1;

	for ($x = $upTo; $x >= 0; $x--) {
		if (!isset($map[$y])) {
			continue;
		}

		echo "Line x $x, Line y $y\n";

		if (trim($map[$x]) != trim($map[$y])) {
			echo "Line $x doesn't match line $y\n";

			return false;
		}
		
		$y++;
	}

	echo "We have a confirmed mirror.\n";
	return true;
}
