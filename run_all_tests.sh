#! /bin/bash

function runTest {

	if [ ! -z "$1" ]
	then
		echo;
		echo;
		echo '=================================================';
		echo "$1";
		echo '---------------------';
		echo;
		phpunit --bootstrap unit_tests/autoload.php unit_tests/"$1".test.php;

		echo;
		echo '=================================================';
		echo;
		echo;
	fi
}

runTest 'tableCleanModel';
runTest 'tableCleanTableObj';
runTest 'tableCleanView';

