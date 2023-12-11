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
