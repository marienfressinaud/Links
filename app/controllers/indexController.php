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
}
