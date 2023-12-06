#!/usr/bin/php
<?php
// was the right answer for A. 4403592
// the right answer for this one is 38017587
// each race
	// time allowed
	// best distance

// go further in each race

// my boat has 0mm/ms speed
// for each milli at the beginning of the race, speed goes up 1mm/ms
$lines = file("input6.txt");

$times = array();
$distances = array();

foreach ($lines as $line) {
	if (preg_match("@Time: +([\d\s]+)@", $line, $matches)) {
		$times = preg_split("@\s+@", trim($matches[1]));
	} else if (preg_match("@Distance: +([\d\s]+)@", $line, $matches)) {
		$distances = preg_split("@\s+@", trim($matches[1]));
	}
}

print_r($times);
print_r($distances);

$times = array(implode("", $times));
$distances = array(implode("", $distances));

print_r($times);
print_r($distances);

$ways_to_win = array();

// number of ways i can beat the record in each race
for ($x = 0; $x < count($times); $x++) {
	$ways_to_win[] = bestDistanceSpeed($distances[$x], $times[$x]);
}

// multiply these numbers together
echo "Ways to win the single race: " . $ways_to_win[0] . "\n";

function bestDistanceSpeed($distance, $time) {
	// we have to go farther than $distance, in $time.
	echo "Distance: $distance mm\n";
	echo "Max time: $time ms\n";

	$distanceCount = 0;

	// lets try each iteration of hold time (0-$time);
	for ($x = 0; $x < $time; $x++) {
		// with a hold time of $x, we are now at a speed of $x mm/ms
		// with the remaining time, lets travel that speed
		$tmp = $x * ($time - $x);

		echo "Holding for $x ms, going $tmp distance\n";
		if ($tmp > $distance) {
			$distanceCount++;
		}

	}	

	return $distanceCount;
}
?>
