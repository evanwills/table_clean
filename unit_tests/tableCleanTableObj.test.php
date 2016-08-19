<?php

use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class test__tableCleanTableObj extends PHPUnit_Framework_TestCase {

	private $sample = 'samples/multi-table.html';


// ==============================================================
// START: get_caption


	public function test_get_caption__returns_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_caption()));
	}

	public function test_get_caption__returns_correct_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals('Foundation studies units', $table->get_caption());
	}


//  END:  get_caption
// ==============================================================
// START: get_summary


	public function test_get_summary__returns_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_summary()));
	}

	public function test_get_summary__returns_correct_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals('Table has 3 columns and 5 rows.', $table->get_summary());
	}


//  END:  get_summary
// ==============================================================
// START: get_tfoot


	public function test_get_tfoot__returns_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_tfoot()));
	}

	public function test_get_tfoot__returns_correct_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals('<tr>
			<td colspan="3">This is the footer blah</td>
		</tr>', $table->get_tfoot());
	}


//  END:  get_tfoot
// ==============================================================
// START: get_find


	public function test_get_find() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();
		$this->assertEquals(true, is_string($table->get_find()));
	}


//  END:  get_find
// ==============================================================
// START: get_next_row


	public function get_next_row__returns_array() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(true, is_array($table->get_next_row()));
	}


	public function get_next_row__returns_array_with_3_items() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(3, count($table->get_next_row()));
	}


//  END:  get_next_row
// ==============================================================
// START: get_last_row


	public function test_get_last_row__returns_array() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(true, is_array($table->get_last_row()));
	}

	public function test_get_last_row__retuns_array_with_3_items() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(3, count($table->get_last_row()));
	}

	public function test_get_next_row__returns_correct_number_of_rows() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		$a = 0;
		while( $row = $table->get_next_row() ) {
			$a += 1;
		}

		$this->assertEquals($count , $a);
	}

	public function test_get_next_row__returns_false_when_all_rows_returned() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		for( $a = 0 ; $a < $count ; $a += 1) {
			$table->get_next_row();
		}
		$this->assertEquals(false, $table->get_last_row());
	}

	public function test_get_last_row__returns_false_when_all_rows_returned() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$count = $table->get_row_count();
		for( $a = 0 ; $a < $count ; $a += 1) {
			$table->get_last_row();
		}
		$this->assertEquals(false, $table->get_last_row());
	}


//  END:  get_last_row
// ==============================================================
// START: get_row_count


	public function test_get_row_count() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(6,$table->get_row_count());
	}


//  END:  get_row_count
// ==============================================================
// START: get_col_count


	public function test_get_col_count() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$table = $model->get_table();

		$this->assertEquals(3,$table->get_col_count());
	}


//  END:  get_col_count
// ==============================================================

}