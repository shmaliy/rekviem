<?php
class Content_Model_Frontend
{
    public $content; 
    public $categories;
    public $tags;
    public $db;
    public $help;
    
    public function __construct()
    {
		$this->abstractModel = new Application_Model_Abstract();
        $this->content = $this->abstractModel->content;
        $this->categories = $this->abstractModel->categories;
        $this->db = $this->abstractModel->db;
        $this->help = $this->abstractModel->help;
    }
    
    public function getDymanicContentList($category = null, $orderField = null, $orderDirection = 'ASC', $limit = null, $offset = 0)
    {
    	if(is_null($category)){
    		return array();
    	}
    	
    	$select = $this->db->select();
    	$select->from(
    		array('content' => $this->content),
    		array(
    	      	'id' => 'content.id',
    	       	'title' => 'content.title',
    	       	'introtext' => 'content.introtext',
    	       	'fulltext' => 'content.fulltext',
    	       	'image' => 'content.image',
    			'created' => 'content.created',
    	    )
    	);
    	$select->where('content.published = 1');
    	
    	if (!is_null($orderField)) {
    		$select->order('content.' . $orderField . ' ' . $orderDirection);
    	}
    	
    	if (!is_null($limit)) {
    		$select->limit($limit, $offset);
    	}

    	$select->joinLeft(
    		array('category' => $this->categories),
    			"category.id = content.parent_id",
    		array(
    	       	"cat_title" => "category.title",
    	       	"cat_alias" => "category.title_alias"
    		)
    	);
    	$select->where("category.published = 1");
    	$select->where("category.title_alias = ?", $category);
    	
    	//echo $select;
    	
    	return $this->db->fetchAll($select);
    }
    
    public function getDefaultContentItem($id = null)
	{
		if(is_null($id)){
			return array();
		}
		
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => "content.title",
				"alias" => "content.title_alias",
				"introtext" => "content.introtext",
				"fulltext" => "content.fulltext",
				"image" => "content.image",
				"images" => "content.images",
				"created" => "content.created",
				"hits" => "content.hits",
			)
		);
		$select->where("content.published = 1");
		$select->where("content.id = ?", $id);
		$select->joinLeft(
			array("parent" => $this->categories),
			"parent.id = content.parent_id",
			array(
				"parent_title" => "parent.title",
				"parent_alias" => "parent.title_alias"
			)
		);
		$select->where("parent.published = 1");
		return $this->db->fetchRow($select);
	}
	
    public function getStaticContent($alias = null)
	{
		if(is_null($alias)){
			return array();
		}	
		
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => 'content.title',
				"alias" => "content.title_alias",
				"introtext" => 'content.introtext',
				"fulltext" => 'content.fulltext',
				"image" => "content.image",
				"images" => "content.images",
				"created" => "content.created",
				"hits" => "content.hits",
			)
		);
		$select->where("content.published = 1");
		$select->where("content.parent_id = 0");
		$select->where("content.title_alias = ?", $alias);
		$select->limit(1);
		
		return $this->db->fetchRow($select);
	}
	
	public function getSubcategories($parent = null)
	{
		if(is_null($parent)){
			return array();
		}
		
		$select = $this->db->select();
		$select->from(
			array("categories" => $this->categories),
			array(
				"id" => "categories.id",
				"title" => "categories.title",
				"alias" => "categories.title_alias"
			)
		);
		$select->where("categories.published = 1");
		$select->order("categories.ordering");
		
		$select->joinLeft(
			array("parent" => $this->categories),
			"categories.parent_id = parent.id",
			array(
				"parent_title" => "parent.title",
				"parent_alias" => "parent.title_alias"
			)
		);
		$select->where("parent.published = 1");
		$select->where("parent.title_alias = ?", $parent);
		
		return $this->db->fetchAll($select);
	}
	
	public function getSubcategoryContentList($parent = null, $child = null)
	{
		if(is_null($parent) || is_null($child)){
			return array();
		}
		
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => 'content.title',
				"alias" => "content.title_alias",
				"introtext" => 'content.introtext',
				"fulltext" => 'content.fulltext',
				"image" => "content.image",
				"images" => "content.images",
				"created" => "content.created",
				"hits" => "content.hits",
			)
		);
		$select->where("content.published = 1");
		$select->order("content.ordering");
		
		$select->joinLeft(
			array("child" => $this->categories),
			"content.parent_id = child.id",
			array(
				"child_title" => "child.title",
				"child_alias" => "child.title_alias"
			)
		);
		$select->where("child.published = 1");
		$select->where("child.title_alias = ?", $child);
		
		$select->joinLeft(
		array("parent" => $this->categories),
			"child.parent_id = parent.id",
			array(
				"parent_title" => "parent.title",
				"parent_alias" => "parent.title_alias"
			)
		);
		$select->where("parent.published = 1");
		$select->where("parent.title_alias = ?", $parent);
		
		//echo $select;
		
		return $this->db->fetchAll($select);
	}
	
	public function getSubcategoryContentItem($parent = null, $child = null, $id = null)
	{
		if(is_null($parent) || is_null($child) || is_null($id)){
			return array();
		}
		
		$select = $this->db->select();
		$select->from(
			array("content" => $this->content),
			array(
				"id" => "content.id",
				"title" => 'content.title',
				"alias" => "content.title_alias",
				"introtext" => 'content.introtext',
				"fulltext" => 'content.fulltext',
				"image" => "content.image",
				"images" => "content.images",
				"created" => "content.created",
				"hits" => "content.hits",
			)
		);
		$select->where("content.published = 1");
		$select->where("content.id = ?", $id);
		
		$select->joinLeft(
			array("child" => $this->categories),
			"content.parent_id = child.id",
			array(
				"child_title" => "child.title",
				"child_alias" => "child.title_alias"
			)
		);
		$select->where("child.published = 1");
		$select->where("child.title_alias = ?", $child);
		
		$select->joinLeft(
			array("parent" => $this->categories),
			"child.parent_id = parent.id",
			array(
				"parent_title" => "parent.title",
				"parent_alias" => "parent.title_alias"
			)
		);
		$select->where("parent.published = 1");
		$select->where("parent.title_alias = ?", $parent);
		
		//echo $select;
		
		return $this->db->fetchRow($select);
	}
}