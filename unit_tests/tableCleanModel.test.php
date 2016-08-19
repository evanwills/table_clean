<?php

use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class test__tableCleanModel extends PHPUnit_Framework_TestCase {

	// sample has 24 tables and other content in the HTML
	private $sample = 'samples/multi-table.html';


// ==============================================================
// START: get_total_tables


	public function test__get_total_tables__returns_int() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(true, is_int($model->get_total_tables()));
	}

	public function test__get_total_tables__returns_24() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(24, $model->get_total_tables());
	}


//  END:  get_total_tables
// ==============================================================
// START: get_current_table_index


	public function test__get_current_table_index__is_int() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(true, is_int($model->get_current_table_index()));
	}

	public function test__get_current_table_index__1st_call_is_zero() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(0, $model->get_current_table_index());
	}

	public function test__get_current_table_index__6th_table_is_5() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		for( $a = 0 ; $a < 5 ; $a += 1 )
		{
			$model->get_table();
		}
		$this->assertEquals(5, $model->get_current_table_index());
	}

	public function test__get_current_table_index__24th_table_is_false() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		for( $a = 0 ; $a < 24 ; $a += 1 )
		{
			$model->get_table();
		}
		$this->assertEquals(false, $model->get_current_table_index());
	}


//  END:  get_current_table_index
// ==============================================================
// START: get_tables_left_count


	public function test__get_tables_left_count__is_int() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(true, is_int($model->get_tables_left_count()));
	}

	public function test__get_tables_left_count__1st_call_is_24() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals(24, $model->get_tables_left_count());
	}

	public function test__get_tables_left_count__7th_table_is_17() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		for( $a = 0 ; $a < 7 ; $a += 1 )
		{
			$model->get_table();
		}
		$this->assertEquals(17, $model->get_tables_left_count());
	}

	public function test__get_tables_left_count__24th_table_is_17() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		for( $a = 0 ; $a < 24 ; $a += 1 )
		{
			$model->get_table();
		}
		$this->assertEquals(0, $model->get_tables_left_count());
	}


//  END:  get_current_table_index
// ==============================================================
// START: get_table


	public function test__get_table__returns_tableCleanTableObj() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assertEquals('tableCleanTableObj', get_class($model->get_table()));
	}


	public function test__get_table__returns_when_no_tables() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		for( $a = 0 ; $a < 25 ; $a += 1 ) {
			$model->get_table();
		}
		$this->assertEquals(false, $model->get_table());



//  END:  get_table
// ==============================================================

	}
}
