<?php

class Link extends Model {
	private $id;
	private $title;
	private $url;
	private $description;
	private $linkdate;
	private $lastUpdate;
	private $tags;
	private $private;
	
	public function __construct ($url, $desc, $tags, $private = 0) {
		$this->_url ($url);
		$this->_description ($desc);
		$this->_tags ($tags);
		$this->_private ($private);
	}
	
	public function id () {
		return $this->id;
	}
	public function title () {
		return $this->title;
	}
	public function url () {
		return $this->url;
	}
	public function description () {
		return $this->description;
	}
	public function date ($format = false) {
		if ($format) {
			return date ('d/m/Y', linkdate2timestamp ($this->linkdate));
		} else {
			return $this->linkdate;
		}
	}
	public function lastUpdate () {
		return $this->lastUpdate;
	}
	public function tags () {
		return $this->tags;
	}
	public function priv () {
		return $this->private;
	}
	
	public function _id ($id) {
		$this->id = $id;
	}
	public function _title ($value) {
		if (empty ($value)) {
			$value = $this->url;
		}
		if (empty ($value)) {
			$value = $this->description;
		}
		
		$this->title = $value;
	}
	public function _url ($value) {
		$this->url = $value;
	}
	public function _description ($value) {
		$this->description = $value;
	}
	public function _date ($value) {
		$this->linkdate = $value;
	}
	public function _lastUpdate ($value) {
		if (is_int (intval ($value)) && $value) {
			$this->lastUpdate = $value;
		} else {
			$this->lastUpdate = linkdate2timestamp ($this->date ());
		}
	}
	public function _tags ($value) {
		if (!is_array ($value)) {
			$value = array ($value);
		}
		
		$this->tags = $value;
	}
	public function _private ($private) {
		$this->private = $private;
	}
	
	public function loadTitle () {
		$title = $this->url;
		
		if (!empty ($this->url)) {
			list ($http_status, $headers, $data) = getHTTP ($this->url, 4);
		
			if (!empty ($data)) {
				$title = html_entity_decode (html_extract_title($data), ENT_QUOTES, 'UTF-8');
			}
		}
		
		$this->_title ($title);
	}
	
	public function toArray () {
		return array (
			'url' => $this->url (),
			'description' => $this->description (),
			'tags' => $this->tags (),
			'title' => $this->title (),
			'linkdate' => $this->date (),
			'lastUpdate' => $this->lastUpdate (),
			'private' => $this->priv ()
		);
	}
}

class LinkDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/links');
	}
	
	public function addLink ($values) {
		$id = $values['linkdate'];
		$this->array[$id] = array ();
		
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile ($this->array);
	}
	
	public function updateLink ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile ($this->array);
	}
	
	public function deleteLink ($id) {
		unset ($this->array[$id]);
		$this->writeFile ($this->array);
	}
	
	/*
	 * $mode = 0 => tous
	 * $mode = 1 => publics seulement
	 * $mode = 2 => privés seulement
	 */
	public function listLinks ($mode = 0) {
		$list = $this->array;
		$links = array ();
		
		if (!is_array ($list)) {
			$list = array ();
		}
		
		if ($mode == 2) {
			foreach ($list as $key => $link) {
				if ($link['private']) {
					$links[$key] = $link;
				}
			}
		} elseif ($mode == 1) {
			foreach ($list as $key => $link) {
				if (!$link['private']) {
					$links[$key] = $link;
				}
			}
		} elseif ($mode == 0) {
			$links = $list;
		}
		
		return HelperLink::daoToLink ($links);
	}
	
	public function searchById ($id) {
		$links = HelperLink::daoToLink ($this->array);
		return $links[$id];
	}
}

class HelperLink {
	public static function daoToLink ($listeDAO) {
		$liste = array ();

		if (!is_array ($listeDAO)) {
			$listeDAO = array ($listeDAO);
		}

		foreach ($listeDAO as $key => $dao) {
			$liste[$key] = new Link ($dao['url'], $dao['description'], $dao['tags']);
			$liste[$key]->_id ($key);
			$liste[$key]->_title ($dao['title']);
			$liste[$key]->_date ($dao['linkdate']);
			$liste[$key]->_lastUpdate ($dao['lastUpdate']);
			$liste[$key]->_private ($dao['private']);
		}

		return $liste;
	}
}
