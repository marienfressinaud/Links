<?php
  
class indexController extends ActionController {
	public function indexAction () {
		$linkDAO = new LinkDAO ();
		$links = array_reverse ($linkDAO->listLinks ());
		
		//gestion pagination
		try {
			$page = Request::param ('page', 1);
			$this->view->linksPaginator = new Paginator ($links);
			$this->view->linksPaginator->_nbItemsPerPage (20);
			$this->view->linksPaginator->_currentPage ($page);
		} catch (CurrentPagePaginationException $e) {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		}
		
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
			if ($_FILES['file']['error'] == 0) {
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
