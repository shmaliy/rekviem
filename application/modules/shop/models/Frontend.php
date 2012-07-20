<?php
class Shop_Model_Frontend
{
    public $content; 
    public $categories;
    public $cart;
    public $db;
    public $help;
    public $abstractModel;
    public $rootCategoryAlias;
    public $goodsCategoryAlias;
    public $monumentsCategoryAlias;
    
    public function __construct()
    {
		$this->abstractModel = new Application_Model_Abstract();
        $this->content = $this->abstractModel->content;
        $this->categories = $this->abstractModel->categories;
        $this->cart = $this->abstractModel->cart;
        $this->db = $this->abstractModel->db;
        $this->help = $this->abstractModel->help;
        $this->rootCategoryAlias = 'catalogue';
        $this->goodsCategoryAlias = 'funeral_goods';
        $this->monumentsCategoryAlias = 'monuments';
        
    }
    
    public function getGoodsCategoriesList()
    {
    	$select = $this->db->select();
    	$select->from(
    		array("good" => $this->content),
    		array('id', 'title')
    	);
    	$select->where("good.published = 1");
    	
    	$select->joinLeft(
    		array("gCategory" => $this->categories),
    		"good.parent_id = gCategory.id",
    		array(
    			'cat_title' => 'gCategory.title', 
    			'cat_alias' => 'gCategory.title_alias', 
    			'cat_image' => 'gCategory.image'
    		)
    	);
    	$select->where("gCategory.published = 1");
    	$select->where("gCategory.image != ?", '');
    	$select->order("gCategory.ordering");
    	
    	$select->joinLeft(
    		array("gChild" => $this->categories),
    		"gCategory.parent_id = gChild.id",
    		array(
    			'child_title' => 'gChild.title',
    			'child_alias' => 'gChild.title_alias'
    		)
    	);
    	$select->where("gChild.published = 1");
    	$select->where("gChild.title_alias = ?", $this->goodsCategoryAlias);
    	
    	$select->joinLeft(
    		array("gParent" => $this->categories),
    	    "gChild.parent_id = gParent.id",
    		array(
    	    	'parent_title' => 'gParent.title',
    	    	'parent_alias' => 'gParent.title_alias'
    	)
    	);
    	$select->where("gParent.published = 1");
    	$select->where("gParent.title_alias = ?", $this->rootCategoryAlias);
    	
    	//echo $select;
    	
    	return $this->db->fetchAll($select);
    }
    
    public function getGoodsCatTree($id = null)
    {
    	$select = $this->db->select();
    	
    	// goods
    	$select->from(
    		array('good' => $this->content),
    		array('id', 'title', 'introtext', 'fulltext', 'image', 'price' => 'good.param1')
    	);
    	$select->where("good.published = 1");
    	$select->where("good.image != ?", '');
    	if (!is_null($id)) {
    		$select->where("good.id = ?", $id);
    	}
    	
    	// cat
    	$select->joinLeft(
    		array('cat' => $this->categories),
    		"good.parent_id = cat.id",
    		array(
    			'cat_title' => 'cat.title',
    			'cat_alias' => 'cat.title_alias',
    			'cat_description' => 'cat.description',
    			'cat_image' => 'cat.image'
    		)
    	);
    	$select->where("cat.published = 1");
    	
    	
    	// child
    	$select->joinLeft(
    		array('child' => $this->categories),
	    	"cat.parent_id = child.id",
	    	array(
	    	    'child_title' => 'child.title',
	    	    'child_alias' => 'child.title_alias',
	    	    'child_description' => 'child.description',
	    	    'child_image' => 'child.image'
	    	)
    	);
    	$select->where("child.published = 1");
    	
    	// parent
    	$select->joinLeft(
    		array('parent' => $this->categories),
	    	"child.parent_id = parent.id",
	    	array(
	    	    'parent_title' => 'parent.title',
	    	    'parent_alias' => 'parent.title_alias',
	    	    'parent_description' => 'parent.description',
	    	    'parent_image' => 'parent.image'
	    	)
    	);
    	$select->where("parent.published = 1");
    	$select->where("parent.title_alias = ?", $this->rootCategoryAlias);
    	
    	$select->order("cat.ordering");
    	$select->order("good.ordering");
    	
    	return $this->db->fetchAll($select);
    }
    
    public function getGoodsSubcatTree($id = null)
    {
    	$select = $this->db->select();
    	
    	// goods
    	$select->from(
    		array('good' => $this->content),
    		array('id', 'title', 'introtext', 'fulltext', 'image', 'price' => 'good.param1')
    	);
    	$select->where("good.published = 1");
    	$select->where("good.image != ?", '');
    	if (!is_null($id)) {
    		$select->where("good.id = ?", $id);
    	}
    		
    	// subcat
    	$select->joinLeft(
    		array('subcat' => $this->categories),
    		"good.parent_id = subcat.id",
    		array(
    	    	'subcat_title' => 'subcat.title',
    	    	'subcat_alias' => 'subcat.title_alias',
    	    	'subcat_description' => 'subcat.description',
    	    	'subcat_image' => 'subcat.image'
    		)
    	);
    	$select->where("subcat.published = 1");
    	
    	
    	// cat
    	$select->joinLeft(
    		array('cat' => $this->categories),
    		"subcat.parent_id = cat.id",
    		array(
    			'cat_title' => 'cat.title',
    			'cat_alias' => 'cat.title_alias',
    			'cat_description' => 'cat.description',
    			'cat_image' => 'cat.image'
    		)
    	);
    	$select->where("cat.published = 1");
    	
    	// child
    	$select->joinLeft(
    		array('child' => $this->categories),
	    	"cat.parent_id = child.id",
	    	array(
	    	    'child_title' => 'child.title',
	    	    'child_alias' => 'child.title_alias',
	    	    'child_description' => 'child.description',
	    	    'child_image' => 'child.image'
	    	)
    	);
    	$select->where("child.published = 1");
    	
    	// parent
    	$select->joinLeft(
    		array('parent' => $this->categories),
	    	"child.parent_id = parent.id",
	    	array(
	    	    'parent_title' => 'parent.title',
	    	    'parent_alias' => 'parent.title_alias',
	    	    'parent_description' => 'parent.description',
	    	    'parent_image' => 'parent.image'
	    	)
    	);
    	$select->where("parent.published = 1");
    	$select->where("parent.title_alias = ?", $this->rootCategoryAlias);
    	
    	$select->order("subcat.ordering");
    	$select->order("good.ordering");
    	
    	return $this->db->fetchAll($select);
    }
    
    public function getMergedTree($id = null)
    {
    	$catTree = $this->getGoodsCatTree($id);
    	$subcatTree = $this->getGoodsSubcatTree($id);
    	
    	return array_merge($catTree, $subcatTree);
    }
 
    
}