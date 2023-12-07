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

$lines = file("input7-sample.txt");

$bids = array();
$hands = array();

$types = array(
	'five',
	'four',
	'full',
	'three',
	'two',
	'one',
	'high'
);

// read in all hands, and bids
foreach ($lines as $line) {
	$bits = explode(" ", trim($line));

	$hands[] = $bits[0];
	$bids[] = $bits[1];
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
		echo "$hand = five of a kind!\n";
	} else if (strlen($unique_cards) == 2) {
		// four of a kind, full house
		// 5AAAA, 55AAA
		if (max(array_values($cv)) == 4) {
			echo "$hand = four of a kind\n";
		} else {
			echo "$hand = full house\n";
		}
	} else if (strlen($unique_cards) == 3) {
		// three, two pair
		// 555A1, 55AA1
		if (max(array_values($cv)) == 3) {
			echo "$hand = three of a kind\n";
		} else {
			echo "$hand = two pair\n";
		}
	} else if (strlen($unique_cards) == 4) {
		// one pair
		// 55AKQ
		echo "$hand == one pair\n";
	} else {
		// high card
		// 23456
		echo "$hand == high card\n";
	}
}
