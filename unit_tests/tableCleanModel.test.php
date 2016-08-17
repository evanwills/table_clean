<?php

use PHPUnit\Framework\TestCase;

//require_once('PHPUnit/Autoload.php');



class tableCleanModel_test extends PHPUnit_Framework_TestCase {

	private $sample = 'samples/multi-table.html';

	public function testConstructorAcceptsHTML() {
		$model = new tableCleanModel(file_get_contents($this->sample));

		$this->assetEquals(24, $model->get_table_count());
	}
}
