<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
    public function run()
    {
        try {
	    	$this->setConfig();	        
	    	$this->setLoader();	    	
	    	$this->setModules(); // merge config with modules config           
	    	$this->setView();
			$this->setPlugins();
	        $this->setDbAdapter();	    	
            $router = $this->setRouter();	    	
            $front = Zend_Controller_Front::getInstance();            
            $front->setRouter($router);            
            //$front->registerPlugin(new Ext_Controller_Plugin_ModuleBootstrap, 1);
            Zend_Registry::set('interface', $this->_options['interface']);
            
        } catch (Exception $e) {
        	echo $e->getMessage();
        }
        
    	parent::run();
    }
	
	public function setPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Custom_Controller_Plugin_IEStopper(array('ieversion' => 7)));
            
	}
	
    public function setConfig()
    {
        Zend_Registry::set('options', $this->_options);    	
    }
    
    /**
     * 
     */
	public function setLoader()
	{
		$autoLoader = Zend_Loader_Autoloader::getInstance();		
		$autoLoader->setFallbackAutoloader(true);
	}    
    
	/**
     * 
     */
	public function setView()
	{
	    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix('php3');
				
		$layout = Zend_Layout::getMvcInstance();
		$url = parse_url($_SERVER['REQUEST_URI']);
		$url = $url['path'];
		$url = trim($url, '/');
		$url = explode('/', $url);
		
		if($url[0] == 'admin'){
			$layout->setLayout('admin');
		} else {
			$layout->setLayout('layout');
		}
	}    

	public function setDbAdapter()
	{
		$db = Zend_Db::factory(new Zend_Config($this->_options['resources']['db']));
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
		$db->getConnection();
	}
	
	public function setRouter()
	{
	    $router = new Zend_Controller_Router_Rewrite();
	    
		/* Статический контент */
		$route = new Zend_Controller_Router_Route_Regex(
        	'([^.]+).html',
        	array(
	            'module' => 'content',
	    	   	'controller' => 'index',
	    	   	'action'     => 'static'
            )
        );
        $router->addRoute('static', $route);
        
        /*  Асинхронный обработчик обратной связи */
        $route = new Zend_Controller_Router_Route(
        	'feedback',
        	array(
        		'module' => 'default',
        	    'controller' => 'index',
        	    'action'     => 'feedback'
        	)
        );
        $router->addRoute('feedback', $route);
        
        /*  Акции список */
        $route = new Zend_Controller_Router_Route(
        	'akcii',
	        array(
				'module' => 'default',
	        	'controller' => 'index',
	        	'action'     => 'index'
	        )
        );
        $router->addRoute('akcii', $route);
        
        /*  Акции элемент */
        $route = new Zend_Controller_Router_Route(
        	'akcii/:id',
        	array(
        		'module' => 'default',
        	   	'controller' => 'index',
        	   	'action'     => 'index'
        	)
        );
        $router->addRoute('akcii_item', $route);
        
        /*  Список документов */
        $route = new Zend_Controller_Router_Route(
        	'documents',
        	array(
            	'module' => 'content',
              	'controller' => 'index',
               	'action'     => 'defaultcontentlist',
               	'alias' => 'documents'
        	)
        );
        $router->addRoute('documents', $route);
        
        /*  Просмотр документа */
        $route = new Zend_Controller_Router_Route(
        	'documents/:id',
        	array(
               	'module' => 'content',
               	'controller' => 'index',
               	'action'     => 'defaultcontentitem'
        	)
        );
        $router->addRoute('documentsItem', $route);
        
        /*  Список акций */
        $route = new Zend_Controller_Router_Route(
        	'akcii',
        	array(
               	'module' => 'content',
               	'controller' => 'index',
               	'action'     => 'defaultcontentlist',
               	'alias' => 'akcii'
        	)
        );
        $router->addRoute('akcii', $route);
        
        /*  Просмотр акции */
        $route = new Zend_Controller_Router_Route(
        	'akcii/:id',
        	array(
            	'module' => 'content',
            	'controller' => 'index',
                'action'     => 'defaultcontentitem'
        	)
        );
        $router->addRoute('akciiItem', $route);
        
        /*  Традиции и обряды главная */
        $route = new Zend_Controller_Router_Route(
        	'traditions',
       		array(
            	'module' => 'content',
                'controller' => 'index',
                'action'     => 'traditionslevel1list',
                'alias' => 'traditions'
        	)
        );
        $router->addRoute('traditions', $route);
        
        /*  Просмотр подкатегории традиций */
        $route = new Zend_Controller_Router_Route(
        	'traditions/:alias',
        	array(
            	'module' => 'content',
                'controller' => 'index',
                'action'     => 'traditionslevel2list',
                'parent'	=> 'traditions'	
        	)
        );
        $router->addRoute('traditions_subcat_list', $route);
        
        /*  Просмотр традиции в корневой категории */
        $route = new Zend_Controller_Router_Route(
        	'traditions/:id',
        	array(
            	'module' => 'content',
                'controller' => 'index',
                'action'     => 'defaultcontentitem'
        	),
        	array('id' => '\d+')
        );
        $router->addRoute('traditionsItem', $route);
        
        /*  Просмотр традиции в подкатегории */
        $route = new Zend_Controller_Router_Route(
        	'traditions/:subcat/:id',
        	array(
            	'module' => 'content',
                'controller' => 'index',
                'action'     => 'traditionslevel2item',
                'parent'	=> 'traditions'	
        	),
        	array('id' => '\d+')
        );
        $router->addRoute('traditionslevel2item', $route);
        
        /*  Главная страница каталога товаров */
        $route = new Zend_Controller_Router_Route(
        	'catalogue',
        	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'index'
        	)
        );
        $router->addRoute('shopindex', $route);
        
        /*  Список категорий второго уровня товаров */
        $route = new Zend_Controller_Router_Route(
        	'catalogue/:child',
        	array(
               	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'cataloguechild'
        	)
        );
        $router->addRoute('cataloguechild', $route);
        
        /*  Список категорий второго уровня товаров */
        $route = new Zend_Controller_Router_Route(
          	'catalogue/:child/:cat',
        	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'cataloguecat'
        	)
        );
        $router->addRoute('cataloguecat', $route);
        
        /*  Список товаров подкатегории */
        $route = new Zend_Controller_Router_Route(
        	'catalogue/:child/:cat/:subcat',
        	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'cataloguesubcat'
        	)
        );
        $router->addRoute('cataloguesubcat', $route);
        
        /*  Просмотр товара из категории */
        $route = new Zend_Controller_Router_Route(
        	'catalogue/:child/:cat/:id',
       	 	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'good'
        	), 
        	array('id' => '\d+')
        );
        $router->addRoute('goodcat', $route);
        
        /*  Просмотр товара из подкатегории */
        $route = new Zend_Controller_Router_Route(
        	'catalogue/:child/:cat/:subcat/:id',
        	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'good'
        	),
        	array('id' => '\d+')
        );
        $router->addRoute('goodsubcat', $route);
        
        /*  начальное заполнение категории товарами */
        $route = new Zend_Controller_Router_Route(
        	'migration',
        	array(
            	'module' => 'shop',
                'controller' => 'index',
                'action'     => 'migration'
        	)
        );
        $router->addRoute('migration', $route);
        
	    return $router;
	}
	
	public function setModules()
	{
	    //$modules = new Ext_Modules_Load();
    	//Zend_Registry::set('modules', $modules->getList());
	}
}

