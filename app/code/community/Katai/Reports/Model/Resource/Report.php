<?php
/**
 * File: Report.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Resource_Report extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('katai_reports/report', 'entity_id');
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Katai_Reports_Model_Entity $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        /** @var Katai_Reports_Helper_Data $helper */
        $helper = Mage::helper('katai_reports');
        $processor = $helper->getProcessor();

        $select = $processor->filter($object->getSqlQuery());

        return $select;
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Katai_Reports_Model_Resource_Entity
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {

        }

        return parent::_afterLoad($object);
    }

}