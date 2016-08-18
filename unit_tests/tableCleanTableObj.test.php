<?php

use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class tableCleanModel_test extends PHPUnit_Framework_TestCase {

	private $sample = 'samples/multi-table.html';


	public function test_get_caption() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_caption()));
	}

	public function test_get_summary() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_summary()));
	}

	public function test_get_find() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_find()));
	}

	public function test_get_tfoot() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_tfoot()));
	}

	public function get_next_row() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(true, is_array($table->get_next_row()));
		$this->assertEquals(3, count($table->get_next_row()));
	}

	public function test_get_next_row_returns_correct_number_of_rows() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		$a = 0;
		while( $row = $table->get_next_row() ) {
			$a += 1;
		}

		$this->assertEquals($count , $a);
	}

	public function test_get_next_row_returns_false_when_all_rows_returned() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		for( $a = 0 ; $a < $count ; $a += 1) {
			$table->get_next_row();
		}
		$this->assertEquals(false, $table->get_last_row());
	}

	public function test_get_last_row_returns_false_when_all_rows_returned() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		for( $a = 0 ; $a < $count ; $a += 1) {
			$table->get_last_row();
		}
		$this->assertEquals(false, $table->get_last_row());
	}

	public function test_get_last_row() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(true, is_array($table->get_last_row()));
		$this->assertEquals(3, count($table->get_last_row()));
	}

	public function test_get_row_count() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(6,$table->get_row_count());
	}

	public function test_get_col_count() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(3,$table->get_col_count());
	}

}