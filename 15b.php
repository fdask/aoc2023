#!/usr/bin/php
<?php
// sequence of letters indicate the label of the lens on which the step operates
// run the hash algo on the label to get the correct box
// label immediately followed by = or -

// for dash, ggo to the relevant box and remove the lens with the given label if it is present
// then move any remaining lenses as far forward in the box as they can go without changing their order

// for equal, a number will follow indicating the focal length of the lens that needs to go into
// the relevant box
// 231984 is too high
$lines = file("input15.txt");

$line = trim($lines[0]);

// this result should be 52.
//var_dump(myhash("HASH"));

// sample data should be 1320

$bits = explode(",", $line);

$sum = 0;

// initialize the boxes
$boxes = array();

/*
$boxes = array(
	array(
		[key] => value
	)
);
*/
for ($x = 0; $x < 256; $x++) {
	$boxes[$x] = array();
}

foreach ($bits as $bit) {
	echo "$bit\n";

	if (preg_match("@([a-z]+)(=\d+|-)@", $bit, $matches)) {
		$label = $matches[1];
		$boxnum = myhash($label);
		echo "Label: $label  Boxnum: $boxnum ";

		if (preg_match("@=(\d+)@", $matches[2], $matches2)) {
			$focal_length = $matches2[1];
			echo "Focal length: $focal_length\n";

			// put a lens with $focal_length into the box
			$replaced = false;

			// if there is already a matching label in the box, replace the old with the new
			for ($x = 0; $x < count($boxes[$boxnum]); $x++) {
				if (preg_match("@$label @", $boxes[$boxnum][$x])) {
					$replaced = true;
					$boxes[$boxnum][$x] = "$label $focal_length";
				}
			}

			// if not already in the box, add the lens to the box behind any lenses already in there
			if (!$replaced) {
				// if the box is empty, lens goes to the front
				$boxes[$boxnum][] = "$label $focal_length";
			}
		} else {
			echo "Dash\n";
		
			// go to box $boxnum, and remove the lens with the given $label if present.
			for ($x = 0; $x < count($boxes[$boxnum]); $x++) {
				if (preg_match("@$label @", $boxes[$boxnum][$x])) {
					// remove element x from the array
					array_splice($boxes[$boxnum], $x, 1);
				}
			}
		}
	} else {
		echo "No match for $bit\n";
		exit;
	}
}

// add up the focusing power of all the boxes
$focusing_power = 0;

for ($x = 0; $x < count($boxes); $x++) {
	if (!empty($boxes[$x])) {
		foreach ($boxes[$x] as $order => $lens) {
			if (preg_match("@([a-z]+) (\d+)@", $lens, $matches)) {
				$focal_length = $matches[2];
				$focusing_power += ($x + 1) * ($order + 1) * $focal_length;
			} else {
				echo "Box $x\n";
				echo "We should never be here\n";
				exit;
			}
		}
	}
}

echo "We have a focusing power of $focusing_power\n";

//print_r($boxes);
exit;

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
