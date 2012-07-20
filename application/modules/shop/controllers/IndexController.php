<?php

class Shop_IndexController extends Zend_Controller_Action
{
    private $model;
    private $help;
	private $sImage;

	public function init()
    {
        $this->model = new Shop_Model_Frontend();
        $this->sImage = new SimpleImage();
        $this->help = $this->model->abstractModel->help;
		$this->view->help = $this->help;
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		//$ajaxContext->addActionContext('orderparser', 'json');
		$ajaxContext->initContext('json');
    }
    
    public function indexAction()
    {
    	$tree = $this->model->getMergedTree();
    	//$this->help->arrayTrans($tree);
    	
    	$childs = array();
    	$exist = array();
    	
    	foreach ($tree as $item) {
    		if (empty($exist[$item['child_alias']])) {
    			$exist[$item['child_alias']] = 1;
    			
    			$childs[]  = array (
    			    "child_title" => $item['child_title'],
	    			"child_alias" => $item['child_alias'],
	    			"child_description" => $item['child_description'],
	    			"child_image" => $item['child_image'],
	    			"parent_title" => $item['parent_title'],
	    			"parent_alias" => $item['parent_alias']
    			);
    		}
    	}
    	
    	//$this->help->arrayTrans($childs);
    	$this->view->items = $childs;
    }
    
    public function cataloguechildAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	//$this->help->arrayTrans($params);
    	
    	$tree = $this->model->getMergedTree();
    	//$this->help->arrayTrans($tree);
    	$cats = array();
    	$exist = array();
    	
    	foreach ($tree as $item) {
    		if ($item['child_alias'] == $params['child'] && empty($exist[$item['cat_alias']])) {
    			$exist[$item['cat_alias']] = 1;
    			$cats[] = array (
    				"cat_title" => $item['cat_title'],
	    			"cat_alias" => $item['cat_alias'],
	    			"cat_image" => $item['cat_image'],
	    			"child_title" => $item['child_title'],
	    			"child_alias" => $item['child_alias'],
	    			"parent_title" => $item['parent_title'],
	    			"parent_alias" => $item['parent_alias']
    			);
    		}	    		
    	}
    	//$this->help->arrayTrans($cats);
    	$this->view->items = $cats;
    }
    
    public function cataloguecatAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	//$this->help->arrayTrans($params);
    	
    	$tree = $this->model->getMergedTree();
    	
    	$subcats = array();
    	$goods = array();
    	$exist = array();
    	
    	// Получение списка товаров в категории
    	foreach ($tree as $good) {
    		if(!isset($good['subcat_alias']) && $good['cat_alias'] == $params['cat']) {
    			$this->sImage->setImage($good['image']);
    			$this->sImage->setCompression(100);
    			$this->sImage->setCacheDirName('thumbs_150px');
    			$this->sImage->resizeToWidth(150);
    			$newImg = $this->sImage->save();
    			$this->sImage->setImage($good['image']);
    			$this->sImage->setCacheDirName('thumbs_600px');
    			$this->sImage->resizeToWidth(600);
    			$bigImg = $this->sImage->save();
    			
    			$goods[] = array(
    				"id" => $good['id'],
	    			"title" => $good['title'],
	    			"introtext" => $good['introtext'],
    				"fulltext" => $good['fulltext'],
    				"image" => $newImg,
    				"image_big" => $bigImg,
	    			"cat_title" => $good['cat_title'],
	    			"cat_alias" => $good['cat_alias'],
    				"cat_description" => $good['cat_description'],
	    			"child_title" => $good['child_title'],
	    			"child_alias" => $good['child_alias'],
	    			"parent_title" => $good['parent_title'],
	    			"parent_alias" => $good['parent_alias']
    			);
    		}
    	}
    	
    	// Получение списка подкатегорий
    	foreach ($tree as $subcat) {
    		if(
    			isset($subcat['subcat_alias']) 
    			&& !isset($exist[$subcat['subcat_alias']]) 
    			&& $subcat['cat_alias'] == $params['cat'] 
    			&& $subcat['child_alias'] == $params['child']
    		) {
    			$exist[$subcat['subcat_alias']] = 1;
    			$subcats[] = array(
    				'subcat_title' => $subcat['subcat_title'],
	    			'subcat_alias' => $subcat['subcat_alias'],
	    			'cat_title' => $subcat['cat_title'],
	    			'cat_alias' => $subcat['cat_alias'],
	    			'child_title' => $subcat['child_title'],
	    			'child_alias' => $subcat['child_alias'],
	    			'parent_title' => $subcat['parent_title'],
	    			'parent_alias' => $subcat['parent_alias']
    			);
    		}
    	}
    	
    	// Получение массива для хлебных крошек
    	if (!empty($goods)) {
    		$this->view->bc = $goods[0];
    	} else {
    		$this->view->bc = $subcats[0];
    	}
    	
    	$this->view->goods = $goods;
    	$this->view->subcats = $subcats;
    	
    	//$this->help->arrayTrans($goods);
    	//$this->help->arrayTrans($subcats);
    	//$this->help->arrayTrans($tree);
    }
    
    public function cataloguesubcatAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	//$this->help->arrayTrans($params);
    	
    	$items = $this->model->getMergedTree();
    	$goods = array();
    	foreach ($items as &$item) {
    		if(
    			$item['child_alias'] == $params['child'] &&
    			$item['cat_alias'] == $params['cat'] &&
    			$item['subcat_alias'] == $params['subcat'] 
    		) {
    			$img = $item['image'];
    			$this->sImage->setImage($img);
    			$this->sImage->setCompression(100);
    			$this->sImage->setCacheDirName('thumbs_150px');
    			$this->sImage->resizeToWidth(150);
    			$item['image'] = $this->sImage->save();
    			
    			$this->sImage->setImage($img);
    			$this->sImage->setCacheDirName('thumbs_600px');
    			$this->sImage->resizeToWidth(600);
    			$item["image_big"] = $this->sImage->save();
    			
    			$goods[] = $item;
    		}
    	}
    	
    	//$this->help->arrayTrans($goods);
    	$this->view->goods = $goods;
    	$this->view->bc = $goods[0];
    	//$this->help->arrayTrans($items);
    }
    
    public function goodAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	//$this->help->arrayTrans($params);
    	
    	$item = $this->model->getMergedTree($params['id']);
    	$item = $item[0];
    	
    	$img = $item['image'];
    	$this->sImage->setImage($img);
    	$this->sImage->setCompression(100);
    	$this->sImage->setCacheDirName('thumbs_200px');
    	$this->sImage->resizeToWidth(200);
    	$item['image_small'] = $this->sImage->save();
    	 
    	$this->sImage->setImage($img);
    	$this->sImage->setCacheDirName('thumbs_600px');
    	$this->sImage->resizeToWidth(600);
    	$item["image_big"] = $this->sImage->save();
    	
    	//$this->help->arrayTrans($item);
    	$this->view->item = $item;
    	$this->view->bc = $item;
    }
    
    public function indexgoodscategorieslistAction()
    {
    	$items = $this->model->getGoodsCategoriesList();
    	
    	if (!empty($items)) {
    		$cats = array();
    		foreach ($items as $item) {
    			$cats[$item['cat_alias']] = array(
    				"image" => $item['cat_image'],
    				"title" => $item['cat_title'],
    				"alias" => $item['cat_alias'],
    				"child_title" => $item['child_title'],
    				"child" => $item['child_alias'],
    				"parent" => $item['parent_alias']
    			);
    		}
    		
    		$this->view->items = $cats;
    		$this->view->title = $items[0]['child_title'];
    		//$this->help->arrayTrans($cats);
    	}
    }
    
    public function migrationAction()
    {
    	$request = $this->getRequest();
    	$params = $request->getParams();
    	$this->help->arrayTrans($params);
    	
    	$imgdir = $params['cat'];
    	$goodsCat = $params['catid'];
    	
    	$images = $this->help->imgarray($imgdir);
    	$this->help->arrayTrans($images);
    	
    	$i = 1;
    	
    	foreach ($images as $item) {
    		$insert = array(
    			"parent_id" => $goodsCat,
    			"title" => "Название товара",
    			"introtext" => "Описание товара",
    			"created" => time(),
    			"published" => 1,
    			"publish_up" => time(),
    			"publish_down" => 943912800,
    			"checked_out" => 0,
    			"ordering" => $i,
    			"image" => '/' . $item['big']   			
    		);
    		
    		//$this->model->abstractModel->insert($this->model->content, $insert);
    		$i++;
    	}
    }

}