<?php
  
class indexController extends ActionController {
	public function indexAction () {
		$linkDAO = new LinkDAO ();
		$this->view->links = array_reverse ($linkDAO->listLinks ());
	}
}
