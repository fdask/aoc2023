#!/usr/bin/php
<?php

// 52606 is too low
// 55121 is too high.
// 53221 is the answer
$input = file("input1.txt");

$sum = 0;

$firstnum = "";
$lastnum = "";

$lookup = array(
	'one' => 1,
	'two' => 2,
	'three' => 3,
	'four' => 4,
	'five' => 5,
	'six' => 6,
	'seven' => 7,
	'eight' => 8,
	'nine' => 9,
	'zero' => 0
);

foreach ($input as $line) {
	// find the first occurence of a digit in the string
	$chars = str_split($line);

	for ($x = 0; $x < strlen($line); $x++) {
		if (ctype_digit($chars[$x])) {
			$first = $x;
			$firstnum = $chars[$x];

			break;
		}
	}	

	// find the last occurence of a digit in the string
	for ($x = 0; $x < strlen($line); $x++) {
		if (ctype_digit($chars[$x])) {
			$last = $x;
			$lastnum = $chars[$x];
		}
	}

	foreach (array_keys($lookup) as $number) {
		$offset = 0;

		do {
			$match = stripos($line, $number, $offset);

			$offset = $match + 1;

			if ($match !== false) {
				echo "found a match.  '$number' as $match\n";
				if ($match < $first) {
					$first = $match;
					$firstnum = $lookup[$number];
				} else if ($match > $last) {
					$last = $match;
					$lastnum = $lookup[$number];
				}
			}
		} while ($match !== false);
	}

	echo "$line";
	echo "first is $first:$firstnum, last is $last:$lastnum\n\n";


	$add = (int)($firstnum . $lastnum);

	echo "sum: $sum + $add\n\n";
	$sum += $add;
}

echo "the sum is " . $sum . "\n";
