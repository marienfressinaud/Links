<?php
  
class indexController extends ActionController {
	public function indexAction () {
		$mode = Request::param ('mode', Session::param('mode', 'public'));
		Session::_param('mode', $mode);
		
		$linkDAO = new LinkDAO ();
		if ($mode == 'private') {
			$links = $linkDAO->listLinks (2);
		} else {
			$links = $linkDAO->listLinks (1);
		}
		$links = array_reverse ($links);
		
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
}
