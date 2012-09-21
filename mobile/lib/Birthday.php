<?php

class Birthday {
	public static function extractYear($birthday) {
		$parts = explode('-', $birthday);
		return $parts[0];
	}

	public static function extractMonth($birthday) {
		$parts = explode('-', $birthday);
		return $parts[1];
	}

	public static function selectedMonthList($birthday) {
		$targetMonth = self::extractMonth($birthday);
		$months = array(
			'Select Month'	=> '',
			'January'				=> '01',
			'February'			=> '02',
			'March'					=> '03',
			'April'					=> '04',
			'May'						=> '05',
			'June'					=> '06',
			'July'					=> '07',
			'August'				=> '08',
			'September'			=> '09',
			'October'				=> '10',
			'November'			=> '11',
			'December'			=> '12'
		);
		$options = array();
		foreach ($months as $monthName => $monthValue) {
			$selected = ($monthValue == $targetMonth) ? 'selected' : '';
			array_push($options, "<option value=\"$monthValue\" $selected>$monthName</option>");
		}
		return implode($options);
	}
}













