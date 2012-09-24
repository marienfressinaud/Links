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
		
			$desc = trim (substr ($args, $pos_fin_url));
			
			$tags = search_tags ($desc);
		} else {
			$url = $args;
		}
	}

	return array ($url, $desc, $tags);
}
  
class linkController extends ActionController {
	public function addAction () {
		if (Request::isPost ()) {
			list ($url, $desc, $tags) = parse_args (htmlspecialchars (Request::param ('url')));
			
			if ($url !== false) {
				$linkDAO = new LinkDAO ();
				$link = new Link ($url, $desc, $tags);
				$link->loadTitle ();
			
				$values = array (
					'url' => $link->url (),
					'title' => $link->title (),
					'description' => $link->description (),
					'linkdate' => time (),
					'tags' => $link->tags ()
				);
			
				$linkDAO->addLink ($values);
			}
			
			Request::forward (array (), true);
		}
	}
	
	public function updateAction () {
		$id = Request::param ('id');
		
		if ($id !== false) {
			if (!Request::isPost ()) {
				Session::_param ('id', $id);
			} else {
				$linkDAO = new LinkDAO ();
				
				$url = htmlspecialchars (Request::param ('url'));
				$title = htmlspecialchars (Request::param ('title'));
				$desc = htmlspecialchars (Request::param ('desc'));
				$tags = search_tags ($desc);
				
				$values = array (
					'url' => $url,
					'title' => $title,
					'description' => $desc,
					'tags' => $tags
				);
				
				$upDate = Request::param ('upDate');
				if ($upDate !== false) {
					$values['linkdate'] = time ();
				}
				
				$linkDAO->updateLink ($id, $values);
			}
			
			Request::forward (array (), true);
		} else {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		}
	}
}
