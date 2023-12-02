#!/usr/bin/php
<?php
// cubes are either red, green, or blue
// what is the fewest number of cubes that would make each game possible?
// multiply the r*g*b, and sum

// 71274

$sum = 0;

// add up the ids of games that are possible
$lines = file("input2.txt");

foreach ($lines as $line) {
	if (preg_match("@Game (\d+):@", $line, $matches)) {
		$gamenum = $matches[1];

		$line = str_replace("Game $gamenum:", "", $line);

		$games = explode(";", $line);

		$reds = array(); 
		$greens = array();
		$blues = array();

		foreach ($games as $game) {
			// check the red
			if (preg_match("@(\d+) red@", $game, $matches)) {
				$reds[] = (int)$matches[1];
			}

			if (preg_match("@(\d+) green@", $game, $matches)) {
				$greens[] = (int)$matches[1];
			}

			if (preg_match("@(\d+) blue@", $game, $matches)) {
				$blues[] = (int)$matches[1];
			}
		}

		if (sizeof($blues) > 0) {
			$few_blue = max($blues);
		} else {
			$few_blue = 0;
		}

		if (sizeof($greens) > 0) {
			$few_green = max($greens);
		} else {
			$few_green = 0;
		}

		if (sizeof($reds) > 0) {
			$few_red = max($reds);
		} else {
			$few_red = 0;	
		}

		$power = $few_blue * $few_green * $few_red;

		$sum += $power;
	}
}

echo "Sum is $sum\n";
