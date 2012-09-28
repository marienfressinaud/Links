<?php

function search_tags ($desc) {
	$tags = array ();
	$pos_tag = 0;
	$pos_fin_tag = 0;
	
	do {
		$pos_tag = strpos ($desc, '#', $pos_fin_tag);
		
		if ($pos_tag !== false) {
			$pos_fin_tag = strpos ($desc, ' ', $pos_tag);
			
			if ($pos_fin_tag === false) {
				$tags[] = substr ($desc, $pos_tag + 1);
			} else {
				$tags[] = substr ($desc, $pos_tag + 1, $pos_fin_tag - $pos_tag - 1);
			}
		}
	} while ($pos_fin_tag !== false && $pos_tag !== false);
	
	return $tags;
}

function parse_args ($args) {
	$url = false;
	$desc = '';
	$tags = array ();
	
	if ($args !== false && substr ($args, 0, 4) == 'http') {
		$pos_fin_url = strpos ($args, ' ');
		if ($pos_fin_url !== false) {
			$url = substr ($args, 0, $pos_fin_url);
			
			$args = trim (substr ($args, $pos_fin_url));
			
			if ($args[strlen ($args) - 1] == '-') {
				$private = true;
				$args = trim (substr ($args, 0, -1));
			} else {
				$private = false;
			}
		
			$desc = $args;
			
			$tags = search_tags ($desc);
		} else {
			$url = $args;
		}
	}

	return array ($url, $desc, $tags, $private);
}
