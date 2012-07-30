<?php
/** 
 * MINZ - Copyright 2011 Marien Fressinaud
 * Sous licence AGPL3 <http://www.gnu.org/licenses/>
*/
require ('FrontController.php');

class App_FrontController extends FrontController {
	public function init () {
		Session::init ();
		Translate::init ();
		
		$this->initModels ();
		$this->initView ();
	}
	
	private function initModels () {
		include (APP_PATH . '/../lib/Model_array.php');
		include (APP_PATH . '/models/Link.php');
	}
	
	private function initView () {
		View::appendStyle (Url::display ('/themes/default/base.css'));
		View::appendScript (Url::display ('/scripts/jquery.js'));
	}
}
