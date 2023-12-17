#!/usr/bin/php
<?php
// the answer is 113525.

// we have a platform that can be tilted in any of the four cardinal directions
// rounded rocks O will roll when titled
// cube shape rocks stay in place #
// empty space is .

// the amount of load caused by a single rounded rock O, 
// is equal to the numbers of rows from the rock to the south edge of the platform
// including the row the rock is on

// cube shaped rocks down count towards the load

// sample data answer is 136

$lines = file("input14.txt");
$map = array();
$total_load = 0;

foreach ($lines as $line) {
	$bits = str_split(trim($line));
	$map[] = $bits;
}

$height = count($map);
$width = count($map[0]);
echo "Map is $height high, $width wide\n";

printMap($map);

// given a column of data, slide all the rocks to the top

// move the rocks
// the first row of rocks already can't go north any farther
for ($x = 1; $x < $height; $x++) {
	for ($y = 0; $y < $width; $y++) {
		if ($map[$x][$y] == "O") {
			//echo "Found a rock at $x, $y\n";

			$map = MoveRockUp($map, $x, $y);
		}
	}
}

printMap($map);

// sum the load on the rocks in their moved up positions
$loadSum = 0;
$load = 1;

for ($x = count($map) - 1; $x >= 0; $x--) {
	// any rocks found in this row have a load of $load
	echo $load . " ";

	for ($y = 0; $y < count($map[0]); $y++) {
		echo "($x, $y) ";

		if ($map[$x][$y] == "O") {
			$loadSum += $load;
		}
	}
	
	echo "\n";

	$load++;
}

echo "Our total load is $loadSum\n";

function MoveRockUp($map, $x, $y) {
	//echo "Moving up the rock at $x, $y\n";

	for ($xx = $x - 1; $xx >= 0; $xx--) {
		if ($map[$xx][$y] == ".") {
			//echo "We can move to ($xx, $y)\n";
			$map[$xx + 1][$y] = ".";
			$map[$xx][$y] = "O";
		} else {
			break;
		}
	}
	
	//echo "Ended with an xx of $xx\n";
	return $map;
}

// print out the map
function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			echo $map[$x][$y] . " ";
		}

		echo "\n";
	}

	echo "\n";
}

