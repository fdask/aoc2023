#!/usr/bin/php
<?php
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

$hold_times = array();

// number of ways i can beat the record in each race
for ($x = 0; $x < count($times); $x++) {
	$hold_times[] = bestDistanceSpeed($distances[$x], $times[$x]);
}

// multiply these numbers together
echo "Multiplied number of race wins == " . array_product($hold_times) . "\n";

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
