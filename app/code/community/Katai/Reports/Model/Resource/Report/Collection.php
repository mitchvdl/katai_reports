<?php
/**
 * File: Collection.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:13
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Resource_Report_Collection extends Varien_Data_Collection_Db
{
    /** @var Mage_Core_Model_Abstract */
    protected $_report;

    /**
     * Collection constructor
     *
     * @param Mage_Core_Model_Resource_Db_Abstract $resource
     */
    public function __construct($resource = null)
    {
        parent::__construct();
        $this->_construct();
        $this->_resource = $resource;
        $this->setConnection($this->getResource()->getReadConnection());
//        $this->_initSelect();
    }

    protected function _construct()
    {
        return $this;
    }


    /**
     * Load data
     *
     * @param   bool $printQuery
     * @param   bool $logQuery
     *
     * @return  Varien_Data_Collection_Db
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if ($this->isLoaded()) {
            return $this;
        }

        $this->_beforeLoad();

        $this->printLogQuery($printQuery, $logQuery);
        $data = $this->getData();
        $this->resetData();

        if (is_array($data)) {
            foreach ($data as $row) {
                $item = $this->getNewEmptyItem();
                if ($this->getIdFieldName()) {
                    $item->setIdFieldName($this->getIdFieldName());
                }
                $item->addData($row);
                $this->addItem($item);
            }
        }

        $this->_setIsLoaded();
        $this->_afterLoad();
        return $this;
    }

    public function getData()
    {
        if ($this->_data === null) {
           /**
             * Prepare select for execute
             * @var string $query
             */
            $query       = $this->_prepareSelect($this->getSelect());
            $this->_data = $this->_fetchAll($query, $this->_bindParams);
            $this->_afterLoadData();
        }
        return $this->_data;
    }

    /**
     * Prepare select for load
     *
     * @param $select OPTIONAL
     * @return string
     */
    public function _prepareSelect($select)
    {
        /** @var Katai_Reports_Helper_Data $helper */
        $helper = Mage::helper('katai_reports');
        $processor = $helper->getProcessor();
        return (string)$processor->filter($select);
    }


    /**
     * Get Zend_Db_Select instance and applies fields to select if needed
     *
     * @return Varien_Db_Select
     */
    public function getSelect()
    {
        return $this->getReport()->getSqlQuery();
    }

    /**
     * Get resource instance
     *
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    public function getResource()
    {
        if (empty($this->_resource)) {
            $this->_resource = Mage::getResourceModel($this->getResourceModelName());
        }
        return $this->_resource;
    }

    public function setReport(Mage_Core_Model_Abstract $object)
    {
        $this->_report = $object;
        return $this;
    }

    public function getReport()
    {
        return $this->_report;
    }

    /**
     * Get SQL for get record count
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
//        $this->_renderFilters();
//
//        $countSelect = clone $this->getSelect();
//        $countSelect->reset(Zend_Db_Select::ORDER);
//        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
//        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
//        $countSelect->reset(Zend_Db_Select::COLUMNS);
//
//        $countSelect->columns('COUNT(*)');

        $select = $this->_prepareSelect($this->getSelect());
        return $select ;
    }

    /**
     * Get collection size
     *
     * @return int
     */
    public function getSize()
    {
        if (is_null($this->_totalRecords)) {

            $this->_totalRecords = count($this->getItems());
        }
        return intval($this->_totalRecords);
    }

}