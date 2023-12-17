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

$heatloss = 0;
$posX = 0;
$posY = 0;
$cantGo = null;

do {
	$heat = array();

	echo "Xpos: $posX Ypos: $posY\n";
	printMap($map);

	// until we get to the end, keep looping
	if ($posX > 0 && $cantGo != "n") {
		// get the heat value above us to the north
		$heat['n'] = $map[$posX - 1][$posY];
	}

	if ($posX < (count($map) - 1) && $cantGo != "s") {
		$heat['s'] = $map[$posX + 1][$posY];
	}

	if ($posY > 0 && $cantGo != "w") {
		$heat['w'] = $map[$posX][$posY - 1];
	}

	if ($posY < (count($map[0]) - 1) && $cantGo != "e") {
		$heat['e'] = $map[$posX][$posY + 1];
	}

	// now find the lowest direction from the heat array
	print_r($heat);
	exit;
} while (($posX != (count($map) - 1)) && ($posY != (count($map[0] - 1))));

function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			echo $map[$x][$y];
		}

		echo "\n";
	}

	echo "\n";
}
