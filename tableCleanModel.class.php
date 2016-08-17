<?php

class tableCleanModel {

	// ==============================================================
	// START: properties

	protected $tables = array();

	const TABLE_REGEX = '`<table([^<]*)>(.*?)</table>`is';
	const ROW_REGEX = '`<tr[^<]*>(.*?)</tr>`is';
	const CELL_REGEX = '`<t([hd])[^<]*>(.*?)</t\1>`is';
	const SUMMARY_REGEX = '`\s+summary=("|\')?((?(1).*?(?=\1)|.*?(?=[\s>])))`is';
	const CAPTION_REGEX = '`<caption[^>]*>(.*?)</caption>`is';
	const TFOOT_REGEX = '`<tfoot[^>]*>(.*?)</tfoot>`is';



	//  END:  properties
	// ==============================================================
	// START: public methods


	public function __construct($html) {
		if( !is_string($html) ) {
			throw new Exception(get_class($this).'::__construct() expects only parameter $html to be a string. '.gettype($html).' given!');
		}

		if( preg_match_all( self::TABLE_REGEX , $html , $tables , PREG_SET_ORDER ) ) {
			for( $a = 0 ; $a < count($tables) ; $a += 1 ) {
				$caption = '';
				$summary = '';
				$tfoot = '';
				$rows = array();
				$find = $tables[$a][0];

				if( preg_match( self::SUMMARY_REGEX , $tables[$a][1] , $matched_summary ) ) {
					$summary = $matched_summary[2];
					unset($matched_summary);
				}

				if( preg_match( self::TFOOT_REGEX , $tables[$a][2] , $matched_tfoot ) ) {
					$tfoot = $matched_tfoot[1];
					$tables[$a][2] = str_replace( $matched_tfoot[0] , '' , $tables[$a][2] );
					unset($matched_tfoot);
				}

				if( preg_match( self::CAPTION_REGEX , $tables[$a][2] , $matched_caption ) ) {
					$caption = $matched_caption[1];
					$tables[$a][2] = str_replace( $matched_caption[0] , '' , $tables[$a][2] );
					unset($matched_caption);
				}


				if( preg_match_all(
					 self::ROW_REGEX
					,$matches[2]
					,$matched_rows
					,PREG_SET_ORDER)
				  ) {
					for( $a = 0 ; $a < count($rows) ; $a += 1 ) {
						if( preg_match_all(
							 self::CELL_REGEX
							,$matched_rows[$a]
							,$cells
							,PREG_SET_ORDER
						  ) ) {
							$tmp = array();
							for( $b = 0 ; $b < count($cells) ; $b += 1 ) {
								$tmp[] = $cells[$b][2];
							}
							$rows[] = $tmp;
						}
					}
				}
				$this->tables[] = new tableCleanTableObj($find,$rows,$summary,$caption,$tfoot);
			}
		}
	}


	public function get_table() {
		if( !empty($this->tables) ) {
			return array_shift($this->tables);
		} else {
			return false;
		}
	}


	public function get_table_count() {
		return count($this->tables);
	}


	//  END:  public methods
	// ==============================================================
	// START: protected methods





	//  END:  protected methods
	// ==============================================================
}
