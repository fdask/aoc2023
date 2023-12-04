#!/usr/bin/php
<?php

// 52508 is too high

// two lists of numbers separated by a vertical bar   a list of winning numbers, then
// a list of numbers you have.

// what numbers from our numbers are in the winning numbers.

// first match makes the card worth one point.  each match after the first doubles the point value of that card.

// total them together
$lines = file("input4.txt");

$sum = 0;

foreach ($lines as $line) {
	$line = preg_replace("@Card +\d+:@", "", $line);
	$line = str_replace("  ", " ", $line);

	$nums = explode("|", $line);

	$numbers = explode(" ", trim($nums[1]));
	$wnumbers = explode(" ", trim($nums[0]));

	$first = true;
	$card = 0;

	foreach ($numbers as $number) {
		// if a number is found in winning numbers, 
		if (in_array($number, $wnumbers)) {
			// 1 point for the first
			if ($first) {
				$first = false;
				$card += 1;
			} else {
				// double after
				$card = $card * 2;
			}

			$sum += $card;
		}
	}
}

echo "Sum total of winning tickets is $sum\n";
