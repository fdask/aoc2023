#!/usr/bin/php
<?php

// find the tile in the loop that is farthest from the starting position
$lines = file("input10-sample.txt");

// load the maze into an array
$map = array();

for ($x = 0; $x < count($lines); $x++) {
	$map[$x] = str_split(trim($lines[$x]));	
}

print_r($map);

// now lets find the S character
$startPos = findStart($map, "S");

print_r($startPos);

// now lets get the coordinates in four cardinal directions from the start.
function getCardinalRelations($map, $x, $y) {
	$above = $map[$x - 1][$y];
	$below = $map[$x + 1][$y];
	$left = $map[$x][$y - 1];
	$right = $map[$x][$y + 1];

	// can we go up?
}

function canWeGoUp($map, $x, $y) {
	/// north
	// make sure x > 0
	if ($x <= 0) {
		return false;
	}

	// is the character above valid?   |, 7, F
	if (in_array($map[$x - 1][$y], array("|", "7", "F"))) {
		// character is valid and we can make the move
		return true;
	}

	return false;
}

function canWeGoLeft($map, $x, $y) {
	// west
	if ($y <= 0) {
		return false;
	}

	// is the character valid?
	if (in_array($map[$x][$y - 1], array("-", "L", "F"))) {
		return true;
	}

	return false;
}

function canWeGoRight($map, $x, $y) {
	// east
	if ($y >= count($map[0])) {
		return false;
	}

	// is the character valid?
	if (in_array($map[$x][$y - 1], array("-", "J", "7"))) {
		return true;
	}

	return false;
}

function canWeGoDown($map, $x, $y) {
	if ($x >= count($map)) {
		return false;
	}

	// is the character valid?
	if (in_array($map[$x][$y - 1], array("|", "L", "J"))) {
		return true;
	}

	return false;
}

function nextStep($map, $oldX, $oldY, $curX, $curY) {
	// a pipe only has two directions to go
	// we want the one thats not oldX, oldY
	$curPipe = $map[$curX][$curY];

	switch ($curPipe) {
		case '7':
			// oldx is either a move left (x, y - 1), or a move down (x + 1, y)
			if ($oldX == $curX && $oldY == ($curY - 1)) {
				// we came from left, so go down
				return array($curX + 1, $curY);
			} else {
				// we came from down, so go left
				return array($curX, $curY - 1);
			}

			break;
		case 'F':
			// we're either moving down (x + 1, y), or right (x, y + 1)
			if ($oldX == $curX + 1 && $oldY = $curY) {
				// we came from down, so go right
				return array($curX, $curY + 1);
			} else {
				// came from right, so go down
				return array($curX + 1, $curY);
			}

			break;
		case '|':
			// either moving up (x - 1, y) or down (x + 1, y)
			if ($oldX == $curX - 1 && $oldY = $curY) {
				// we came from up, so go down
				return array($curX + 1, $curY);
			} else {
				// came from down, so go up
				return array($curX - 1, $curY);
			}

			break;
		case '-':
			// either moving left (x, y - 1), or right (x, y + 1)
			if ($oldX == $curX && $oldY == $curY - 1) {
				// we came from left, so go right
				return array($curX, $curY + 1);
			} else {
				// we came from right, so go left
				return array($curX, $curY - 1);
			}

			break;
		case 'J':
			// either moving left (x, y - 1), or up (x - 1, y)
			if ($oldX == $curX && $oldY == $curY - 1) {
				//w e came from left, go right
				return array($curX - 1, $curY);
			} else {
				// we came from right, go left
				return array($curX, $curY - 1);
			}

			break;
		case 'L':
			// either moving right (x, y + 1), or up (x - 1, y)
			if ($oldX == $curX && $oldY == $curY + 1) {
				// we came from right, go up
				return array($curX - 1, $curY);	
			} else {
				// we came from up, go right
				return array($curX, $curY + 1);
			}

			break;
		default:
			// shouldn't get here
	}

	echo "Error shouldn't have gotten here\n";
}

function findStart($map, $char) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map[$x]); $y++) {
			if ($map[$x][$y] == $char) {
				return array($x, $y);
			}
		}
	}

	return false;
}
