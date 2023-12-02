#!/usr/bin/php
<?php
// 55834 is the answer.
$input = file("input1.txt");

$sum = 0;

foreach ($input as $line) {
	echo "line: $line";
	$nums = preg_replace("@[^0-9]@", "", $line);

	echo "nums: $nums\n\n";

	$add = (int)($nums[0] . $nums[-1]);
	echo "sum: $sum + $add\n\n";
	$sum += $add;
}

echo "the sum is " . $sum . "\n";
