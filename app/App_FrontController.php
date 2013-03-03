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
		
		$this->initLibs ();
		$this->initModels ();
		$this->initView ();
	}
	
	private function initLibs () {
		include (LIB_PATH . '/lib_links.php');
		include (LIB_PATH . '/lib_shaarli.php');
	}
	
	private function initModels () {
		include (APP_PATH . '/models/Link.php');
	}
	
	private function initView () {
		View::appendStyle (Url::display ('/themes/default/base.css'));
	}
}
