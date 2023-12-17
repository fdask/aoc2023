#!/usr/bin/php
<?php
// advent of code #16

// (.) empty space
// (\ /) mirrors
// and splitters (| and -)

$lines = file("input16-sample.txt");
$grid = array();

foreach ($lines as $line) {
	$grid[] = str_split(trim($line));
}

// beam enters top left corner from the left and heading to the right

// if beam encounters empty space, it continues in the same direction
// mirrors reflect the beam 90 degrees
// pointy end of a splitter, beam passes through
// flat side of a splitter, beam is split going in two directions of the pointy ends
// beams do not interact with other beams

// tile is ENERGIZED if the tile has at least 1 beam pass through it

// how many tiles are energized?

// we start moving onto the board from the east
$dir = "e";

$beamX = 0;
$beamY = 0;

printMap($grid);

$paths = plotBeam($grid, $dir, $beamX, $beamY);

print_r($paths);

function plotBeam($grid, $dir, $x, $y) {
	echo "Starting a beam plot at ($x, $y), headed $dir\n";
	$ret = array([$x, $y]);

	// sanity check on the coords
	if ($x < 0 || $x >= count($grid) || $y < 0 || $y >= count($grid[0])) {
		return $ret;
	}

	do {
		switch ($grid[$x][$y]) {
			case '.':
				switch ($dir) {
					// if we can move in a direction, add that to the moves array
					// otherwise, return what we have so far
					case 'n':
						if ($x - 1 >= 0) {
							// we can make the north move with the beam
							$x = $x - 1;	
							$ret[] = array($x, $y);
							echo "($x, $y)\n";
						} else {
							// we've reached the end of this beam.
							return $ret;
						}

						break;
					case 'e':
						if ($y < count($grid[0]) - 1) {
							// we can make the move east
							$y = $y + 1;
							$ret[] = array($x, $y);
							echo "($x, $y)\n";
						} else {
							return $ret;
						}

						break;
					case 'w':
						if ($y > 0) {
							$y = $y - 1;
							$ret[] = array($x, $y);
							echo "($x, $y)\n";
						} else {
							return $ret;
						}

						break;
					case 's':
						if ($x < count($grid) - 1) {
							$x = $x + 1;
							$ret[] = array($x, $y);
							echo "($x, $y)\n";
						} else {
							return $ret;
						}

						break;
					default:
						echo "Shouldn't be here A\n";
						exit;
				}

				break;
			case '\\':
				echo "mirror!\n";
				echo "($x, $y)\n";
				$ret[] = array($x, $y);

				if ($dir == "n") {
					$dir = "w";
					$y = $y - 1;
				} else if ($dir == "e") {
					$dir = "s";
					$x = $x + 1;
				} else if ($dir == "w") {
					$dir = "n";
					$x = $x - 1;
				} else if ($dir == "s") {
					$dir = "e";
					$x = $x + 1;
				}

				break;
			case '/':
				echo "mirror!\n";
				echo "($x, $y)\n";
				$ret[] = array($x, $y);

				if ($dir == "n") {
					$dir = "e";
					$y = $y + 1;
				} else if ($dir == "e") {
					$dir = "n";
					$x = $x - 1;
				} else if ($dir == "w") {
					$dir = "s";
					$x = $x + 1;
				} else if ($dir == "s") {
					$dir = "w";
					$y = $y - 1;
				}

				break;
			case '|':
				if ($dir == "n" || $dir == "s") {
					echo "($x, $y)\n";
					$ret[] = array($x, $y);
					if ($dir == "n") {
						$x = $x - 1;
					} else {
						$x = $x + 1;
					}	
				} else {
					echo "SPLIT!\n";
					echo "($x, $y)\n";
					$ret[] = array($x, $y);

					return array_merge($ret, plotBeam($grid, "n", $x - 1, $y), plotBeam($grid, "s", $x + 1, $y));
				}

				break;
			case '-':
				if ($dir == "e" || $dir == "w") {
					echo "($x, $y)\n";
					$ret[] = array($x, $y);

					if ($dir == "e") {
						$y = $y + 1;
					} else {
						$y = $y - 1;
					}
				} else {
					echo "($x, $y)\n";
					echo "SPLIT!\n";
					$ret[] = array($x, $y);
					return array_merge($ret, plotBeam($grid, "e", $x, $y + 1), plotBeam($grid, "w", $x, $y - 1));
				}

				break;
			default:
				echo "Shouldn't be here B\n";
				exit;
		}
	} while (1);

	return $ret;
}

function printMap($map) {
	for ($x = 0; $x < count($map); $x++) {
		for ($y = 0; $y < count($map); $y++) {
			echo $map[$x][$y];
		}

		echo "\n";
	}

	echo "\n";
}
