#!/usr/bin/php
<?php

//$input = file_get_contents("https://adventofcode.com/2023/day/1/input");
// 52606 is too low
$input = file("input1.txt");

$sum = 0;

foreach ($input as $line) {
	echo "line: $line";
	$line = preg_replace("@one@", "1", $line);
	$line = preg_replace("@two@", "2", $line);
	$line = preg_replace("@three@", "3", $line);
	$line = preg_replace("@four@", "4", $line);
	$line = preg_replace("@five@", "5", $line);
	$line = preg_replace("@six@", "6", $line);
	$line = preg_replace("@seven@", "7", $line);
	$line = preg_replace("@eight@", "8", $line);
	$line = preg_replace("@nine@", "9", $line);
	$nums = preg_replace("@[^0-9]@", "", $line);

	echo "nums: $nums\n\n";

	$add = (int)($nums[0] . $nums[-1]);
	/*
	if (strlen($nums) > 1) {
		$add = (int)($nums[0] . $nums[-1]);
	} else if (strlen($nums) == 1) {
		$add = $nums[0];
	} else {
		$add = 0;
	}
	 */

	echo "sum: $sum + $add\n\n";
	$sum += $add;
}

echo "the sum is " . $sum . "\n";
