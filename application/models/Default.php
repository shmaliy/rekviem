<?php
class Application_Model_Default
{
	public $content; 
    public $categories;
    public $tags;
    public $db;
    public $nowdate;
    public $help;
    public $obl;
    public $gorod;
	public $categoryAlias;
    
    public function __construct()
    {
		$this->abstractModel = new Application_Model_Abstract();
        $this->content = $this->abstractModel->content;
        $this->categories = $this->abstractModel->categories;
        $this->tags = $this->abstractModel->tags;
        $this->obl = $this->abstractModel->obl;
        $this->gorod = $this->abstractModel->gorod;
        $this->db = $this->abstractModel->db;
        $this->nowdate = $this->abstractModel->nowdate;
        $this->help = $this->abstractModel->help;
        $this->lang = $this->abstractModel->lang;
    }
	
	public function getDefaultWidgetContent($category = null){
			
		if(is_null($category)){
			return array();
		}	
		
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => "content.title",
				"alias" => "content.title_alias",
				"text" => "content.introtext",
				"image" => "content.image"
			)
		);
		$select->where("content.published = 1");
		
		$select->joinLeft(
			array("category" => $this->categories),
			"category.id = content.parent_id",
			array(
				"cat_title" => "category.title",
				"cat_alias" => "category.title_alias"
			)
		);
		$select->where("category.published = 1");
		$select->where("category.title_alias = ?", $category);
		$select->order("content.ordering");
		$select->limit("5");
		
		return $this->db->fetchAll($select);
	}
	
	public function getFacesWidgetContent(){
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => "content.title",
				"position" => "content.param5",
				"activity" => "content.param6",
				"image" => "content.image",
				"login" => "content.param2",
				"published" => "content.published"
			)
		);
		$select->where("content.param1 = 1");
		
		$select->joinLeft(
			array("category" => $this->categories),
			"category.id = content.parent_id",
			array(
				"cat_title" => "category.title",
				"cat_alias" => "category.title_alias"
			)
		);
		$select->where("category.published = 1");
		$select->where("category.title_alias = ?", 'faces');
		$select->order("content.ordering");
				
		return $this->db->fetchAll($select);
	}
	
	public function getConsultingCategoriesWidgetContent()
	{
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => "content.title",
			)
		);
		$select->where("content.published = 1");
		
		$select->joinLeft(
			array("category" => $this->categories),
			"category.id = content.parent_id",
			array(
				"cat_title" => "category.title",
				"cat_alias" => "category.title_alias"
			)
		);
		$select->where("category.published = 1");
		
		$select->joinLeft(
			array("parent" => $this->categories),
			"parent.id = category.parent_id",
			array(
				"parent_title" => "parent.title",
				"parent_alias" => "parent.title_alias"
			)
		);
		$select->where("parent.published = 1");
		$select->where("parent.title_alias = ?", 'consulting_room');
		
		$result = $this->db->fetchAll($select);
		
		if(empty($result)){
			return array();
		}
		
		foreach($result as $item){
			$items[$item['cat_alias']] = array(
				"cat_title" => $item['cat_title'],
				"cat_alias" => $item['cat_alias'],
				"parent_title" => $item['parent_title'],
				"parent_alias" => $item['parent_alias']
			);
		}
		
		return $items; 
	}
}