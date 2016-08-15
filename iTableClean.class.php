<?php

interface iTableClean {
	/**
	 * @function set_classes() specifies user defined classes for individual columns
	 *
	 * @param string $element Name of element classes are to be applied to
	 * @param string, array $classes If string, space separated list of class names to be applied to the element
	 *                if array one item for each column/row in table (extra items will be ignored). Each item can be either string or boolean
	 *                if TRUE column/row heading will be used as class name. If FALSE, no class name will be applied to column
	 *
	 * @return void
	 */
	public function set_classes($element, $classes);

	/**
	 * @function get_classes() returns the classes applied to the specified element
	 *
	 * @param string $element Name of element classes are to be applied to
	 * @return string, array $classes space separated list of class names to be applied
	 *
	 * @return void
	 */
	public function get_classes($element);

	/**
	 * @function clean_tables() rewrites the HTML for each table in the input HTML
	 *
	 * @param string HTML to be cleaned up
	 *
	 * @return string HTML with clean accessible tables.
	 */
	public function clean_tables($html);
}