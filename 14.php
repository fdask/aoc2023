#!/usr/bin/php
<?php
// we have a platform that can be tilted in any of the four cardinal directions
// rounded rocks O will roll when titled
// cube shape rocks stay in place #
// empty space is .

// the amount of load caused by a single rounded rock O, 
// is equal to the numbers of rows from the rock to the south edge of the platform
// including the row the rock is on

// cube shaped rocks down count towards the load

// sample data answer is 136

$lines = file("input14-sample.txt");
$map = array();
$total_load = 0;

foreach ($lines as $line) {
	$bits = str_split(trim($line));
	$map[] = $bits;
}

echo "Map is " . count($map) . " high, " . count($map[0]) . " wide\n";

printMap($map);

// move the rocks
// the first row of rocks already can't go north any farther
for ($x = 1; $x < count($map); $x++) {
	for ($y = 0; $y < count($map[0]); $y++) {
		if ($map[$x][$y] == "O") {
			echo "Found a rock at $x, $y\n";
			// we found a round rock, lets see if we can move it up
			for ($newX = $x - 1; $newX > 0; $newX--) {
				echo "Looking above it at $newX, $y\n";

				if ($map[$newX][$y] != ".") {
					//echo "Non empty char.\n";
					break;
				} else {
					//echo "We can move it!\n";
				}
			}

			// actually move it
			if ($map[$newX][$y] == ".") {
				echo "Got a new position of ($newX, $y)\n";
				$map[$x][$y] = ".";
				$map[$newX][$y] = "O";

				printMap($map);
			}
		}
	}
}

printMap($map);
// sum the load on the rocks in their moved up positions


// print out the map
function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			echo $map[$x][$y];
		}

		echo "\n";
	}

	echo "\n";
}

