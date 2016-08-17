<?php

// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart

spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
				 'tableCleanModel' => 'tableCleanModel.class.php'
				,'tableCleanView' => 'tableCleanView.class.php'
				,'tableCleanTableObj' => 'tableCleanTableObj.class.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    },
    true,
    false
);
// @codeCoverageIgnoreEnd