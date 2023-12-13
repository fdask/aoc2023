#!/usr/bin/php
<?php

// 37530 is too low!

// . operational
// # damaged
// ? unknown

// the numbers represent the series of contiguous springs

// how many different arrangements of operational and broken sprngs
// fit the given criteria in each row?

$lines = file("input12-sample.txt");
$sum = 0;

foreach ($lines as $line) {
	$bits = explode(" ", trim($line));

	// we want to "unfold the pattern, so do it here, at the start
	echo $bits[0] . " | " . $bits[1] . "\n";

	$pattern = unfoldPattern($bits[0]);
	$contiguous = unfoldContiguous($bits[1]);

	echo "$pattern | $contiguous\n";

	// get the positions in the pattern where a ? is located
	$split_pattern = str_split($pattern);
	$fills = array();

	for ($x = 0; $x < count($split_pattern); $x++) {
		if ($split_pattern[$x] == "?") {
			$fills[] = $x;
		}
	}

	//echo "$pattern\n";
	//print_r($fills);
	$binary_max = pow(2, count($fills));
	echo "There are 2^" . count($fills) . " possibilities here ($binary_max)\n";

	$wayCount = 0;

	for ($x = 0; $x < $binary_max; $x++) {
		$b = str_pad(decbin($x), count($fills), "0", STR_PAD_LEFT);
		$c = str_replace("1", "#", str_replace("0", ".", $b));

		// plug it into the main string
		$d = str_split($c);

		for ($y = 0; $y < count($fills); $y++) {
			$split_pattern[$fills[$y]] = $d[$y];		
		}

		$r = explode(",", $contiguous);
		$t = implode("", $split_pattern);

		$pat = convertPattern($t);
		//echo "Converting $t gets us " . implode(",", $pat) . "\n";
		if (convertPattern($t) == $r) {
			//echo "Got a match!\n";
			$wayCount++;
		}
	}

	$sum += $wayCount;	
}

echo "We have a total arrangement count of $sum\n";

function unfoldPattern($pattern) {
	$ret = array();

	for ($x = 0; $x < 5; $x++) {
		$ret[] = $pattern;
	}

	return implode("?", $ret);
}

function unfoldContiguous($contiguous) {
	$ret = array();

	for ($x = 0; $x < 5; $x++) {
		$ret[] = $contiguous;
	}

	return implode(",", $ret);
}

function convertPattern($pattern) {
	// $pattern should contain only # or .
	// #.#.### = 1,1,3
	$ret = array();

	$bits = str_split($pattern);

	$curCount = 0;

	for ($x = 0; $x < count($bits); $x++) {
		if ($bits[$x] == "#") {
			$curCount++;
		} else if ($bits[$x] == ".") {
			if ($curCount > 0) {
				$ret[] = $curCount;
			}

			$curCount = 0;
		}
	}

	if ($curCount > 0) {
		$ret[] = $curCount;
	}

	return $ret;
}
