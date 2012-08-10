<?php

/**
 * Description of Jgs_Application_Model_Mapper
 * Base mapper model to build data mappers around.
 *
 * @author john
 */
abstract class Jgs_Model_Mapper_Abstract
{
    /**
     * Instance of Zend_Db_Table_Abstract
     *
     * @var Zend_Db_Table_Abstract $_tableGateway
     */
    protected $tableGateway = null;
    protected $map = array();

    /**
     * Will accept a DbTable model passed or will instantiate
     * a Zend_Db_Table_Abstract object from table name.
     *
     * @param Zend_Db_Table_Abstract $tableGateway
     */
    public function __construct(Zend_Db_Table_Abstract $tableGateway = null)
    {

        if (is_null($tableGateway)) {

            $this->tableGateway = new Zend_Db_Table($this->_tableName);
        } else {

            $this->tableGateway = $tableGateway;
        }
    }

    /**
     * Get default database table adapter
     *
     * @return Zend_Db_Table_Abstract
     */
    protected function getGateway()
    {

        return $this->tableGateway;
    }

    /**
     * Set value and name of entity in identity map.
     *
     * @param string $id
     * @param object $entity
     */
    protected function setMap($id, $entity)
    {
        $this->map[$id] = $entity;
    }

    /**
     * Get value of entity id from identity map.
     *
     * @param string $id
     * @return string
     */
    protected function getMap($id)
    {
        if (array_key_exists($id, $this->map)) {
            return $this->map[$id];
        }
    }

    /**
     * findByColumn() returns an array of rows selected
     * by column name and column value.
     * Optional orderBy value.
     *
     * @param string $column
     * @param string $value
     * @param string $order
     * @return array of entity objects
     */
    public function findByColumn($column, $value, $order = null)
    {

        $select = $this->getGateway()->select();
        $select->where("$column = ?", $value);

        if (!is_null($order)) {
            $select->order($order);
        }

        $result = $this->getGateway()->fetchAll($select);

        $entities = array();
        foreach ($result as $row) {
            $entity = $this->createEntity($row);
            $this->setMap($row->id, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * findById() is proxy for find() method and returns
     * an entity object.
     *
     * @param type $id
     * @return object Jgs_Model_Entity_Abstract
     */
    public function findById($id)
    {

        if ($this->getMap($id)) {
            return $this->getMap($id);
        }

        $select = $this->getGateway()->select();
        $select->where('id = ?', $id);

        $row = $this->getGateway()->fetchRow($select);

        $entity = $this->createEntity($row);

        $this->setMap($row->id, $entity);

        return $entity;
    }

    /**
     * findAll() is a proxy for the fetchAll() method and returns
     * an array of entity objects.
     *
     * @param array $where an array of id's
     * @param string $order in the format of 'column ASC'
     * @return array of entity objects
     */
    public function findAll(array $where = null, $order = null)
    {

        $select = $this->getGateway()->select();

        if (!is_null($where)) {
            $select->where('id IN (?)', $where);
        }
        if (!is_null($order)) {
            $select->order($order);
        }

        $rowset = $this->getGateway()->fetchAll($select);

        $entities = array();
        foreach ($rowset as $row) {
            $entity = $this->createEntity($row);
            $this->setMap($row->id, $entity);
            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * Abstract method to be implemented by concrete mappers.
     */
    abstract protected function createEntity($row);
}
