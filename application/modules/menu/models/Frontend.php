<?php
class Menu_Model_Frontend
{
    public $_tbl;
    public $db;
    public $nowdate;
    public $help;
    
    public function __construct()
    {
        $this->_tbl = "cms_menu";
        $this->db = Zend_Registry::get('db');
        $this->help = new myHelpers();
    }
    
    public function ReturnMenuItems($parent_alias)
    {
        $select = $this->db->select();
        $select->from(
        	array("menu" => $this->_tbl), 
        	array('id', 'title', 'link', 'image')
       	);
        $select->where("menu.published = ?", 1);
        $select->order("menu.ordering");
        
        $select->joinLeft(
        	array("parent" => $this->_tbl),
        	"menu.parent_id = parent.id",
        	array()
        );
        $select->where("parent.title_alias = ?", $parent_alias);
        
        $result = $this->db->fetchAll($select);
		
		foreach ($result as &$menuItem){
			$select->reset();
			$childs = array();
			
			$select->from(
				array("child" => $this->_tbl),
				array('id', 'title', 'link')
			);
			$select->where("child.published = ?", 1);
			$select->where("child.parent_id = ?", $menuItem['id']);
			$childs = $this->db->fetchAll($select);
			if(!empty($childs)){
				$menuItem['childs'] = $childs;
			}
		}
		
		//$this->help->arrayTrans($result);
		
        return $result;            
    }
}