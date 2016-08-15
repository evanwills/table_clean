<?php

class tableClean implements iTableClean {

	// ==============================================================
	// START: properties

	protected $view = null;

	protected $table = '';
	protected $thead = '';
	protected $tbody = '';
	protected $tfoot = '';
	protected $columns = array();
	protected $rows = array();

	protected $table_count = 0;

	const TABLE_REGEX = '`<table([^<]*)>(.*?)</table>`is';
	const ROW_REGEX = '`<tr[^<]*>(.*?)</tr>`is';
	const CELL_REGEX = '`<t([hd])[^<]*>(.*?)</t\1>`is';
	const SUMMARY_REGEX = '`\s+summary=("|\')?((?(1).*?(?=\1)|.*?(?=[\s>])))`is';
	const CAPTION_REGEX = '`<caption[^>]*>(.*?)</caption>`is';



	//  END:  properties
	// ==============================================================
	// START: public methods


	public function __construct( iTableCleanView $view ) {
		$this->view = $view;
	}


	public function clean_tables($html) {
		if( !is_string($html) ) {
			throw get_class($this).'::clean_tables() expects only parameter $html to be a string. '.gettype($html).' given!';
		}

		return preg_replace_callback(
			 self::TABLE_REGEX
			,array($this, 'CLEAN_TABLES_CALLBACK')
			,$html
		);
	}




	//  END:  public methods
	// ==============================================================
	// START: protected methods


	protected function CLEAN_TABLES_CALLBACK($matches) {
		$table_array = array();

		if( preg_match(self::SUMMARY_REGEX,$matches[1],$summary) ) {
			$this->view->set_summary($summary[2], true);
		}

		if( preg_match(self::CAPTION_REGEX,$matches[2],$caption) ) {
			$this->view->set_caption($caption[1], true);
			$matches[2] = str_replace( $caption[0] , '' , $matches[2] );
		}

		if( preg_match_all(
			 self::ROW_REGEX
			,$matches[2]
			,$rows
			,PREG_SET_ORDER)
		  ) {
			for( $a = 0 ; $a < count($rows) ; $a += 1 ) {
				if( preg_match_all(
					 self::CELL_REGEX
					,$rows[$a]
					,$cells
					,PREG_SET_ORDER
				  ) ) {
					$tmp = array();
					for( $b = 0 ; $b < count($cells) ; $b += 1 ) {
						$tmp[] = $cells[$b][2];
					}
					$table_array[] = $tmp;
				}
			}
			return $this->view->render_table($table_array);
		}
		return $this->matches[0];
	}



	//  END:  protected methods
	// ==============================================================
}