<?php
error_reporting(0);
session_start();

/* Корневой каталог */
if (!defined('ROOT_PATH')) {
	define('ROOT_PATH', realpath(dirname(dirname(__FILE__))));
}

/* Каталог приложения */
if (!defined('APPLICATION_PATH')) {
	define('APPLICATION_PATH', ROOT_PATH . '/application');
}

/* Каталог библиотек ZEND */
if($_SERVER['HTTP_HOST'] == 'rekviem.org' || $_SERVER['HTTP_HOST'] == 'www.rekviem.org'){
	if (!defined('LIBRARY_PATH')) {
		if (file_exists(realpath(ROOT_PATH . '') . '/phpLibs')) {
			define('LIBRARY_PATH', realpath(ROOT_PATH . '' . '/phpLibs'));
		} else {
			define('LIBRARY_PATH', realpath(ROOT_PATH . '/library'));
		}
	}
} else {
	if (!defined('LIBRARY_PATH')) {
		if (file_exists(realpath(ROOT_PATH . '/../..') . '/phpLibs')) {
			define('LIBRARY_PATH', realpath(ROOT_PATH . '/../..' . '/phpLibs'));
		} else {
			define('LIBRARY_PATH', realpath(ROOT_PATH . '/library'));
		}
	}
}

/* Каталог публично доступных файлов */
if (!defined('PUBLIC_PATH')) {
	define('PUBLIC_PATH', ROOT_PATH . '/http');
}

/* Установка среды */
if (!defined('APPLICATION_ENV')) {
    define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
}

// Подключение файла настроек
require_once APPLICATION_PATH . '/configs/config.php';

//Установка в include_path папки библиотек
set_include_path(implode(PATH_SEPARATOR, array(
    LIBRARY_PATH,
    get_include_path(), 
    APPLICATION_PATH . '/../http/classes',
APPLICATION_PATH . '/../public/classes'
)));


include('my_helpers.php');
include('renamer.php');
include('SimpleImage.php');

/** Подключение Zend_Application */
require_once 'Zend/Application.php';

// Создание обьекта приложения и запуск
$application = new Zend_Application(
    APPLICATION_ENV,
    $config
);
$application->bootstrap()->run();