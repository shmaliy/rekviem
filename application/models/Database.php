<?php

class Application_Model_Database
{
    protected $_columns = array();
    
    protected $_primary;
    
    protected $_throwExceptions = true;
    
    /**
     * Конструктор обьекта
     *  
     * В качестве аргумента принимает массив вида
     * array('имяПоля1', 'имяПоля2', ...)
     * 
     * @param array $columnNames
     * @param bool $throwExceptions
     * @throws Exception
     */
    public function __construct($columnNames = null)
    {
        if (!isset($columnNames) || !is_array($columnNames) || empty($columnNames)) {
            throw new Exception("Invalid model constructor argument");
        }
        
        foreach ($columnNames as $name) {
            $this->_columns[$name] = null;            
        }
    }
    
    public function __set($name, $value)
    {
        if (!array_key_exists($name, $this->_columns)) {
            if ($this->throwExceptions()) {
                throw new Exception("Invalid model property '$name'");
            }
            return $this;
        }
        $this->_columns[$name] = $value;
        return $this;
    }
 
    public function __get($name)
    {
        if (!array_key_exists($name, $this->_columns)) {
            if ($this->throwExceptions()) {
                throw new Exception("Invalid model property '$name'");
            }
            return false;
        }
        return $this->_columns[$name];
    }
    
    public function __call($method, $arguments)
    {
        $prefix = '__' . substr($method, 0, 3);
        $name = lcfirst(substr($method, 3));
        if (!in_array($prefix, array('__set', '__get')) || !array_key_exists($name, $this->_columns)) {
            if ($this->throwExceptions()) {
                throw new Exception("Invalid model method '$method'");
            }
            return false;
        }
        return $this->$prefix($name, current($arguments));
    }
    
    public function setColumns($options)
    {
        if ($options instanceof Zend_Db_Table_Row_Abstract) {
            $options = $options->toArray();
        }
        
        foreach ($options as $key => $value) {            
            $this->__set($key, $value);
        }
        
        return $this;        
    }
    
    public function setPrimaryKey($primary)
    {
    	$this->_primary = $primary;
    	return $this;
    }
    
    public function getPrimaryKey()
    {
    	return $this->_primary;
    }
    
    public function toArray()
    {
        return $this->_columns;
    }
    
    public function throwExceptions($flag = null)
    {
        if (isset($flag)) {
            $this->_throwExceptions = (bool) $flag;
            return $this;
        }
        return (bool) $this->_throwExceptions;
    }
}