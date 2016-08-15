<?php

class tableCleanView implements iTableCleanView {

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

	const TABLE_REGEX = '`<table[^<]*>(.*?)</table>`is';
	const ROW_REGEX = '`<tr[^<]*>(.*?)</tr>`is';
	const CELL_REGEX = '`<t([hd])[^<]*>(.*?)</t\1>`is';


	//  END:  properties
	// ==============================================================
	// START: public methods


	public function clean_tables($html) {
		if( !is_string($html) ) {
			throw get_class($this).'::clean_tables() expects only parameter $html to be a string. '.gettype($html).' given!';
		}
		return preg_replace_callback( self::TABLE_REGEX, array($this, 'CLEAN_TABLES_CALLBACK') , $html );
	}


	public function set_classes($element, $classes) {
		if( !is_string($element) ) {
			throw get_class($this).'::set_classes() expects first parameter $element to be a string. '.gettype($element).' given!';
		}
		if( !property_exists($this,$element) ) {
			throw get_class($this).'::set_classes() expects first parameter $element to be astring matching: "table", "thead", "tbody", "tfoot", "columns" or "rows". "'.$element.'" given';
		}
		if( gettype($classes) !== gettype($this->$element)) {
			throw get_class($this).'::set_classes() expects second parameter $classes to be a '.gettype($classes).' variable. '.gettype($element).' given';
		}

		if( $element === 'columns' || $element === 'rows' ) {
			$this->set_array_classes($element, $classes);
		} else {
			$this->set_string_classes($element, $classes);
		}
	}


	public function get_classes($element) {
		if( !is_string($element) ) {
			throw get_class($this).'::get_classes() expects first parameter to be a string. '.gettype($element).' given!';
		}
		if( !property_exists($this,$element) ) {
			throw get_class($this).'::get_classes() expects first parameter string matching: "table", "thead", "tbody", "tfoot", "columns" or "rows". "'.$element.'" given';
		}
		return $this->$element;
	}




	//  END:  public methods
	// ==============================================================
	// START: protected methods


	protected function CLEAN_TABLES_CALLBACK($matches) {
		$this->table_count += 1;


		$table_ID = "T{$this->table_count}_";


		if( preg_match_all('`<tr[^>]*>\s*(.*?)\s*</tr>`is', $matches, $rows , PREG_SET_ORDER) ) {

		}
	}


	protected function set_array_classes($element, $classes) {
		for( $a = 0 ; $a < count($classes) ; $a += 1 ) {
			if( is_bool($classes[$a]) ) {
				$this->$element[] = $classes[$a];
			} elseif( $classes[$a] == 0 ) {
				$this->$element[] = false;
			} elseif( $classes[$a] == 1 || $classes[$a] == '' ) {
				$this->$element[] = true;
			} elseif( is_string($classes[$a]) ) {
				$tmp = $this->validate_classes_string($classes[$a]);
				if( $tmp === '' ) {
					throw get_class($this).'::set_classes() second parameter $classes to be an array containing only valid HTML class names. $classes['.$a.'] ("'.$classes[$a].'") contains invalid class names';
				}
				$this->$element[] = $tmp;
			} else {
				throw get_class($this).'::set_classes() second parameter $classes to be an array containing only boolean or string values. $classes['.$a.'] is a '.gettype($classes[$a]);
			}
		}
	}


	protected function set_string_classes($element, $classes) {
		$tmp = $this->validate_classes_string($classes);
		if( $tmp === '' ) {
			throw get_class($this).'::set_classes() second parameter $classes to be an string containing only valid HTML class names. "'.$classes.'" contains invalid class names';
		}
		$this->$element = $tmp;
	}


	protected function validate_classes_string($input) {
		$input = trim($input);
		$input = preg_split('`\s+`', $input, PREG_SPLIT_NO_EMPTY);
		if( empty($input) ) {
			return '';
		}
		for( $a = 0 ; $a < count($input) ; $a += 1 ) {
			if( !preg_match( '`^[a-z][a-z0-9_\-]+$`i', $input[$a] ) ) {
				return '';
			}
		}
		return implode(' ', $input);
	}


	//  END:  protected methods
	// ==============================================================
}