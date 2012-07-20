<?php

class Menu_IndexController extends Zend_Controller_Action
{
    private $model;
   // private $img;
    private $help;
    
	public function init()
    {
        $this->model = new Menu_Model_Frontend();
		$this->abstractModel = new Application_Model_Abstract();
       // $this->img = new img();
        $this->help = $this->model->help;
    }
    
    public function checkCurrent($position)
    {
    	$url = $_SERVER['REQUEST_URI'];
    	$url = trim($url, '/');
    	$url = parse_url($url);
    	$url = $url['path'];
    	//$this->help->arrayTrans($url);
    }
    
    public function indexAction()
    {
        $result = $this->model->ReturnMenuItems('main');
         	
        //$this->help->arrayTrans($result);
		$this->view->menu_result = $result;
	} 
	
}