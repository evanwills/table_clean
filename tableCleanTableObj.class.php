<?php

class tableCleanTableObj {

	protected $caption = '';
	protected $summary = '';
	protected $tfoot = '';
	protected $rows = array();
	protected $find = '';
	protected $row_count = 0;
	protected $col_count = 0;

	public function __construct( $find , $rows , $summary = '' , $caption = '' , $tfoot ) {
		if( !is_string($find) || trim($find) === '' ) {
			throw new Exception('tableCleanTableModel::__construct() expects first parameter $find to be a non empty string.');
		}
		if( !is_array($rows) || empty($rows) ) {
			throw new Exception('tableCleanTableModel::__construct() expects second parameter $rows to be a non empty array.');
		}
		if( !is_string($summary) ) {
			throw new Exception('tableCleanTableModel::__construct() expects third parameter $summary to be a string. '. gettype($summary). ' given' );
		}
		if( !is_string($caption) ) {
			throw new Exception('tableCleanTableModel::__construct() expects fourth parameter $caption to be a string. '. gettype($caption). ' given' );
		}
		if( !is_string($tfoot) ) {
			throw new Exception('tableCleanTableModel::__construct() expects fifth parameter $tfoot to be a string. '. gettype($tfoot). ' given' );
		}
		$this->find = $find;
		$this->rows = $rows;
		$this->summary = $summary;
		$this->caption = $caption;
		$this->tfoot = $tfoot;

		$this->row_count = count($this->rows);
		$this->col_count = count($this->rows[0]);
	}

	public function get_caption() {
		return $this->caption;
	}

	public function get_summary() {
		return $this->summary;
	}

	public function get_find() {
		return $this->find;
	}

	public function get_tfoot() {
		return $this->tfoot;
	}

	public function get_next_row() {
		if( !empty($this->rows) ) {
			return array_shift($this->rows);
		}
		return false;
	}

	public function get_last_row() {
		if( !empty($this->rows) ) {
			return array_pop($this->rows);
		}
		return false;
	}

	public function get_row_count() {
		return $this->row_count;
	}

	public function get_col_count() {
		return $this->col_count;
	}
}