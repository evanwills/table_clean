<?php

$file = fopen('unit_tests/autoload.php' , 'w+');

fwrite($file, '<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart

spl_autoload_register(
	function($class) {
		static $classes = null;
		if ($classes === null) {
			$classes = array(');

$classes = scandir(dirname(__FILE__) . '/../');
$sep = ' ';
for( $a = 0 ; $a < count($classes) ; $a += 1 )
{
	if( preg_match('`^(tableClean[a-z]+)\.class\.php$`i',$classes[$a],$matches) )
	{
		fwrite($file, "\n\t\t\t\t$sep'" . strtolower($matches[1]) . "' => '{$matches[0]}'");
		$sep = ',';
	}
}

fwrite($file, '
			);
		}
		$cn = strtolower($class);

		if (isset($classes[$cn])) {
	
			require dirname(__FILE__) . \'/../\' . $classes[$cn];
		}
	},
	true,
	false
);
// @codeCoverageIgnoreEnd');
fclose($file);
