<?php 
class Application_Model_Abstract
{
    public $categories;
	public $content; 
	public $cart;
    public $db;
    public $help;
    
    public function __construct()
    {
    	$this->db = Zend_Registry::get('db');
    	$this->categories = "cms_categories";
    	$this->content = "cms_content";
    	$this->help = new myHelpers();

    }
    public function insert($tbl, $array)
    {
    	$this->db->insert($tbl, $array);
    	return $this->db->lastInsertId();
    }
    
    public function update($id, $tbl, $array)
    {
    	$this->db->update($tbl, $array, 'id = ' . $id);
    }
    
    public function delete($id, $tbl)
    {
    	$this->db->delete($tbl, 'id = ' . $id);
    }
	
	public function countItems($categoryAlias = null)
	{
		if(is_null($categoryAlias)){
			return 0;
		}	
		$select = $this->db->select();
		$select->from(
			array("item" => $this->content),
			array("id" => "item.id")
		);
		$select->where("item.published = 1");
		$select->joinLeft(
			array("parent" => $this->categories),
			"parent.id = item.parent_id",
			array("alias" => "parent.title_alias")
		);
		$select->where("parent.title_alias = ?", $categoryAlias);
		$select->where("parent.published = 1");
		$result = $this->db->fetchAll($select);
		return count($result);	
	}
	
	public function addHit($id)
	{
		$array = array(
			"hits" => new Zend_Db_Expr($this->db->quoteIdentifier('hits') . ' + 1')
		);	
		$this->db->update($this->content, $array, 'id = ' . $id);
	}
}