<?php

class tableCleanView {

	protected static $table_count = 0;

	// ==============================================================
	// START: properties


	protected $table_classes = '';
	protected $thead_classes = '';
	protected $tbody_classes = '';
	protected $tfoot_classes = '';

	protected $caption = '';
	protected $summary = '';
	protected $tfoot = '';

	protected $last_row_is_footer = false;
	protected $first_row_is_header = true;
	protected $auto_generate_summary_stats = false;
	protected $table_has_borders = false;
	protected $table_is_striped = false;
	protected $use_row_header = true;

	protected $column_classes = array();
	protected $rows_classes = array();
	protected $col_count = 0;
	protected $row_count = 0;

	protected $table_ID = '';


	//  END:  properties
	// ==============================================================
	// START: public methods


	public function __construct( $table_config ) {

		if( !is_array($table_config) ) {
			throw  new Exception(get_class($this).'::__construct() expects only parameter $table_config to be an array. '.gettype($table_config).' given!');
		}

		self::$table_count += 1;
		$this->table_ID = 'T' . self::$table_count . '_';

		foreach( $table_config as $key => $value ) {
			if( !property_exists($this,$key) ) {
				throw  new Exception(get_class($this).'::__construct() expects only parameter $table_config to be an array containing valid config properties. "'.$key.'" is not a valid config property');
			}
			if( gettype($this->$key) !== gettype($value) ) {
				throw  new Exception(get_class($this).'::__construct() expects $table_config['.$key.'] to be '.gettype($this->$key).'. '.gettype($value).' given');
			}

			if( is_bool($value) ) {
				$this->$key = $value;
			}
			elseif( strlen($key) > 8 && substr($key, -8, 8) === '_classes' ) {
				if( is_string($value) ) {
					$this->set_string_classes($key,$value);
				} else {
					$this->set_array_classes($key,$value);
				}
			} else {
				$func = 'sanitise_'.$key;
				if( method_exists($this,$func) ) {
					$this->$key = $this->$func($value);
				}
			}
		}
	}


	public function render_table( tableCleanTableObj $table ) {

		$output = '<table';
		if( $this->table_classes !== '' ) {
			$output .= ' class="'.$this->table_classes.'"';
		}
		$output .=	 $this->render_summary( $table->get_summary() , $table->get_col_count() , $table->get_row_count() )
					.'>'
					.$this->render_caption( $table->get_caption() )
					.$this->render_thead( $table )
					.$this->render_tfoot( $table->get_tfoot() , $table );

		$output .= '<tbody>';
		while( $row = $table->get_next_row() ) {
			$output .= $this->render_row($row);
		}
		$output .= '</tbody></table>';


		return $output;
	}

	public function get_property($prop) {
		if( !is_string($prop) ) {
			throw  new Exception(get_class($this).'::get_property() expects only parameter $prop to be a string. '.gettype($prop).' given!');
		}

		if( !property_exists($this,$prop) ) {
			throw  new Exception(get_class($this).'::get_property() expects first parameter $prop valid tableCleanView property.');
		}
		return $this->$prop;
	}




	//  END:  public methods
	// ==============================================================
	// START: protected methods


	// --------------------------------------------------------------
	// START: render methods


	protected function render_caption($caption) {
		$caption = $this->sanitise_caption($caption);
		if( $caption === '' ) {
			$caption = $this->caption;
		}
		$output = '';
		if( $caption !== '' ) {
			$output .= '<caption>'.$caption.'</caption>';
		}
		return $output;
	}


	protected function render_summary( $summary , $cols , $rows ) {
		$summary = $this->sanitise_summary($summary);
		if( $summary === '' ) {
			$summary = $this->summary;
		}
		if( $this->auto_generate_summary_stats === true ) {
			$summary = 'This table has '.$cols.' columns and '.$rows.' rows. '.$summary;
		}
		$output = '';
		if( $summary !== '' ) {
			$output .= ' summary="'.$summary.'"';
		}
		return $output;
	}


	protected function render_thead( $table ) {
		$this->col_count = count($header);

		$output = '';
		if( $this->first_row_is_header !== false ) {

			$header = $table->get_next_row();

			$output = '<thead';
			if( $this->thead_classes !== '' ) {
				$output .= ' class="'.$this->thead_classes.'"';
			}
			$output .= '><tr>';

			for( $a = 0 ; $a < count($headers) ; $a += 1 ) {
				$headers[$a] = trim($headers[$a]);
				if( $headers[$a] !== '' )
				{
					if( $this->column_classes[$a] === true ) {
						$this->column_classes[$a] = $this->sanitise_class_name($header[$a]);
					}
					$output .= '<th id="'.$this->$table_ID.'h'.$a.'"'.$this->get_cell_classes($a).'>'.$headers[$a].'</th>';
				} else {
					$output .= '<td>&nbsp;</td>';
				}
			}

			$output .= '</tr></thead>';
		}

		return $output;
	}


	protected function render_tfoot($tfoot , $table) {
		$output = '';

		if( $tfoot !== '' ) {
			$footer = $tfoot;
		} elseif( $this->last_row_is_footer === true ) {
			$footer = $table->get_last_row();
		} else {
			$footer = $this->tfoot;
		}

		if( $footer !== '' ) {
			$output .= '<tfoot';
			if( $this->tfoot_classes !== '' ) {
				$output .= ' class="'.$this->tfoot_classes.'"';
			}
			$output .= '><tr>';
			$z = 0;
			$row_ID = '';

			if( $this->no_row_header === false ) {
				$row_ID = $this->$table_ID.'r'.$i;
				$output .= '<th id="'.$row_ID.'" headers="'.$this->$table_ID.'h0"'.$this->get_cell_classes(0).'>'.$row[0].'</th>';
				$z = 1;
			}

			$c = count($row);
			for( $a = $z ; $a < $c ; $a += 1 ) {
				$output .= '<td'
						.$this->get_cell_headers( $a , $row_ID )
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


	protected function render_row($row) {
		$output = '';
		if( !empty($row) ) {
			$this->row_count += 1;

			$i = $this->row_count;
			$row_ID = '';
			$z = 0;

			$row = $this->sanitise_row($row);

			$output = '<tr';
			if( isset($this->row_classes[$i]) && $this->row_classes[$i] !== false ) {
				$output .= ' class="';
				if( $this->row_classes[$i] === true ) {
					$output .= $this->sanitise_class_name($row[0]);
				} else if( is_string($this->row_classes[$i])  && $this->row_classes[$i] !== '' ) {
					$output .= $this->row_classes[$i];
				}
				$output .= '"';
			}
			$output .= '>';


			if( $this->use_row_header !== false ) {
				$row_ID = $this->$table_ID.'r'.$i;
				$output .= '<th id="'.$row_ID.'"'.$this->get_cell_headers(0).$this->get_cell_classes(0).'>'.$row[0].'</th>';
				$z = 1;
			}

			$cell_count = count($row);
			for( $a = $z ; $a < $cell_count ; $a += 1 ) {
				$output .= '<td'
						.$this->get_cell_headers( $a , $row_ID )
						.$this->get_cell_classes($a)
						.$this->get_colspan( $a , $cell_count )
						.'>'
						.trim($row[$a])
						.'</td>';
			}
			$output .= '</tr>';
		}
		return $output;
	}


	//  END:  render methods
	// --------------------------------------------------------------
	// START: sanitise methods


	protected function sanitise_caption($input) {
		return trim(
			preg_replace(
				 '`<(script|style)[^>]*>.*?</\1>`is'
				,''
				,$input
			)
		);
	}


	protected function sanitise_summary($input) {
		return trim(
			str_replace(
				 array('"',"'")
				,''
				,strip_tags($input)
			)
		);
	}


	protected function sanitise_class_name($input) {
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


	protected function sanitise_classes_string($input) {
		$input = trim($input);
		$input = preg_split('`\s+`', $input, PREG_SPLIT_NO_EMPTY);
		if( empty($input) ) {
			return '';
		}
		$output = array();
		for( $a = 0 ; $a < count($input) ; $a += 1 ) {
			$input[$a] = $this->sanitise_class_name($input[$a]);
			if( $input[$a] !== '' && $input[$a] !== false ) {
				$output[] = $input[$a];
			}
		}
		return implode(' ', $output);
	}

	/**
	 * to be overwritten by child classes to do stuff (who knows what) that might be necessary
	 * @param  array $row cells in the given row
	 * @return array parsed cells
	 */
	protected function sanitise_row($row) {
		return $row;
	}



	//  END:  sanitise methods
	// --------------------------------------------------------------
	// START: set methods



	protected function set_array_classes($element, $classes) {
		for( $a = 0 ; $a < count($classes) ; $a += 1 ) {
			if( is_bool($classes[$a]) ) {
				$this->{$element}[] = $classes[$a];
			} elseif( $classes[$a] == 0 ) {
				$this->{$element}[] = false;
			} elseif( $classes[$a] == 1 || $classes[$a] == '' ) {
				$this->{$element}[] = true;
			} elseif( is_string($classes[$a]) ) {
				$tmp = $this->sanitise_classes_string($classes[$a]);
				if( $tmp === '' ) {
					throw  new Exception(get_class($this).'::set_classes() second parameter $classes to be an array containing only valid HTML class names. $classes['.$a.'] ("'.$classes[$a].'") contains invalid class names');
				}
				$this->{$element}[] = $tmp;
			} else {
				throw  new Exception(get_class($this).'::set_classes() second parameter $classes to be an array containing only boolean or string values. $classes['.$a.'] is a '.gettype($classes[$a]));
			}
		}
	}


	protected function set_string_classes($element, $classes) {
		$tmp = $this->sanitise_classes_string($classes);
		if( $tmp === '' ) {
			throw  new Exception(get_class($this).'::set_classes() second parameter $classes to be an string containing only valid HTML class names. "'.$classes.'" contains invalid class names');
		}
		$this->$element = $tmp;
	}



	//  END:  set methods
	// --------------------------------------------------------------
	// START: get methods




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

	protected function get_cell_headers($i, $row_ID = '') {
		if( $row_ID !== '' ) {
			$row_ID = trim($row_ID).' ';
		}
		return ' headers="'.$row_ID.$this->$table_ID.'h'.$i.'"';
	}



	//  END:  get methods
	// --------------------------------------------------------------



	//  END:  protected methods
	// ==============================================================
}
