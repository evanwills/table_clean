<?php


use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class test__tableCleanView extends PHPUnit_Framework_TestCase {

	private $sample = 'samples/multi-table.html';

	public function test__render_table_returns_string() {
		$model = new tableCleanModel(file_get_contents($this->sample));
		$view = new tableCleanView(array());

		$this->assertEquals(true, is_string($view->render_table($model->get_table())));
	}

	public function test__get_property_summary() {
		$view = new tableCleanView(array('summary' => 'table has a summary'));
		$this->assertEquals('table has a summary', $view->get_property('summary'));
	}

	public function test__get_property_summary__after_render() {
		$view = new tableCleanView(array('summary' => 'table has a summary'));
		$model = new tableCleanModel(file_get_contents($this->sample));

		$view->render_table($model->get_table());
		$this->assertEquals('Table has 3 columns and 5 rows.', $view->get_property('summary'));
	}

	public function test__get_property_caption() {
		$view = new tableCleanView(array('caption' => 'This is a table caption'));
		$this->assertEquals('This is a table caption', $view->get_property('caption'));
	}

	public function test__get_property_caption__after_render() {
		$view = new tableCleanView(array('caption' => 'This is a table caption'));
		$model = new tableCleanModel(file_get_contents($this->sample));

		$view->render_table($model->get_table());
		$this->assertEquals('Foundation studies units', $view->get_property('caption'));
	}
}