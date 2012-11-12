<?php
  
class linkController extends ActionController {
	public function addAction () {
		if (Request::isPost ()) {
			list ($url, $desc, $tags, $private) = parse_args (htmlspecialchars (Request::param ('url')));
			
			if ($url !== false) {
				$linkDAO = new LinkDAO ();
				$link = new Link ($url, $desc, $tags, $private);
				$link->loadTitle ();
			
				$values = array (
					'url' => $link->url (),
					'title' => $link->title (),
					'description' => $link->description (),
					'linkdate' => date ('Ymd_His', time ()),
					'lastUpdate' => time (),
					'tags' => $link->tags (),
					'private' => $link->priv ()
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
				$private = Request::param ('private');
				if ($private !== false) {
					$private = true;
				} else {
					$private = false;
				}
				
				$values = array (
					'url' => $url,
					'title' => $title,
					'description' => $desc,
					'tags' => $tags,
					'private' => $private,
					'lastUpdate' => time ()
				);
				
				$upDate = Request::param ('upDate');
				if ($upDate !== false) {
					$values['linkdate'] = date ('Ymd_His', time ());
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
	
	public function deleteAction () {
		$id = Request::param ('id');
		
		if ($id !== false) {
			$linkDAO = new LinkDAO ();
			$linkDAO->deleteLink ($id);
		}
		
		Request::forward (array (), true);
	}
}
