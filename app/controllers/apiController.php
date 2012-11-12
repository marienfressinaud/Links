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
			$mode = 1;
		} else {
			$mode = 0;
		}
		
		$linkDAO = new LinkDAO ();
		$links_tmp = array_reverse ($linkDAO->listLinks ($mode));
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
		} elseif ($format == 'uniflux') {
			foreach ($links_tmp as $link) {
				$id = $link->id ();
				$links[$id] = array ();
				$links[$id]['title'] = $link->title ();
				$links[$id]['content'] = $link->description ();
				$links[$id]['date'] = linkdate2timestamp ($link->date ());
				$links[$id]['lastUpdate'] = $link->lastUpdate ();
				$links[$id]['tags'] = $link->tags ();
				
				$url = $link->url ();
				if (!empty ($url)) {
					$links[$id]['url'] = $url;
					$links[$id]['type'] = 'url';
				} else {
					$links[$id]['type'] = 'status';
				}
			}
		}
		
		$this->view->links = $links;
	}
}
