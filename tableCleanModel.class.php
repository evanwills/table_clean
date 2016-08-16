<?php

class tableClean {

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
				$table = array(
					'caption' => '',
					'summary' => '',
					'tfoot' => '',
					'rows' => array(),
					'find' => $tables[$a][0]
				);

				if( preg_match( self::SUMMARY_REGEX , $tables[$a][1] , $summary ) ) {
					$table['summary'] = $summary[2];
				}

				if( preg_match( self::TFOOT_REGEX , $tables[$a][2] , $tfoot ) ) {
					$table['tfoot'] = $tfoot[1];
					$tables[$a][2] = str_replace( $tfoot[0] , '' , $tables[$a][2] );
				}

				if( preg_match( self::CAPTION_REGEX , $tables[$a][2] , $caption ) ) {
					$table['caption'] = $caption[1];
					$tables[$a][2] = str_replace( $caption[0] , '' , $tables[$a][2] );
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
							$table['rows'][] = $tmp;
						}
					}
				}
				$this->tables[] = $table;
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




	//  END:  public methods
	// ==============================================================
	// START: protected methods





	//  END:  protected methods
	// ==============================================================
}