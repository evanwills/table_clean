<?php

use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class tableCleanModel_test extends PHPUnit_Framework_TestCase {

	private $sample = 'samples/multi-table.html';

	public function test_get_table_count_returns_correct() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(24, $model->get_total_tables());

		for( $a = 0 ; $a < 5 ; $a += 1 )
		{
			$model->get_table();
		}
		$this->assertEquals(19, $model->get_tables_left_count());
		$this->assertEquals(5, $model->get_current_table_index());
	}

	public function test_get_table_returns_correct() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals('tableCleanTableObj', get_class($model->get_table()));

		while($row = $model->get_table()) {

		}
		$this->assertEquals(false, $model->get_table());
	}
}
