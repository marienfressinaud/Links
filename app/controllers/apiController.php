<?php
  
class apiController extends ActionController {
	public function addAction () {
		$this->view->_useLayout (false);
		
		$link = json_decode (Request::param ('link'), true);
		Request::_param ('url', $link);
		
		Request::forward (array ('c' => 'link', 'a' => 'add'));
	}
}
