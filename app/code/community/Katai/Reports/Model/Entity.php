<?php
/**
 * File: Entity.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:11
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Entity extends Mage_Core_Model_Abstract
{
    protected $_eventObject = 'reports_entity';
    protected function _construct()
    {
        $this->_init('katai_reports/entity');
    }

    public function getHash()
    {
        return $this->getData('custom_options/_hash');
    }

    public function getUniqueId()
    {
        if (!$this->getTitle()) {
            return $this->getHash();
        }

        return 'katai_' . Mage::getModel('catalog/product_url')->formatUrlKey($this->getTitle() . '-' . $this->getId());
    }


    /**
     * Get select fields
     * @return array
     */
    public function getSelectFields()
    {
        $fields = [];
        $data = $this->getdata('custom_options/select_fields') ?: [];
        foreach ( $data as $_idx => $field ) {
//            $fields[$field['position'] .  $_idx] = $field;
            $fields[$field['name']] = $field;

        }
//        ksort($fields);
        return $fields;
    }

    /**
     * Convert the query data directly into a data-table.
     * @return array
     */
    public function arrayToDataTable()
    {
        return $this->getResource()->arrayToDataTable($this);
    }
}