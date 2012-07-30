<?php

include_once ('helper/HelperLink.php');
include_once ('dao/LinkDAO.array.php');

class Link extends Model {
	private $id;
	private $title;
	private $url;
	private $description;
	private $private;
	private $linkdate;
	private $tags;
	
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
	public function priv () {
		return $this->private;
	}
	public function date () {
		return $this->linkdate;
	}
	public function tags () {
		return $this->tags;
	}
	
	public function _id ($id) {
		$this->id = $id;
	}
	public function _title ($value) {
		$this->title = $value;
	}
	public function _url ($value) {
		$this->url = $value;
	}
	public function _description ($value) {
		$this->description = $value;
	}
	public function _private ($value) {
		$this->private = $value;
	}
	public function _date ($value) {
		$this->linkdate = $value;
	}
	public function _tags ($value) {
		$this->tags = $value;
	}
}
