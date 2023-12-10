#!/usr/bin/php
<?php

// 6777 is too low
// 6778 was RIGHT!
// find the tile in the loop that is farthest from the starting position
$lines = file("input10.txt");

// load the maze into an array
$map = array();

for ($x = 0; $x < count($lines); $x++) {
	$map[$x] = str_split(trim($lines[$x]));	
}

print_r($map);

// now lets find the S character
$startPos = findStart($map, "S");

echo "Our starting position is {$startPos[0]}, {$startPos[1]}\n";
$steps = array();

// we want to build the path into an array.
// do the same for a second array

if (canWeGoUp($map, $startPos[0], $startPos[1])) {
	// plot our moves
	echo "Can we go up?\n";
	$oldX = $startPos[0];
	$oldY = $startPos[1];
	$curX = $startPos[0] - 1;
	$curY = $startPos[1];
} 

if (canWeGoLeft($map, $startPos[0], $startPos[1])) {
	echo "Can we go left? Yes\n";
	$oldX = $startPos[0];
	$oldY = $startPos[1];
	$curX = $startPos[0];
	$curY = $startPos[1] - 1;
} 

if (canWeGoDown($map, $startPos[0], $startPos[1])) {
	echo "Can we go down?  Yes\n";
	$oldX = $startPos[0];
	$oldY = $startPos[1];
	$curX = $startPos[0] + 1;
	$curY = $startPos[1];
} 

if (canWeGoRight($map, $startPos[0], $startPos[1])) {
	echo "Can we go right? Yes.\n";
	$oldX = $startPos[0];
	$oldY = $startPos[1];
	$curX = $startPos[0];
	$curY = $startPos[1] + 1;
} 

$steps[] = array($curX, $curY); 

do {
	$next = nextStep($map, $oldX, $oldY, $curX, $curY);
	$oldX = $curX;
	$oldY = $curY;
	$curX = $next[0];
	$curY = $next[1];
	$steps[] = $next;

	if ($curX == $startPos[0] && $curY == $startPos[1]) {
		break;
	}
	echo "Startpos: {$startPos[0]},{$startPos[1]} Curpos: $curX,$curY\n";
//var_dump($curX !== $startPos[0] and $curY !== $startPos[1]);
} while (1); //(($curX !== $startPos[0]) && ($curY !== $startPos[1]));

print_r($steps);

echo "The farthest point away is " . ((count($steps) / 2) - 1) . "\n";

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
		echo "Can't go up any more\n";
		return false;
	}

	// is the character above valid?   |, 7, F
	if (in_array($map[$x - 1][$y], array("|", "7", "F"))) {
		// character is valid and we can make the move
		echo "We found a | 7 or F character to the north\n";
		return true;
	}

	echo "no reason\n";
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
		echo "We can't go any further right because y is already at its limit\n";
		return false;
	}

	// is the character valid?
	if (in_array($map[$x][$y + 1], array("-", "J", "7"))) {
		echo "We found a -, J, or 7, allowing us to go right\n";
		return true;
	}

	echo "Just returning false\n";

	return false;
}

function canWeGoDown($map, $x, $y) {
	if ($x >= count($map)) {
		return false;
	}

	// is the character valid?
	if (in_array($map[$x + 1][$y], array("|", "L", "J"))) {
		return true;
	}

	return false;
}

function nextStep($map, $oldX, $oldY, $curX, $curY) {
	// a pipe only has two directions to go
	// we want the one thats not oldX, oldY
	$curPipe = $map[$curX][$curY];

	echo "In nextstep, our current pipe is $curPipe, from $curX,$curY\n";

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
				echo "Going down to " . ($curX + 1) . ",$curY\n";
				return array($curX + 1, $curY);
			} else {
				// came from down, so go up
				echo "Going up to " . ($curX - 1) . ",$curY\n";
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
			echo "Didn't match any of the cases.  We are looking in $curX, $curY\n";
	}

	echo "Error shouldn't have gotten here\n";
	exit;
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
