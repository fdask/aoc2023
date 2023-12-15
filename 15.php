#!/usr/bin/php
<?php
// start with a value of 0
// for each character in the string starting from the beginning
// add ascii code for the current character of the string
// multiply by 17
// remainder of dividing itself by 256

// answer is 516804
$lines = file("input15.txt");

$line = trim($lines[0]);

// this result should be 52.
//var_dump(myhash("HASH"));

// sample data should be 1320

$bits = explode(",", $line);

$sum = 0;

foreach ($bits as $bit) {
	$sum += myhash($bit);
}

echo "We got a sum of $sum\n";

function myhash($str) {
	$hash = 0;

	foreach (str_split($str) as $char) {
		$ascii = ord($char);
		$hash += $ascii;
		$hash = $hash * 17;
		$hash = $hash % 256;
	}

	return $hash;
}
