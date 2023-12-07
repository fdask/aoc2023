#!/usr/bin/php
<?php
// we get a list of hands, order them based on the strength of each hand
// a hand is five cards, labelled A, K, Q, J, T, 9, 8, 7, 6, 5, 4, 3, 2

// every hand is one type.
// five of a kind
// four of a kind
// full house
// three of a kind
// two pair
// one pair
// high card

// if two hands are the same type
// compare first card in each hand.  if first cards are the same, go to next cards

// given a list of hands, and corresponding bid
// each hand wins an amount equal to its bid, multiplied by its rank
// weakest hand is rank 1, second weakest, rank 2, etc.

// correct answer is 253603890

$lines = file("input7.txt");

$bids = array();
$hands = array();
$bidmap = array();

$types = array(
	'five' => array(),
	'four' => array(),
	'full' => array(),
	'three' => array(),
	'two' => array(),
	'one' => array(),
	'high' => array()
);

// read in all hands, and bids
foreach ($lines as $line) {
	$bits = explode(" ", trim($line));

	$hands[] = $bits[0];
	$bids[] = $bits[1];

	$bidmap[$bits[0]] = $bits[1];
}

// now sort each hand into a type.
for ($hc = 0; $hc < count($hands); $hc++) {
	$hand = $hands[$hc];
	$bid = $bids[$hc];

	$unique_cards = implode("", array_unique(str_split($hand)));
	$cv = array_count_values(str_split($hand));	

	if (strlen($unique_cards) == 1) {
		// we have a five of a kind.
		// AAAAA
		//echo "$hand = five of a kind!\n";
		$types['five'][] = array($hand, $bid);
	} else if (strlen($unique_cards) == 2) {
		// four of a kind, full house
		// 5AAAA, 55AAA
		if (max(array_values($cv)) == 4) {
			//echo "$hand = four of a kind\n";
			$types['four'][] = array($hand, $bid);
		} else {
			//echo "$hand = full house\n";
			$types['full'][] = array($hand, $bid);
		}
	} else if (strlen($unique_cards) == 3) {
		// three, two pair
		// 555A1, 55AA1
		if (max(array_values($cv)) == 3) {
			//echo "$hand = three of a kind\n";
			$types['three'][] = array($hand, $bid);
		} else {
			//echo "$hand = two pair\n";
			$types['two'][] = array($hand, $bid);
		}
	} else if (strlen($unique_cards) == 4) {
		// one pair
		// 55AKQ
		//echo "$hand == one pair\n";
		$types['one'][] = array($hand, $bid);
	} else {
		// high card
		// 23456
		//echo "$hand == high card\n";
		$types['high'][] = array($hand, $bid);
	}
}

print_r($types);

// now sort the hands within by looking for high cards
$sorted_hands = array();

foreach (array('high', 'one', 'two', 'three', 'full', 'four', 'five') as $type) {
	$tmp_hands = array();

	if (empty($types[$type])) {
		continue;
	}

	if (count($types[$type]) == 1) {
		// there is only one hand of this type.
		$sorted_hands[] = $types[$type][0][0];
	} else {
		// subsort these hands
		foreach ($types[$type] as $hand) {
			$tmp_hands[] = $hand[0];
		}		

		//echo "Tmp hands befre sorting\n";
		//print_r($tmp_hands);

		//echo "Tmp hands after sorting\n";
		usort($tmp_hands, "compareHands");
		//print_r($tmp_hands);

		for ($x = 0; $x < count($tmp_hands); $x++) {
			$sorted_hands[] = $tmp_hands[$x];
		}
	}	
}

// now with the hands sorted, we just need to find the bet amounts
print_r($sorted_hands);

$sum = 0;

for ($x = 0; $x < count($sorted_hands); $x++) {
	$multiplier = $x + 1;
	$sum += $bidmap[$sorted_hands[$x]] * $multiplier;
}

echo "We got a sum of $sum\n";

function compareHands($h1, $h2) {
	// lets get the case where the hands are equal, out of the way
	if ($h1 == $h2) {
		return 0;
	}

	$cards = "23456789TJQKA";
	$bits1 = str_split($h1);
	$bits2 = str_split($h2);

	// for each of the five cards in the hands,
	for ($x = 0; $x < count($bits1); $x++) {
		// look for the position of the current bit in the $cards array
		$one = strpos($cards, $bits1[$x]);
		$two = strpos($cards, $bits2[$x]);

		if ($one > $two) {
			return 1;
		} else if ($two > $one) {
			return -1;
		}
	}

	// we shouldn't get here
}

// take a string of 5 chars , each representing a card
// return the highest hand type possible if the jokers are wild
function jokersWild($hand) {

}
