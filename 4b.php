#!/usr/bin/php
<?php

// two lists of numbers separated by a vertical bar   a list of winning numbers, then
// a list of numbers you have.

// number of winning numbers on a card, causes you to win copies of cards.
// if card 6 has 5 matches, we win COPIES of card 7, 8, 9, 10, 11

// the COPIES have the same methodology

// how many scratchcards do we end up with?
$lines = file("input4-sample.txt");

$cardcount = 0;
$copies = array();
$winnings = array();
$multipliers = array();

foreach ($lines as $line) {
	preg_match("@Card +(\d+):@", $line, $matches);
	$cardnum = $matches[1];

	$line = preg_replace("@Card +\d+:@", "", $line);
	$line = str_replace("  ", " ", $line);

	$nums = explode("|", $line);

	$numbers = explode(" ", trim($nums[1]));
	$wnumbers = explode(" ", trim($nums[0]));

	echo $line;
	echo "Processing card $cardnum... ";

	
	$match_count = count($numbers) - count(array_diff($numbers, $wnumbers));
	echo "We have " . count($numbers) . " numbers, " . $match_count . " matches\n";

	$winnings[$cardnum] = array();

	for ($x = $cardnum + 1; $x < $cardnum + 1 + $match_count; $x++) {
		$winnings[$cardnum][] = $x;
		echo "Won a copy of card $x\n";
		if (!isset($multipliers[$x])) {
			$multipliers[$x] = 2;
		} else {
			$multipliers[$x]++;
		}
	}

	$cardcount++;
}

print_r($winnings);
print_r($multipliers);

echo "The total number of cards is $cardcount\n";
