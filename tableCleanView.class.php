<?php

class tableCleanView implements iTableCleanView {

	// ==============================================================
	// START: properties


	protected $table_class = '';
	protected $thead_class = '';
	protected $tbody_class = '';
	protected $tfoot_class = '';

	protected $table_caption = '';
	protected $table_summary = '';

	protected $override_caption = '';
	protected $override_summary = '';

	protected $last_row_is_footer = false;
	protected $column_classes = array();
	protected $rows_classes = array();
	protected $col_count = 0;

	protected $table_count = 0;
	protected $table_ID = '';


	//  END:  properties
	// ==============================================================
	// START: public methods


	public function render_tables( $table_array ) {
		if( !is_array($table_array) ) {
			throw get_class($this).'::render_tables() expects only parameter $table_array to be a array. '.gettype($table_array).' given!';
		}

		$this->table_count += 1;
		$this->table_ID = "T{$this->table_count}_";

		$footer = array();
		if( $this->last_row_is_footer === true ) {
			$footer = array_pop($table_array);
		}
		$output = '<table';
		if( $this->table_classes !== '' ) {
			$output .= ' class="'.$this->table_classes.'"';
		}
		$output .=	 $this->render_summary()
					.'>'
					.$this->render_caption()
					.$this->render_thead(array_shift($table_array))
					.$this->render_tfoot($footer);

		$output .= '<tbody>';
		for( $a = 0 ; $a < count($able_array) ; $a += 1 ) {
			$output .= $this->render_row($table_array[$a]);
		}
		$output .= '</tbody></table>';

		return $output;
	}


	public function set_classes($element, $classes) {
		if( !is_string($element) ) {
			throw get_class($this).'::set_classes() expects first parameter $element to be a string. '.gettype($element).' given!';
		}
		$prop .= '_classes';
		if( !property_exists($this,$prop) ) {
			throw get_class($this).'::set_classes() expects first parameter $element to be a string matching: "table", "thead", "tbody", "tfoot", "column" or "row". "'.$element.'" given';
		}
		if( gettype($classes) !== gettype($this->$prop)) {
			throw get_class($this).'::set_classes() expects second parameter $classes to be a '.gettype($this->prop).' variable. '.gettype($classes).' given';
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
		$prop .= '_classes';
		if( !property_exists($this,$prop) ) {
			throw get_class($this).'::get_classes() expects first parameter string matching: "table", "thead", "tbody", "tfoot", "column" or "row". "'.$element.'" given';
		}
		return $this->$element;
	}


	public function set_summary($input, $override = false) {
		if( !is_string($input) ) {
			throw get_class($this).'::set_summary() expects only parameter $input to be a string. '.gettype($input).' given!';
		}
		$prop = 'table_summary';
		if( $override === true ) {
			$prop = 'override_summary';
		}
		$this->$prop = trim(
			str_replace(
				 array('"',"'")
				,''
				,strip_tags($input)
			)
		);
	}


	public function set_caption($input, $override = false) {
		if( !is_string($input) ) {
			throw get_class($this).'::set_caption() expects only parameter $input to be a string. '.gettype($input).' given!';
		}
		$prop = 'table_caption';
		if( $override === true ) {
			$prop = 'override_caption';
		}
		$this->$prop = trim(
			preg_replace(
				 '`<(script|style)[^>]*>.*?</\1>`is'
				,''
				,$input
			)
		);
	}




	//  END:  public methods
	// ==============================================================
	// START: protected methods




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


	protected function render_caption() {
		$output = '';
		if( $this->table_caption !== '' ) {
			$output .= '<caption>This table contains '.count($table_array[0]).' columns and '.count($table_array).' rows. '.$this->table_caption.'</caption>'
		}
		return $output;
	}


	protected function render_thead($header) {
		$this->col_count = count($header);

		$output = '<thead';
		if( $this->thead_classes !== '' ) {
			$output .= ' class="'.$this->thead.'"';
		}
		$output .= '><tr>';
		for( $a = 0 ; $a < count($headers) ; $a += 1 ) {
			$headers[$a] = trim($headers[$a]);
			if( $headers[$a] !== '' )
			{
				if( $this->column_classes[$a] === true ) {
					$this->column_classes[$a] = $this->css_safe($header[$a]);
				}
				$output .= '<th id="'.$this->$table_ID.'h'.$a.'"'.$this->get_cell_classes($a).'>'.$headers[$a].'</th>';
			} else {
				$output .= '<td>&nbsp;</td>';
			}
		}
		$output .= '</tr></thead>';
		return $output;
	}


	protected function render_tfoot($footer) {
		$output = '';
		if( !empty($footer) ) {
			$output .= '<tfoot';
			if( $this->tfoot_classes !== '' ) {
				$output .= ' class="'.$this->tfoot.'"';
			}
			$output .= '><tr>';
			$z = 0;
			$rowID = '';

			if( $this->no_row_header === false ) {
				$rowID = $this->$table_ID.'r'.$i;
				if()
				$output .= '<th id="'.$rowID.'" headers="'.$this->$table_ID.'h0"'.$this->get_cell_classes(0).'>'.$row[0].'</th>';
				$z = 1;
			}

			$c = count($row);
			for( $a = $z ; $a < $c ; $a += 1 ) {
				$output .= '<td'
						.$this->get_cell_headers( $a , $rowID )
						.$this->get_cell_classes($a)
						.$this->get_colspan( $a , $c )
						.'>'
						.trim($row[$a])
						.'</td>';
			}
			$output .= '</tr></tfoot>';
		}
		return $output;
	}


	protected function render_row($row, $i) {
		$output = '';
		if( !empty($row) ) {
			$z = 0;

			if( isset($this->row_classes[$i]) && $this->row_classes[$i] !== false && ->row_classes[$i] !== '' ) {
				$output = '<tr class="'.$this->row_classes[$i].'">';
			} else {
				$output = '<tr>';
			}

			$rowID = '';

			if( $this->no_row_header === false ) {
				$rowID = $this->$table_ID.'r'.$i;
				$output .= '<th id="'.$rowID.'"'.$this->get_cell_headers(0).$this->get_cell_classes(0).'>'.$row[0].'</th>';
				$z = 1;
			}

			$c = count($row);
			for( $a = $z ; $a < $c ; $a += 1 ) {
				$output .= '<td'
						.$this->get_cell_headers( $a , $rowID )
						.$this->get_cell_classes($a)
						.$this->get_colspan( $a , $c )
						.'>'
						.trim($row[$a])
						.'</td>';
			}
			$output .= '</tr>';
		}
		return $output;
	}

	protected function render_summary() {
		$output = '';
		if( $this->override_summary !== '' ) {
			$output = $this->override_summary;
		} elseif( $this->table_summary !== '' ) {
			$output = $this->table_summary;
		}
		if( $output !== '' ) {
			$output = ' summary="'.$output.'"';
		}
		return $output;
	}

	protected function get_colspan($i , $cell_c ) {
		$i += 1;
		if( $i === $cell_c && $cell_c < $this->col_count ) {
			return ' colspan="'. ($col_c - $cell_c) .'"';
		}
		return '';
	}

	protected function get_cell_classes($i) {
		if( isset($this->column_classes[$i]) && $this->column_classes[$i] !== false ) {
			return ' class="'.$this->column_classes[$i].'"';
		}
		return '';
	}

	protected function get_cell_headers($i, $rowID = '') {
		if( $rowID !== '' ) {
			$rowID = trim($rowID).' ';
		}
		return ' headers="'.$rowID.$this->$table_ID.'h'.$i.'"';
	}


	protected function css_safe($input) {
		$input = preg_replace(
			 array( '`[^a-z0-9_\-]+`i' , '`^[^a-z]+`i' , '`_?-_?`' )
			,array( '_' , '' , '-' )
			,trim($input)
		);

		if( $input === '' ) {
			return false;
		} else {
			return $input;
		}
	}


	//  END:  protected methods
	// ==============================================================
}