<?php

class Media {
	public $name;
	public $caption;

	function __construct($mediaData) {
		$this->name = $mediaData['media_name'];
		$this->caption = $mediaData['media_caption'];
	}
}
