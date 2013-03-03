<?php
  
class configurationController extends ActionController {
	public function shaarliAction () {
		if (Request::isPost ()) {
			if ($_FILES['file']['error'] == 0) {
			  	$linkDAO = new LinkDAO ();
			  	
				$content = file_get_contents ($_FILES['file']['tmp_name']);
				$links = unserialize (gzinflate (base64_decode (substr ($content, strlen (PHPPREFIX), -strlen (PHPSUFFIX)))));
				
				foreach ($links as $link) {
					$tags = explode (' ', trim ($link['tags']));
					$tags_desc = search_tags ($link['description']);
					
					foreach ($tags as $key => $tag) {
						if (!in_array ($tag, $tags_desc) && $tag) {
							$link['description'] .= ' #' . $tag;
						} elseif (!$tag) {
							unset ($tags[$key]);
						}
					}
					
					$link['tags'] = $tags;
					$link['lastUpdate'] = linkdate2timestamp ($link['linkdate']);
					
					$linkDAO->addLink ($link);
				}
				
				Request::forward (array (), true);
			} else {
				// TODO error
			}
		}
	}
	
	public function exportAction () {
		$linkDAO = new LinkDAO ();
		$links_tmp = $linkDAO->listLinks (0);
		
		$links = array ();
		foreach ($links_tmp as $key => $link) {
			$id = $link->id ();
			$links[$id] = array ();
			$links[$id]['title'] = $link->title ();
			$links[$id]['url'] = $link->url ();
			$links[$id]['description'] = $link->description ();
			$links[$id]['private'] = $link->priv ();
			$links[$id]['linkdate'] = $link->date ();
			$links[$id]['tags'] = trim (implode (' ', $link->tags ()));
		}
		
		$this->view->_useLayout (false);
		
		header ('Content-type: application/x-php');
		echo PHPPREFIX . base64_encode (gzdeflate (serialize ($links))) . PHPSUFFIX;
	}

	public function apiAction () {

	}
}
