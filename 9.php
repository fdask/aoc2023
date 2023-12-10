#!/usr/bin/php
<?php
// we get a report of many values and how they are changing over time
// each line rcontains history of a single value

// make a new sequence from the difference at each step of your history
// if that sequence is NOT all zeroes, repeat this process using sequence you 
// just generated as the input sequence

// once all the values in latest sequence are zeroes

// 0 3 6 9 12 15
//  3 3 3 3  3
//   0 0 0  0

// 0 3 6 9 12 15 B
//  3 3 3 3  3 A
//   0 0 0  0 0

// increase 0 by (A, get from left neighbour) = 3.

// 0 3 6 9 12 15 18
//  3 3 3 3  3 3
//   0 0 0  0 0

// 1877825184 is the right answer

// increase value to the left, by value below
$lines = file("input9.txt");
$sum = 0;

foreach ($lines as $line) {
	$nextDigit = 0;
	$nums = array();

	// for this line, find out what number comes next
	$nums[0] = preg_split("@\s+@", trim($line));

	$nums = goToZero($nums);
	//print_r($nums);

	$nums = addBackUp($nums);

	//print_r($nums);
	$sum += $nums[0][count($nums[0]) - 1];
}

echo "We have a sum of new digits of $sum\n";


/**
* pass in a single array of numbers, we'll go down to zeroes in the same array
**/
function goToZero($arr) {
	$curLine = 0;

	while (1) {
		//echo "initializing line " . $curLine + 1 . "\n";
		$arr[$curLine + 1] = array();

		for ($x = 1; $x < count($arr[$curLine]); $x++) {
			//echo "Adding " . $arr[$curLine][$x] . " - " . $arr[$curLine][$x - 1] . "\n";
			$arr[$curLine + 1][] = $arr[$curLine][$x] - $arr[$curLine][$x - 1];
			//print_r($arr);
		}

		$curLine++;

		// get the unique values and make sure they are all 1's
		$x = array_count_values($arr[$curLine]);

		//print_r($x);
		//echo "{$x[0]}\n";


		if (isset($x[0]) && $x[0] == count($arr[$curLine])) {
			//echo "returning\n";
			return $arr;
		}	

		//print_r($arr);
	} 
}

function addBackUp($arr) {
	$last = count($arr) - 1;

	// loop over lines starting at the end
	for ($x = count($arr) - 1; $x >= 0; $x--) {
		//echo "Adding digit to line $x\n";
		if ($x == count($arr) - 1) {
			// add a zero on the end
			$arr[$x][] = 0;
		} else {
			$arr[$x][] = ($arr[$x + 1][count($arr[$x]) - 1] + $arr[$x][count($arr[$x]) - 1]);
		}

		//print_r($arr);	
	}

	return $arr;
}
