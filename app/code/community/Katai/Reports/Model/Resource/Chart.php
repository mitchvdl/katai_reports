<?php
/**
 * File: Chart.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:12
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Resource_Chart extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('katai_reports/chart', 'entity_id');
    }


    /**
     * @param Katai_Reports_Model_Entity $object
     * @return array|bool
     */
    public function arrayToDataTable(Mage_Core_Model_Abstract $object)
    {
        $query = Mage::helper('katai_reports')->getProcessor()->filter($object->getSqlQuery());

        $result = $this->getReadConnection()->fetchAll($query);
        if ( count($result) == 0 ) {
            return false;
        }

        $data = [];
        $header = false;
        $selectFields = $object->getSelectFields();

        // Building header of the data array
        foreach ( array_keys($result[0]) as $k) {
            $base = ['label' => $k, 'id' => $k, 'type' => 'string'];
            if ( isset($selectFields[$k]) ) {
                $base = $base + ['label' => $selectFields[$k]['label'], 'type' => $selectFields[$k]['data_type']];
            }
            $data[0][] = $base;
        }

        foreach ( $result as $_d ) {
            $data[] = array_values($_d);
        }
        return $data;
    }
}