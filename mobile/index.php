<?php

require_once dirname(__FILE__) . '/vendor/Slim/Slim.php';
require_once dirname(__FILE__) . '/vendor/SlimExtras/TwigView.php';
require_once dirname(__FILE__) . '/lib/Category.php';
require_once dirname(__FILE__) . '/lib/Child.php';
require_once dirname(__FILE__) . '/lib/Media.php';

$app = new Slim();
TwigView::$twigDirectory = dirname(__FILE__) . '/vendor/Twig';
$app->config('templates.path', dirname(__FILE__) . '/templates');
$app->view('TwigView');

$app->get('/mobile/', 'homePage');
function homePage() {
  $app = Slim::getInstance();
  return $app->render('home.html');
};

$app->get('/mobile/children/:category', 'listPage');
function listPage($category) {
  $app = Slim::getInstance();
  $subtitle = Category::toTitle($category);
  $children = Child::findAllByCategory(Category::toId($category));
  return $app->render('list.html', array(
    'children' => $children,
    'subtitle' => $subtitle,
    'category' => $category
  ));
}

$app->get('/mobile/children/details/:id', 'detailPage');
function detailPage($id) {
  $app = Slim::getInstance();
  $child = Child::findById($id);
  return $app->render('detail.html', array('child' => $child));
}

$app->get('/mobile/fullsite', 'fullSite');
function fullSite() {
  $app = Slim::getInstance();
  $app->setCookie('viewDesktopSite', true);
  $app->redirect('/');
}

$app->run();
