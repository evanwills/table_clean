<?php

use PHPUnit\Framework\TestCase;



class tableCleanModel_test extends TestCase {
	private $sample = 'samples/multi-table.html';

	public function constructorAcceptsHTML() {
		$model = new tableCleanModel(file_get_contents($this->sample));
		$this->assetEquals(24, $model->get_table_count());
	}
}