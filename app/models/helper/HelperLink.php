<?php

class HelperLink {
	public static function daoToLink ($dao) {
		$liste = self::listeDaoToLink (array ($dao));

		return $liste[0];
	}

	public static function listeDaoToLink ($listeDAO) {
		$liste = array ();

		if (!is_array ($listeDAO)) {
			$listeDAO = array ($listeDAO);
		}

		foreach ($listeDAO as $key => $dao) {
			$liste[$key] = new Link ();
			$liste[$key]->_id ($key);
			$liste[$key]->_title ($dao['title']);
			$liste[$key]->_url ($dao['url']);
			$liste[$key]->_description ($dao['description']);
			$liste[$key]->_private ($dao['private']);
			$liste[$key]->_date ($dao['linkdate']);
			$liste[$key]->_tags ($dao['tags']);
		}

		return $liste;
	}
}
