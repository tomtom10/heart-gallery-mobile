<?php

class Category {
  private static $idMapping = array(
    'individual' => 1,
    'sibling' => 2,
    'success' => 3);

  private static $titleMapping = array(
    'individual' => 'Individual Children',
    'sibling' => 'Sibling Groups',
    'success' => 'Our Success Stories');

  public static function toId($name) {
    return self::$idMapping[$name];
  }

  public static function toTitle($name) {
    return self::$titleMapping[$name];
  }
}
