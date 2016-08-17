<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart

spl_autoload_register(
	function($class) {
		static $classes = null;
		if ($classes === null) {
			$classes = array(
				 'tablecleanmodel' => 'tableCleanModel.class.php'
				,'tablecleantableobj' => 'tableCleanTableObj.class.php'
				,'tablecleanview' => 'tableCleanView.class.php'
			);
		}
		$cn = strtolower($class);

		if (isset($classes[$cn])) {
	
			require dirname(__FILE__) . '/../' . $classes[$cn];
		}
	},
	true,
	false
);
// @codeCoverageIgnoreEnd