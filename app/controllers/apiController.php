<?php
  
class apiController extends ActionController {
	public function addAction () {
		$this->view->_useLayout (false);
		
		$link = json_decode (Request::param ('link'), true);
		Request::_param ('url', $link);
		
		Request::forward (array ('c' => 'link', 'a' => 'add'));
	}
	
	public function getLinksAction () {
		$this->view->_useLayout (false);
		
		$type = htmlspecialchars (Request::param ('type'));
		if ($type == 'public') {
			$get_private = false;
		} else {
			$get_private = true;
		}
		
		$linkDAO = new LinkDAO ();
		$links_tmp = array_reverse ($linkDAO->listLinks ($get_private));
		$links = array ();
		
		$format = htmlspecialchars (Request::param ('format'));
		if ($format == 'shaarli') {
			foreach ($links_tmp as $link) {
				$id = $link->id ();
				$links[$id] = array ();
				$links[$id]['title'] = $link->title ();
				$links[$id]['url'] = $link->url ();
				$links[$id]['description'] = $link->description ();
				$links[$id]['private'] = $link->priv ();
				$links[$id]['linkdate'] = $link->date ();
				$links[$id]['tags'] = implode (' ', $link->tags ());
			}
		}
		
		$this->view->links = $links;
	}
}
