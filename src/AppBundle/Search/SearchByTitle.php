<?php

namespace AppBundle\Search;

class SearchByTitle {
	
	private $title;
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
}
