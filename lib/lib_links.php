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
	$url = '';
	$desc = '';
	$tags = array ();
	$private = true;
	
	if ($args && substr ($args, 0, 4) == 'http') {
		$pos_fin_url = strpos ($args, ' ');
		if ($pos_fin_url !== false) {
			$url = substr ($args, 0, $pos_fin_url);
			
			$args = trim (substr ($args, $pos_fin_url));
			
			if ($args[strlen ($args) - 1] == '-') {
				$args = trim (substr ($args, 0, -1));
			} else {
				$private = false;
			}
		
			$desc = $args;
			
			$tags = search_tags ($desc);
		} else {
			$url = $args;
		}
	} elseif ($args) {
		$args = trim ($args);
		if ($args[strlen ($args) - 1] == '-') {
			$args = trim (substr ($args, 0, -1));
		} else {
			$private = false;
		}
	
		$desc = $args;
		
		$tags = search_tags ($desc);
	}

	return array ($url, $desc, $tags, $private);
}

# Transform URL and e-mails into links
function makeLinks($string) {
	$string = preg_replace_callback('/\s?(http|https|ftp):(\/\/){0,1}([^\"\s]*)/i','splitUri',$string);
	return $string;
}

# Split links, require for makeLinks
function splitUri($matches) {
	$uri = $matches[1].':'.$matches[2].$matches[3];
	$t = parse_url($uri);
	$link = $matches[3];

	if (!empty($t['scheme'])) {
		return ' <a href="'.$uri.'">'.$link.'</a>';
	} else {
		return $uri;
	}
}

// parse la description pour ajouter les liens sur les tags
function parse_tags ($desc) {
	$desc_parse = preg_replace ('/#([\w\d]+)/i', '<a class="linktag" href="?addtag=\\1">\\1</a>', $desc);

	return $desc_parse;
}
