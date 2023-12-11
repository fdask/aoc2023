#!/usr/bin/php
<?php
// image includes
// . empty space
// # galaxies

// get the sum of the lengths of the shortest path between every pair of galaxies
// any row or columns that contain NO glaxies should be twice as big


// expand space

// number the galaxies 

// break the galaxies down into pairs

// paths can only go up, down, left, right
// paths CAN pass through other galaxies

$lines = file("input11-sample.txt");

$map = array();

for ($x = 0; $x < count($lines); $x++) {
	$map[$x] = str_split(trim($lines[$x]));
}

print_r($map);
//printArray($map);

$expandRows = array();
$expandCols = array();

// now that we have a map, lets look for unoccupied columns or rows
for ($x = 0; $x < count($map); $x++) {
	$foundGalaxy = false;

	for ($y = 0; $y < count($map[0]); $y++) {
		if ($map[$x][$y] == "#") {
			$foundGalaxy = true;
		}
	}

	if (!$foundGalaxy) {
		$expandRows[] = $x;
	}
}

for ($y = 0; $y < count($map[0]); $y++) {
	$foundGalaxy = false;

	for ($x = 0; $x < count($map); $x++) {
		if ($map[$x][$y] == "#") {
			$foundGalaxy = true;
		}	
	}

	if (!$foundGalaxy) {
		$expandCols[] = $y;
	}
}

// now we have a list of all the expandable rows and cols, lets modify the map
echo "Expand Rows:\n";
print_r($expandRows);

foreach ($expandRows as $expandRow) {
	$map = addRow($expandRow, $map);
}

echo "Expand Cols:\n";
print_r($expandCols);

// now lets add the columns
foreach ($expandCols as $expandCol) {
	$map = addCol($expandCol, $map);
}

printArray($map);

// now we have the expanded map.
// find all the galaxies
$galaxies = array();

for ($x = 0; $x < count($map); $x++) {
	for ($y = 0; $y < count($map[0]); $y++) {
		if ($map[$x][$y] == "#") {
			$galaxies[] = array($x, $y);
		}
	}
}

print_r($galaxies);

// now lets pair them up
$pairCount = 0;

$donePairs = array();

for ($x = 0; $x < count($galaxies); $x++) {
	for ($x2 = 0; $x2 < count($galaxies); $x2++) {
		if ($x == $x2) {
			continue;
		}

		if (!donePair($galaxies[$x][0], $galaxies[$x][1], $galaxies[$x2][0], $galaxies[$x2][1], $donePairs)) {
			echo "(" . $galaxies[$x][0] . ", " . $galaxies[$x][1] . ") to (" . $galaxies[$x2][0] . ", " . $galaxies[$x2][1] . ")\n";
			
			$donePairs[] = array(
				array($galaxies[$x][0], $galaxies[$x][1]),
				array($galaxies[$x2][0], $galaxies[$x2][1])
			);

			$pairCount++;
		}
	}
}

echo "We have a total of $pairCount pairs\n";

//** simple function to handle seeing if we've already done the pair
function donePair($x1, $y1, $x2, $y2, $donePairs) {
	echo "Looking for ($x1, $y1) to ($x2, $y2) OR ($x2, $y2) to ($x1, $y1)\n";

	foreach ($donePairs as $donePair) {
		echo "Does this pair match?\n";
		print_r($donePair);

		if (
			($donePair[0][0] == $x1 && $donePair[0][1] == $y1) &&
			($donePair[1][0] == $x2 && $donePair[1][1] == $y2)
		) {
			echo "YES!\n";
			return true;
		}

		if (
			($donePair[1][0] == $x1 && $donePair[1][1] == $y1) &&
			($donePair[0][0] == $x2 && $donePair[0][1] == $y2)
		) {
			echo "YES!\n";
			return true;
		} 

	}

	echo "NO!\n";

	return false;
}

/**
* print out a multidimensional array in a grid
**/
function printArray($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			echo $map[$x][$y];
		}

		echo "\n";
	}

	echo "\n";
}

function addCol($colNum, $map) {
	$newMap = array();

	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[0]); $y++) {
			if ($y == $colNum) {
				$newMap[$x][] = ".";
			}

			$newMap[$x][] = $map[$x][$y];
		}
	}

	return $newMap;
}

function addRow($rowNum, $map) {
	$newMap = array();

	for ($x = 0; $x < count($map); $x++) {
		if ($x == $rowNum) {
			$newMap[] = str_split(str_repeat(".", count($map[0])));
		}

		$newMap[] = $map[$x];
	}

	return $newMap;
}
