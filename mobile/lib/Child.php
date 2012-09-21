<?php

require_once dirname(__FILE__) . '/Database.php';

class Child {
	public static function findAllByCategory($category) {
		$query =
			"SELECT * FROM child_table " .
			"LEFT JOIN child_thumbnail ON child_table.child_id = child_thumbnail.id " .
			"WHERE child_table.child_category = '%s' " .
			"ORDER BY child_name";
		$childrenData = Database::toArray(Database::query($query, $category));
		Database::close();

		$result = array();
		foreach ($childrenData as $childData) {
			array_push($result, new Child($childData));
		}
		return $result;
	}

	public static function findById($id) {
		$childQuery =
			"SELECT * FROM child_table " .
			"LEFT JOIN photographer_table ON child_table.child_photographer = photographer_table.photographer_id " .
			"WHERE child_id = '%s'";
		$mediaQuery = "SELECT * from media_table WHERE child_id = '%s'";
		$childData = Database::toResult(Database::query($childQuery, $id));
		$mediaData = Database::toArray(Database::query($mediaQuery, $id));
		Database::close();
		return new Child($childData, $mediaData);
	}

	public $id;
	public $name;
	public $gender;
	public $biography;
	public $image;
	public $age;
	public $thumbnail;
	public $photographerName;
	public $photographerLink;
	public $images;
	public $audios;
	public $videos;

	function __construct($childData, $mediaData = array()) {
		$this->id = $childData['child_id'];
		$this->name = $childData['child_name'];
		$this->gender = $childData['child_gender'];
		$this->biography = $childData['child_bio'];
		$this->image = $childData['child_image'];

		if (isset($childData['child_birthday']) && $childData['child_birthday'] != '0000-00-00') {
			$this->age = self::birthdayToAge($childData['child_birthday']);
		}

		if (isset($childData['thumbnail'])) {
			$this->thumbnail = $childData['thumbnail'];
		}
		if (isset($childData['photographer_name'])) {
			$this->photographerName = $childData['photographer_name'];
		}
		if (isset($childData['photographer_link'])) {
			$this->photographerLink = $childData['photographer_link'];
		}

		$this->images = self::filterMedia($mediaData, '0');
		$this->audios = self::filterMedia($mediaData, '1');
		$this->videos = self::filterMedia($mediaData, '2');
	}

	private static function birthdayToAge($birthday) {
		$years = date('Y') - date('Y', strtotime($birthday));
		$passed = date('m') - date('m', strtotime($birthday)) >= 0;
		return $passed ? $years : $years - 1;
	}

	private static function filterMedia($mediaArray, $type) {
		$result = array();
		foreach ($mediaArray as $media) {
			if ($media['media_type'] == $type) {
				array_push($result, new Media($media));
			}
		}
		return $result;
	}
}
