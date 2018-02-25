<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_get('Asia/Shanghai');

// 目录设置和类装载
set_include_path('.' . PATH_SEPARATOR . '../library/' . PATH_SEPARATOR . '../application/models' .
    PATH_SEPARATOR . get_include_path());
include "Zend/Loader/AutoLoader.php";

Zend_Loader_AutoLoader::getInstance()->setFallbackAutoloader(true);

// load configuration
$config = new Zend_Config_Ini('../application/config.ini', 'general');
$registry = Zend_Registry::getInstance();
$registry->set('config', $config);

// setup database
$db = Zend_Db::factory($config->db);
Zend_Db_Table::setDefaultAdapter($db);

// 设置控制器
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->setControllerDirectory('../application/controllers');
$frontController->setBaseUrl('/zf-tutorial/public');
Zend_Layout::startMvc(array('layoutPath' => '../application/layouts'));
// run
$frontController->dispatch();
