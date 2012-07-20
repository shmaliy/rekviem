<?php

class Content_IndexController extends Zend_Controller_Action
{
    private $model;
    private $help;
	//private $img;
	
	public function init()
    {
        $this->model = new Content_Model_Frontend();
       // $this->img = new img();
        $this->sImage = new SimpleImage();
        $this->help = $this->model->abstractModel->help;
		$this->view->help = $this->help;
    }
    
    public function indexAction()
    {
        
	}   
	
	public function staticAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
		//$this->help->arrayTrans($params);
		
		$item = $this->model->getStaticContent($params[1]);
		$imgarray = array();
		
		if (!empty($item['images'])) {
			$images = explode('|', trim($item['images'], '|'));
			foreach ($images as $img) {
				$this->sImage->setImage($img);
				$this->sImage->setCompression(100);
				$this->sImage->setCacheDirName('thumbs_150px');
				$this->sImage->resizeToWidth(150);
				$thumb = $this->sImage->save();
				
				$this->sImage->setImage($img);
				$this->sImage->setCacheDirName('thumbs_600px');
				$this->sImage->resizeToWidth(600);
				$fullsize = $this->sImage->save();
				$imgarray[] = array (
					"thumb" => $thumb,
					"fullsize" => $fullsize
				);
			}
		}
		
		//$this->help->arrayTrans($imgarray);
		
		$this->view->item = $item;
		$this->view->imgarray = $imgarray;
	}
	
	public function indexnewsAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
		//$this->help->arrayTrans($params);
		
		$items = $this->model->getDymanicContentList('news', 'ordering', 'asc');
		foreach ($items as &$item) {
			$item['created'] = date('d', $item['created']) . ' ' . $this->help->russianMonth($item['created']) . ' ' . date('Y', $item['created']) . ' г.';
		}
		$this->view->items = $items;
		//$this->help->arrayTrans($items);
	}
	
	public function indexoffersAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
		$items = $this->model->getDymanicContentList('akcii', 'ordering', 'asc', 5);
		foreach ($items as &$item) {
			$img = $item['image'];
			$this->sImage->setImage($img);
			$this->sImage->setCompression(100);
			$this->sImage->setCacheDirName('thumbs_100px');
			$this->sImage->resizeToWidth(100);
			$item['image'] = $this->sImage->save();
		}
		$this->view->items = $items;
		//$this->help->arrayTrans($items);
	}
	
	public function defaultcontentlistAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		
		//$this->help->arrayTrans($params);
		
		$items = $this->model->getDymanicContentList($params['alias'], 'ordering', 'asc');
		foreach ($items as &$item) {
			if(!empty($item['image'])) {
				$img = $item['image'];
				$this->sImage->setImage($img);
				$this->sImage->setCompression(100);
				$this->sImage->setCacheDirName('thumbs_120px');
				$this->sImage->resizeToWidth(120);
				$item['image'] = $this->sImage->save();
			}
		}
		//$this->help->arrayTrans($items);
		$this->view->items = $items;
		$this->view->alias = $params['alias'];
	}

	public function defaultcontentitemAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		//$this->help->arrayTrans($params);
		
		$item = $this->model->getDefaultContentItem($params['id']);
		//$this->help->arrayTrans($item);
		$this->view->item = $item;
	}
	
	public function traditionslevel1listAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		//$this->help->arrayTrans($params);
		
		$items = $this->model->getDymanicContentList($params['alias'], 'ordering', 'asc');
		foreach ($items as &$item) {
			if(!empty($item['image'])) {
				$img = $item['image'];
				$this->sImage->setImage($img);
				$this->sImage->setCompression(100);
				$this->sImage->setCacheDirName('thumbs_120px');
				$this->sImage->resizeToWidth(120);
				$item['image'] = $this->sImage->save();
			}
		}
		//$this->help->arrayTrans($items);
		
		$subcats = $this->model->getSubcategories($params['alias']);
		//$this->help->arrayTrans($subcats);
		$this->view->items = $items;
		$this->view->subcats = $subcats;
		$this->view->alias = $params['alias'];
	}
	
	public function traditionslevel2listAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		//$this->help->arrayTrans($params);
		
		$items = $this->model->getSubcategoryContentList($params['parent'], $params['alias']);
		$this->view->items = $items;
		//$this->help->arrayTrans($items);
	}	
	
	public function traditionslevel2itemAction()
	{
		$request = $this->getRequest();
		$params = $request->getParams();
		//$this->help->arrayTrans($params);
		
		$item = $this->model->getSubcategoryContentItem($params['parent'], $params['subcat'], $params['id']);
		$this->view->item = $item;
		//$this->help->arrayTrans($item);
		
	}
}