<?php

interface iTableCleanView {
	/**
	 * @function set_classes() specifies user defined classes for individual columns
	 *
	 * @param string $element Name of element classes are to be
	 *               applied to
	 * @param string, array $classes If string, space separated list
	 *               of class names to be applied to the element. If
	 *               array one item for each column/row in table
	 *               (extra items will be ignored). Each item can be
	 *               either string or boolean. If TRUE column/row
	 *               heading will be used as class name. If FALSE, no
	 *               class name will be applied to column
	 *
	 * @return void
	 */
	public function set_classes($element, $classes);

	/**
	 * @function get_classes() returns the classes applied to the
	 *           specified element
	 *
	 * @param string $element Name of element classes are to be
	 *               applied to
	 * @return string, array $classes space separated list of class
	 *               names to be applied
	 *
	 * @return void
	 */
	public function get_classes($element);

	/**
	 * @function clean_tables() rewrites the HTML for each table in
	 *           the input HTML
	 *
	 * @param array two dimensional array. First dimension represents
	 *              rows and the second dimension is the table cells
	 *              in the row
	 *
	 * @return string HTML with clean accessible tables.
	 */
	public function render_table($table_array);
}