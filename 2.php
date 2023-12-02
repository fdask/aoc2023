#!/usr/bin/php
<?php
// cubes are either red, green, or blue
// which games are possible if the bag contained ONLY 12r, 13g, 14b?

// 2149 is the right answer
$max_red = 12;
$max_green = 13;
$max_blue = 14;

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

		// now see if any of the counts exceed our max
		if (
			(sizeof($reds) > 0 && max($reds) <= $max_red) && 
			(sizeof($greens) > 0 && max($greens) <= $max_green) && 
			(sizeof($blues) > 0 && max($blues) <= $max_blue)
		) {
			$sum += $gamenum;
		}
	}
}

echo "Sum is $sum\n";
