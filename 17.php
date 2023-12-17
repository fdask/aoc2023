#!/usr/bin/php
<?php

// day 17: clumsy crucible

// find the best way to get the crucible from the lava pool, to machine parts factory
// minimize heat loss while choosing a route that doesn't require the crucible to go in a straight line
// for too long

// given a map by elves

$lines = file("input17-sample.txt");

// each digit represents the amunt of heat loss if the crucible enters that block

// start at the top left (don't count this blocks heat loss)
// finish at the bottom right

// move at most three blocks in a single direction 
// before having to turn 90 degrees left or right

// can't reverse direction.  only left, forward, right

// find the path with the least heat loss.

$map = array();

foreach ($lines as $line) {
	$map[] = str_split(trim($line));
}

$destX = count($map) - 1;
$destY = count($map[0]) - 1;

$moveMap = $map;

$heatloss = 0;
$posX = 0;
$posY = 0;
$northCount = 0;
$southCount = 0;
$westCount = 0;
$eastCount = 0;
$cantGo = null;

do {
	$heat = array();

	echo "Xpos: $posX Ypos: $posY\n";

	// until we get to the end, keep looping
	if ($posX > 0 && $northCount <= 3 && $cantGo != "n" && isValidMove($moveMap, $posX - 1, $posY)) {
		// get the heat value above us to the north
		$heat['n'] = $map[$posX - 1][$posY];
	} else {
		$heat['n'] = 100;
	}

	if ($posX < (count($map) - 1) && $southCount <= 3 && $cantGo != "s" && isValidMove($moveMap, $posX + 1, $posY)) {
		$heat['s'] = $map[$posX + 1][$posY];
	} else {
		$heat['s'] = 100;
	}

	if ($posY > 0 && $westCount <= 3 && $cantGo != "w" && isValidMove($moveMap, $posX, $posY - 1)) {
		$heat['w'] = $map[$posX][$posY - 1];
	} else {
		$heat['w'] = 100;
	}

	if ($posY < (count($map[0]) - 1) && $eastCount <= 3 && $cantGo != "e" && isValidMove($moveMap, $posX, $posY + 1)) {
		$heat['e'] = $map[$posX][$posY + 1];
	} else {
		$heat['e'] = 100;
	}

	// if the heat array is all 100's, we're at a dead end and should exit
	$acv = array_count_values($heat);

	if ($acv['100'] == 4) {
		print_r($acv);
		echo "Dead end!!\n\n";
		exit;
	}
	// now find the lowest direction from the heat array
	asort($heat);
	
	// move
	$move = array_keys($heat)[0];
	$moveheat = array_values($heat)[0];
	$heatloss += $moveheat;

	switch ($move) {
		case 'n':
			$northCount++;
			$southCount = 0;
			$eastCount = 0;
			$westCount = 0;
			$cantGo = "s";
			$moveMap[$posX][$posY] = "^";
			$posX = $posX - 1;

			break;
		case 'e':
			$eastCount++;
			$northCount = 0;
			$westCount = 0;
			$southCount = 0;
			$cantGo = "w";
			$moveMap[$posX][$posY] = ">";
			$posY = $posY + 1;

			break;
		case 's':
			$southCount++;
			$northCount = 0;
			$eastCount = 0;
			$westCount = 0;
			$cantGo = "n";
			$moveMap[$posX][$posY] = "V";
			$posX = $posX + 1;

			break;
		case 'w':
			$westCount++;
			$northCount = 0;
			$eastCount = 0;
			$southCount = 0;
			$cantGo = "e";
			$moveMap[$posX][$posY] = "<";
			$posY = $posY - 1;

			break;
	}

	echo "Moving to the $move, incurring $moveheat heatloss\n\n";

	printMap($moveMap);
	//printMap($map);
	//exit;
} while ($posX != $destX && $posY != $destY);

function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			echo $map[$x][$y];
		}

		echo "\n";
	}

	echo "\n";
}

function isValidMove($moveMap, $x, $y) {
	if (preg_match("@[0-9]@", $moveMap[$x][$y])) {
		return true;
	}

	return false;
}
