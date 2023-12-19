#!/usr/bin/php
<?php

$lines = file("input18-sample2.txt");

// starts in a 1 meter cube hole in the ground
// dig the specified number of meters u/d/l/r (north/south/west/east)

// each trench is also listed with the color that the edge of the trench should be painted
// as an rgb hexidecimal code

// this trench should form a loop

// dig out the center of the loop

// how many cubic meters of lava could the dug out trench hold?
$map = array();

$upDown = 0;
$leftRight = 0;

$posX = 0;
$posY = 0;

$map[0][0] = "#";

// we do a first pass just to get the ultimate dimensions we need
foreach ($lines as $line) {
	if (preg_match("@([ULDR]) ([\d+]) \((#[a-z0-9]{6})\)@", trim($line), $matches)) {
		$direction = $matches[1];
		$meters = $matches[2];
		$color = $matches[3];

		echo "Dig $meters $direction, ($color)\n";

		switch ($direction) {
			case 'D':

				/*
				echo "Starting at posX ($posX, $posY) we go..";
				for ($x = $posX + 1; $x <= ($posX + $meters); $x++) {
					echo "($x, $posY) ";
	
					if (!isset($map[$x])) {
						$map[$x] = array();
					}

					$map[$x][$posY] = "#";
				}

				$posX = $x;

				echo "\n";
				*/

				break;
			case 'U':
				/*
				echo "Starting at ($posX, $posY) we go..";

				for ($x = $posX - 1; $x >= ($posX - $meters); $x--) {
					
				}

				$posX = $x;

				echo "\n";
				*/

				break;
			case 'R':
				break;
			case 'L':
				break;
			default:
				echo "Shouldn't be here A\n";
				exit;
		}
	}
}
