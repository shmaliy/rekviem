<?php

class Application_Model_DatabaseMapper
{
    /**
     * Имя класса управления таблицей по умолчанию
     * 
     * @var string
     */
    protected $_dbTableName = 'Application_Model_DbTable_Database';
    
	/**
	 * Обьект класса управления таблицей
	 * 
	 * @var Zend_Db_Table_Abstract
	 */
    protected $_dbTable = null;
    
    /**
     * Обьект модели
     * 
     * @var Application_Model_Database
     */
    protected $_model = null;
    
    /**
     * Флаг: игнорировать ошибки в модели
     * 
     * @var bool
     */
    protected $_modelThrowsExceptions = true;
    
	/**
	 * Конструктор класса
	 * 
	 * @param $options array Массив настроек маппера и зависимых обьектов
	 */
    public function __construct(array $options)
    {
        if (!empty($options['dbtablename'])) {
            $this->setDbTableName($options['dbtablename']);
        }
        
    	if (!empty($options['dbtable'])) {
            $this->setDbTable($options['dbtable']);
        }
        
        if (isset($options['modelThrowsExceptions'])) {
            $this->modelThrowsExceptions($options['modelThrowsExceptions']);
        }
        
        if (!empty($options['model'])) {
            $this->setModel($options['model']);
        }
    }
    
    /**
     * Устанавливает имя класса управления таблицами 
     * по умолчанию.
     * 
     * @param $dbTableName string Имя класса
     */
    public function setDbTableName($dbTableName)
    {
    	$this->_dbTableName = (string) $dbTableName;
    	return $this;
    }
    
    /**
     * Возвращает имя класса управления таблицами 
     * по умолчанию.
     */
    public function getDbTableName()
    {
    	return $this->_dbTableName;
    }
    
    /**
     * Устанавливает обьект управления таблицами.
     * 
     * @param $dbTable object|string|array 
     * @throws Exception
     */
    public function setDbTable($dbTable)
    {
        if (is_array($dbTable)) {
            if (empty($dbTable['name'])) {
                $dbTable['name'] = $this->getDbTableName();
            }
                        
            $options = array();            
            if (!empty($dbTable['options'])) {
                $options = $dbTable['options'];
            }
            
            $dbTable = $dbTable['name'];
        }
        
        if (is_string($dbTable)) {
            $dbTable = new $dbTable($options);
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    /**
     * Возвращает обьект управления таблицами (если необходимо создает его).
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->getDbTableName());
        }
        return $this->_dbTable;
    }
    
    /**
     * Устанавливает обьект модели и настраивает его.
     * 
     * @param $model object|string 
     * @throws Exception
     */
    public function setModel($model)
    {
    	$info = $this->getDbTable()->info();
        $columns = $info[Zend_Db_Table_Abstract::COLS];
        $primary = $info[Zend_Db_Table_Abstract::PRIMARY];
        
        if (is_string($model)) {
            $model = new $model($columns);
        }
        if (!$model instanceof Application_Model_Database) {
            throw new Exception('Invalid model provided');
        }
        
        $this->_model = $model;
        $this->modelThrowsExceptions(
            $this->_model->throwExceptions($this->modelThrowsExceptions())
        );
        
        $this->_model->setPrimaryKey(current($primary));
        return $this;
    }

    /**
     * Возвращает обьект модели (если необходимо создает его).
     */
    public function getModel()
    {
        if (null === $this->_model) {
            $this->setModel('Application_Model_Database');
        }
        return $this->_model;
    }
    
    /**
     * Устанавливает флаг 'игнорировать ошибки модели', 
     * если не передан возвращает текущее значение.
     * 
     * @param $flag bool|null 
     */
    public function modelThrowsExceptions($flag = null)
    {
        if (isset($flag)) {
            $this->_modelThrowsExceptions = (bool) $flag;
            return $this;
        }
        return (bool) $this->_modelThrowsExceptions;
    }

    /**
     * Алиас метода quoteIdentifier адаптера БД.
     * 
     * @param $string string 
     */
    public function qi(string $string)
    {
        return $this->getDbTable()->quoteIdentifier($string);
    }
    
    /**
     * Абстрактный метод для предобработки данных для записи в БД.
     * 
     * @param $data mixed 
     */
    public function prefilterWriteData($data)
    {
        return $data;
    }
    
    /**
     * Абстрактный метод для предобработки данных для чтения из БД.
     * 
     * @param $data mixed 
     */
    public function prefilterReadData($data)
    {
        return $data;
    }
    
    /**
     * Сохранение данных в БД.
     * 
     * @param $model object
     * @throws Exception
     */
    public function save($model)
    {
        if (!$model instanceof Application_Model_Database) {
            throw new Exception('Invalid model provided');
        }
        
        $adapter = $this->getDbTable();
        $primary = $adapter->info(Zend_Db_Table_Abstract::PRIMARY);
        $primaryMethod = 'get' . ucfirst($primary);
        
        $model = $this->prefilterWriteData($model);
        $data = $model->toArray();
 
        if (null === ($id = $model->$primaryMethod())) {
            unset($data[$primary]);
            return $adapter->insert($data);
        } else {
            return $adapter->update($data, array(
                $this->qi($primary) . ' = ?' => $id
            ));
        }
    }
    
    /**
     * Получение записи по первичному ключу.
     * 
     * @param $id string 
     */
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        return $this->prefilterReadData(
            $this->getModel()->setColumns($row)
        );
    }
    
    /**
     * Получение всех записей текущей таблицы.
     * 
     * @param $options array Массив с условиями выборки
     */
    public function fetchAll(array $options = array())
    {
        if (isset($options['where'])) {
        	$where = $options['where'];
        }
        if (isset($options['order'])) {
        	$order = $options['order'];
        }
        if (isset($options['count'])) {
        	$count = $options['count'];
        }
        if (isset($options['offset'])) {
        	$offset = $options['offset'];
        }
        
    	$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
        $entries   = array();
        foreach ($resultSet as $row) {
            $model = clone $this->getModel();
            $model->setColumns($row);
            $entries[] = $this->prefilterReadData($model);
        }
        return $entries;
    }
}