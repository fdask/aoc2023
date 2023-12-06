#!/usr/bin/php
<?php
// 103 is too low
// 1531345297 is too high
// 1536308884

// list of all the seeds that need planting
// what type of soil to use with each seed
// fertilizer with each soil,
// water with fertilizer

// every seed, soil, fertilizer is identified with a number

// we are given several maps

// seed to soil

// soil to fertilizer

// fertilizer to water

// water to light

// light to temperature

// temperature to humidity

// humidity to location

// each line in a map contains three numbers
// dest range start
// source range start
// range length

// if a source number isn't mapped, it corresponds to the same destination

// they wanna know the closest location that needs a seed
// find the lowest location number that coresponds to any of the initial seeds
$lines = file("input5.txt");

// there are seven total maps
$maps = array(
	'seed-to-soil' => array(),
	'soil-to-fertilizer' => array(),
	'fertilizer-to-water' => array(),
	'water-to-light' => array(),
	'light-to-temperature' => array(),
	'temperature-to-humidity' => array(),
	'humidity-to-location' => array()
);

// extract all the seed numbers
$mapping = false;

foreach ($lines as $line) {
	echo "$line";

	if ($mapping) {
		if (preg_match("@(\d+) (\d+) (\d+)@", $line, $matches)) {
			$maps[$mapcat][] = array($matches[1], $matches[2], $matches[3]);
		} else {
			$mapping = false;
		}	
	} else if (preg_match("@seeds: (.*)@", $line, $matches)) {
		// extract the seeds numbers
		$seed_nums = $matches[1];
		$seeds = explode(" ", trim($seed_nums));

		print_r($seeds);
	} else if (preg_match("@([^-]+-to-[^-]+) map:@", $line, $matches)) {
		// when we encounter a map type, parse the name, and set mapping flag to true
		print_r($matches);
		$mapping = true;
		$mapcat = $matches[1];
	}
}

print_r($maps);
// for each seed, find the location

$locs = array();

foreach ($seeds as $seed) {
	$locs[] = findInMap($maps['humidity-to-location'], 
		findInMap($maps['temperature-to-humidity'], 
		findInMap($maps['light-to-temperature'],  
		findInMap($maps['water-to-light'], 
		findInMap($maps['fertilizer-to-water'], 
		findInMap($maps['soil-to-fertilizer'], 
		findInMap($maps['seed-to-soil'], 
		$seed
	)))))));
}

echo "these are locations\n";
print_r($locs);
// return the lowest location number
echo "The lowest term is " . min($locs) . "\n";

function findInMap($map, $number) {
	// destination, source, range	
	foreach ($map as $threesome) {
		$destination = $threesome[0];
		$source = $threesome[1];
		$range = $threesome[2];

		// is our number in the range?
		if ($number >= $source && $number < ($source + $range - 1)) {
			echo "we found a number in range!
			
			// we found a map!
			return $number + $range;
		}
	}

	// if we get here we have no map.
	// lets return the equivalent
	return $number;
}
?>
