#!/usr/bin/php
<?php
// return the sum of all numbers adjacent to a symbol

// 528309 is too high
// 520386 is too high

$lines = file("input3.txt");

$sum = 0;

for ($linenum = 0; $linenum < sizeof($lines); $linenum++) {
	// iterate line by line, looking for numbers
	$line = $lines[$linenum];

	if (preg_match_all("@[0-9]+@", $line, $matches)) {
		if (!empty($matches[0])) {
			$offset = 0;

			foreach ($matches[0] as $num) {
				$pos = strpos($line, $num, $offset);

				if ($pos !== false) {
					$offset = $pos;
	
					$coords = array();

					if ($pos - 1 > 0) {
						$coords[][$linenum] = $pos - 1;
					}

					if (($pos + strlen($num)) <= strlen($line)) {
						$coords[][$linenum] = $pos + strlen($num);
					}

					for ($y = -1; $y <= strlen($num); $y++) {
						if ($linenum != 0) {
							$coords[][$linenum - 1] = $y + $pos;
						}

						if ($linenum < sizeof($lines)) {
							$coords[][$linenum + 1] = $y + $pos;
						}
					}
					
					// now lets search the coords for a symbol!
					foreach ($coords as $coord) {
						foreach ($coord as $x => $y) {
							if (preg_match("@[^0-9\.]@", substr($lines[$x], $y, 1))) {
								// we found a valid part number to be added to the sum
								$sum += (int)$num;
								break 2;
							}
						}
					}
				}
			}
		}
	}
}

echo "Got a sum of $sum\n";
