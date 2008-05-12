<?php
/*
Part of Plugin: Ozh & COLOURlovers Admin CSS Designer
File that loads a palette from COLOURlovers.com
*/


// Main func: get a palette from COLOURlovers weeeeeeeeeeeeee
function ozh_cl_get_random_palette($id = 0, $save = true) {

	$id = ($id == 0) ? 'palettes/random' : 'palette/'.strval($id) ;
	
	$url = 'http://www.colourlovers.com/api/'.$id;
	
	// Use Snoopy to fetch page
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-includes/class-snoopy.php');
	if (!class_exists(snoopy)) {
		return ozh_cl_fallback_random('Class Snoopy not found');
	}
	$client = new Snoopy();
	$client->agent = 'http://planetozh.com/';
	$client->read_timeout = $client->_fp_timeout = 5;
	if (@$client->fetch($url) === false) {
		return ozh_cl_fallback_random('Could not contact site, maybe down');
	}
	// Did we get XML as expected?
	if (!$client->headers or strpos(join(' ',$client->headers), 'Content-Type: text/xml;')  === false)
		return ozh_cl_fallback_random('Unexpected result. Host maybe down?');
		
	// Process XML
	$xml = ($client->results);
	require_once(dirname(__FILE__).'/xmlparser.php');
	$xml = new XMLParser($xml,'raw');
	$xml = @$xml->getTree();
	
	$xml = ozh_cl_flatten_array($xml['palettes'][0]['palette'][0]);
	$xml['colors'] = ozh_cl_flatten_array_colors($xml['colors'][0]['hex']);
	/* Now we have something like:
		$xml = Array (
		[title] => "Coffee 'n Cakes",
		[username] => "spiralstairs",
		[numviews] => 191,
		[numvotes] => 0,
		[numcomments] => 7,
		[numhearts] => 0,
		[rank] => 35474,
		[datecreated] => "2007-11-10 13:56:47",
		[colors] => Array (
				[0] => "#DF928C",
				[1] => "#F5F7C4",
				[2] => "#E2D6AF",
				[3] => "#BDB885",
				[4] => "#4E3A0F",
			),
		[description] => "Coffee, chocolate, cakes and cookies",
		[url] => "http://www.colourlovers.com/palette/203023/Coffee_n_Cakes",
		[imageurl] => "http://www.colourlovers.com/paletteImg/DF928C/F5F7C4/E2D6AF/BDB885/4E3A0F/Coffee_n_Cakes.png",
		[apiurl] => "http://www.colourlovers.com/api/palette/203023"
		);
	*/
	
	// Fix things if needed (missing colors or no colors maybe?)
	$xml = ozh_cl_fallback_random('', $xml);
	
	if ($save === false)
		return $xml;

	if (ozh_cl_cache($xml)) {
		return $xml;
	} else {
		return ozh_cl_fallback_random('Could not write in directory to cache results (but this is still a real palette from COLOURlovers.com)', $xml);
	}
}

// Return a random color. Neato! From http://www.php.net/manual/en/function.dechex.php#39634
function ozh_cl_rndcolor() {
	return '#' . substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
}

// Fix palette inconsistencies (missing colors, no colors, or nothing at all)
function ozh_cl_fallback_random($msg='', $xml = array() ) {
	$xml = (array)$xml;
	if ((!$xml['colors']) or (count($xml['colors']) == 1 && $xml['colors'][0] = '#' ) ) {
		// either no XML or a dead palette
		$xml['colors'] = NULL;
		$msg .= ' (Palette not found. Random colors generated...)';
	} else {		
		// Some checks for incomplete palettes
		if(!($xml['colors'][1])) $xml['colors'][1] = $xml['colors'][0];
		if(!($xml['colors'][2])) $xml['colors'][2] = $xml['colors'][1];
		if(!($xml['colors'][3])) $xml['colors'][3] = $xml['colors'][0];
		if(!($xml['colors'][4])) $xml['colors'][4] = $xml['colors'][1];
	}
	
	$fixed = Array (
	'title' => "Ooops... Error :/",
	'username' => "Ozh",
	'numviews' => -1,
	'numvotes' => -1,
	'numcomments' => -1,
	'numhearts' => -1,
	'rank' => -1,
	'datecreated' => "1972-03-23 07:10:00",
	'colors' => array(ozh_cl_rndcolor(), ozh_cl_rndcolor(), ozh_cl_rndcolor(), ozh_cl_rndcolor(), ozh_cl_rndcolor()),
	'url' => "http://planetozh.com/",
	'imageurl' => "#",
	'apiurl' => "#",
	'description' => $msg
	);
	
	$didfix = false;
	foreach ($fixed as $k=>$v) {
		if ($xml[$k] == NULL && $k != 'description') {
			$xml[$k] = $fixed[$k];
			$didfix = true;
		}
	}
	if ($didfix)
		$xml['description'] = trim($xml['description'] . ' ' .$msg);

	return $xml;
}

function ozh_cl_cache($xml) {
	return (ozh_cl_cachewrite($xml, 'json') && ozh_cl_cachewrite($xml, 'desc'));
}

function ozh_cl_cachewrite($data, $type = 'json') {
	if ($type == 'json') {
		$data = ozh_cl_array2json($data);
	} else {
		$data['colors'] = join(',',$data['colors']);
		$content = '';
		foreach($data as $k=>$v) {
			$content .= "$k:$v\n";
		}
		$data = $content;
		unset($content);	
	}

	$dir = dirname(dirname(__FILE__)).'/cache';
	
	if (!is_dir($dir))
		@mkdir($dir , 0777);
		
	if (!is_writeable($dir))
		return false;
	
	if (!$handle = fopen($dir.'/palette.'.$type, 'w'))
		return false;
	
	if (fwrite($handle, $data) === FALSE)
		return false;
	
	fclose($handle);
	return true;
}

// Function from: http://www.bin-co.com/php/scripts/array2json/
function ozh_cl_array2json($arr) {
	$parts = array();
	$is_list = false;

	//Find out if the given array is a numerical array
	$keys = array_keys($arr);
	$max_length = count($arr)-1;
	if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
		$is_list = true;
		for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
			if($i != $keys[$i]) { //A key fails at position check.
				$is_list = false; //It is an associative array.
				break;
			}
		}
	}

	foreach($arr as $key=>$value) {
		if(is_array($value)) { //Custom handling for arrays
			if($is_list) $parts[] = ozh_cl_array2json($value); /* :RECURSION: */
			else $parts[] = '"' . $key . '":' . ozh_cl_array2json($value); /* :RECURSION: */
		} else {
			$str = '';
			if(!$is_list) $str = '"' . $key . '":';

			//Custom handling for multiple data types
			if(is_numeric($value)) $str .= $value; //Numbers
			elseif($value === false) $str .= 'false'; //The booleans
			elseif($value === true) $str .= 'true';
			else $str .= '"' . addslashes($value) . '"'; //All other things
			// :TODO: Is there any more datatype we should be in the lookout for? (Object?)

			$parts[] = $str;
		}
	}
	$json = implode(',',$parts);
	
	if($is_list) return '[' . $json . ']';//Return numerical JSON
	return '{' . $json . '}';//Return associative JSON
} 



function ozh_cl_flatten_array($xml) {
	foreach($xml as $k=>$v) {
		if (array_key_exists('VALUE', $v[0]))
			$xml[$k] = $v[0]['VALUE'];
	}
	return $xml;
}

function ozh_cl_flatten_array_colors($xml) {
	foreach($xml as $k=>$v) {
		$xml[$k] = '#'.$v['VALUE'];
	}
	return $xml;
}

/* Debugging: *
$palette = ozh_cl_get_random_palette(29535); // missing: 29535; incomplete: 125480, complete but with some 0: 96764
echo "<pre>";var_dump($palette);
/**/
?>