<?php
  
class indexController extends ActionController {
	public function indexAction () {
		$linkDAO = new LinkDAO ();
		$this->view->links = array_reverse ($linkDAO->listLinks ());
		
		// edit
		$id = Session::param ('id');
		if ($id !== false) {
			$linkDAO = new LinkDAO ();
			$this->view->link = $linkDAO->searchById ($id);
			Session::_param ('id');
		}
	}
	
	public function configurationAction () {
		if (Request::isPost ()) {
			if ($_FILES['file']['error'] == 0
			 && ($_FILES['file']['type'] == 'application/x-php'
			  || $_FILES['file']['type'] == 'plain/txt')) {
			  	$linkDAO = new LinkDAO ();
			  	
				$content = file_get_contents ($_FILES['file']['tmp_name']);
				$links = unserialize (gzinflate (base64_decode (substr ($content, strlen (PHPPREFIX), -strlen (PHPSUFFIX)))));
				
				foreach ($links as $link) {
					$tags = explode (' ', $link['tags']);
					$link['tags'] = $tags;
					
					foreach ($tags as $tag) {
						$link['description'] .= ' #' . $tag;
					}
					
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
		$links = $linkDAO->listLinks ();
		
		$this->view->_useLayout (false);
		
		header('Content-type: application/x-php');
		echo PHPPREFIX . base64_encode (gzdeflate (serialize ($links))) . PHPSUFFIX;
	}
}
