#!/usr/bin/php
<?php
// ash .
// rocks #

// 28427 is too low.
// 34127 is too high.

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

$firstMatch = "";

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
				$firstMatch = "H$x";

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

					$firstMatch = "V$x";

					break;
				}
			}	
		}
	}

	if (!$found) {
		echo "Couldn't find the mirror in this map!\n";
		exit;
	}

	// now we have our firstmatch, and the details of it are in $firstMatch
	// lets go through again, looking for a line thats 1 off a match
	$found = false;

	// find a reflection either horizontally
	for ($x = 0; $x < count($map) - 1; $x++) {
		if (trim($map[$x]) == trim($map[$x + 1])) {
			//echo "Potentially found a mirror horizontally between $x and " . ($x + 1) . "\n";

			if ($firstMatch == "H$x") {
				continue;
			}

			// we need to make sure it's a one away mirror
			if (isMirroredHorizontallyAlmost($x, $map)) {
				echo "Mirrored horizontally almost at $x - " . ($x + 1) . "\n";
				$found = true;
				$sum += 100 * ($x + 1);

				break;
			}
		}	
	}

	// or vertically
	if (!$found) {
		$map = shiftMapVertically($map);

		//echo "Shifting 90d\n";
		//printArray($map);

		// find a reflection either horizontally
		for ($x = 0; $x < count($map) - 1; $x++) {
			if (trim($map[$x]) == trim($map[$x + 1])) {
				//echo "Potentially found a mirror vertically between $x and " . ($x + 1) . "\n";

				if ($firstMatch == "V$x") {
					continue;
				}

				// we need to make sure it's a perfect mirror
				if (isMirroredHorizontallyAlmost($x, $map)) {
					echo "Mirrored vertically almost at $x - " . ($x + 1) . "\n";
					$found = true;

					$sum += $x + 1;

					break;
				}
			}	
		}
	}

}

echo "We have a total of $sum!\n";

// ignore odd columns/rows out

// add up the number of columns to the left of each vertical line of reflection
// also add 100 * the number of rows above each horizontal line of reflection

// how many characters are different in these two strings (same length)
function offBy($str1, $str2) {
	$diffs = 0;

	for ($x = 0; $x < strlen($str1); $x++) {
		if (substr($str1, $x, 1) != substr($str2, $x, 1)) {
			$diffs++;
		}
	}	

	return $diffs;
}

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

function isMirroredHorizontallyAlmost($upTo, $map) {
	$haveOne = false; // whether we've already encountered the off by one line	

	$y = $upTo + 1;

	for ($x = $upTo; $x >= 0; $x--) {
		// lets loop the lines, looking for all 0's except for 1 x offby1
		if (!isset($map[$y])) {
			continue;
		}

		$offBy = offBy($map[$x], $map[$y]);

		if ($offBy > 1) {
			// this isn't it
			echo "We have an offby > 1, not it\n";

			return false;
		} else if ($offBy == 1) {
			if ($haveOne) {
				echo "We have more than 1 offby, not it\n";

				return false;
			}

			$haveOne = true;
		} 

		$y++;
	}

	echo "We found it!\n";

	return true;
}
