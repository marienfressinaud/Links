<?php
  
class linkController extends ActionController {
	public function addAction () {
		//if (Request::isPost ()) {
			$url = htmlspecialchars (Request::param ('url', ''));
			$title = htmlspecialchars (Request::param ('title', '')); // TODO supprimer valeur par défaut
			$desc = htmlspecialchars (Request::param ('description', ''));
			$tags = htmlspecialchars (Request::param ('tags', ''));
			$private = Request::param ('private');
			
			if ($title !== false) {
				$linkDAO = new LinkDAO ();
				
				if ($private === false) {
					$private = 0;
				} else {
					$private = 1;
				}
			
				$values = array (
					'url' => $url,
					'title' => $title,
					'description' => $desc,
					'private' => $private,
					'linkdate' => time (),
					'tags' => $tags
				);
			
				$linkDAO->addLink ($values);
				
				$_POST = array ();
				Request::forward ();
			} else {
				$this->view->retour = Translate::t ('title required');
			}
		//}
	}
}
