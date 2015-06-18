<?php 
ini_set('memory_limit','800M');
set_time_limit(0);
function get_files($dir) {
	global $result;
	$files = scandir($dir);
	foreach($files as $key=>$value) {
		if($value!='.' && $value!='..') {
			if(is_dir($dir.'/'.$value)) {
				get_files($dir.'/'.$value);
			} else {
				$result[] = $dir.'/'.$value;
			}
		}		
	}
	return $result;
}

$files = get_files('application');

$search = 'REPLACE WITH STRING TO FIND';
foreach($files as $key=>$value) {
	$contents = file_get_contents($value);
	if(strpos($contents, $search) !== false) {
		$lines = file($value);
		$found=array();
		$found['file_name'] = $value;
		foreach($lines as $l_no=>$l) {
			if(strpos($l, $search) !== false) {
				$found[$l_no] = $l;
			}
		}
		$matches[] = $found;
	}	
}
echo '<pre>';
print_r($matches);
print_r($files);
echo '<pre>';
?>
