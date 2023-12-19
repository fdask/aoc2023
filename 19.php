#!/usr/bin/php
<?php

// 476889 is the right answer.

// each part is rated in each of four categories
// x: extremely cool
// m: musical
// a: aerodynamic
// s: shiny

// each part sent througha  series of workflows that will
// either accept or reject the part

// each workflow has a name
// contains a list of rules

// each rule specifies a condition and where to send 
// the part if the condition is true

// first rule that matches is applied immediately

// last rule always matches (no condition)

// ex{x>10:one,m<20:two,a>30:R,A}

// accepted (sent to A)
// rejected (sent to R)

// all parts begin in a workflow named in
$workflow = "in";

$parts = array();
$acceptedParts = array();
$workflows = array();

$lines = file("input19.txt");

foreach ($lines as $line) {
	if (preg_match("@([a-z]+)\{([^\}]+)\}@", trim($line), $matches)) {
		$name = $matches[1];
		$rules = explode(",", $matches[2]);

		$workflows[$name] = $rules;
	} else if (preg_match("@\{([^\}]+)\}@", trim($line), $matches)) {
		$part = array();
		$partProperties = $matches[1];
		
		foreach (explode(",", $partProperties) as $property) {
			if (preg_match("@([xmas])=(\d+)@", $property, $matches)) {
				$part[$matches[1]] = $matches[2];
			}
		}

		$parts[] = $part;
	}
}

// put every part through the workflows
foreach ($parts as $part) {
	$workflow = 'in';

	echo "===\n";
	echo "Starting a new part \n";
	print_r($workflows);
	print_r($part);
	echo "===\n";	

	// go through the workflow rules in order
	do {
		echo "we have a workflow named '$workflow'\n";
	
		if (!isset($workflows[$workflow])) {
			echo "Trying to access '$workflow' workflow\n";
			exit;
		}

		for ($x = 0; $x < count($workflows[$workflow]); $x++) {
			// run the rule on the part
			$rule = $workflows[$workflow][$x];
			echo "On rule $x in the workflow '$rule'\n";

			// if this rule matches the part, 
			$rm = ruleMatches($part, $rule);

			if ($rm) {
				echo "The rule matches!  We're going to $rm\n";
				// go where the rule tells us
				$workflow = $rm;
				break;
			}  
		}

		if ($workflow == "A") {
			$acceptedParts[] = $part;		
			break;
		} else if ($workflow == "R") {
			break;
		}
	} while ($workflow != "R" || $workflow != "A");

	echo "Part ended up in $workflow\n\n";
}

/*
print_r($parts);
print_r($workflows);
*/

$total = 0;

foreach ($acceptedParts as $part) {
	$total = $total + $part['x'] + $part['m'] + $part['a'] + $part['s'];
}

echo "We got a total of $total\n";

function ruleMatches($part, $condition) {
	if (preg_match("@(([xmas])([<>])(\d+)):(.*)@", $condition, $matches)) {
		echo "Got a rule of $condition\n";

		$property = $matches[2];
		$operator = $matches[3];
		$value = $matches[4];
		$workflow = $matches[5];

		if ($operator == ">") {
			if ($part[$property] > $value) {
				echo "rule matches 1\n";
				return $workflow;
			}
		} else if ($operator == "<") {
			if ($part[$property] < $value) {
				echo "rule matches 2\n";
				return $workflow;
			}
		} else {
			echo "We have an operator thats not valid ($operator)\n";
			exit;
		}
	} else {
		// no condition
		echo "No condition on '$condition'\n";
		return $condition;
	}

	echo "returning false\n";
	return false;
}

/*
px{a<2006:qkq,m>2090:A,rfg}
pv{a>1716:R,A}
lnx{m>1548:A,A}
rfg{s<537:gd,x>2440:R,A}
qs{s>3448:A,lnx}
qkq{x<1416:A,crn}
crn{x>2662:A,R}
in{s<1351:px,qqz}
qqz{s>2770:qs,m<1801:hdj,R}
gd{a>3333:R,R}
hdj{m>838:A,pv}

{x=787,m=2655,a=1222,s=2876}
*/
