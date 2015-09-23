<?php
/**
 * File: Entity.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:12
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Resource_Entity extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('katai_reports/entity', 'entity_id');
    }

    /**
     * Process block data before deleting
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Katai_Reports_Model_Resource_Entity
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'entity_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('katai_reports/entity_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * @param Mage_Core_Model_Abstract $object
     * @return Katai_Reports_Model_Resource_Entity
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        // MySQL will handle the update of this field. We're not sending it over
        $object->unsetData('updated_at');

        // Serialize custom_options back
        $customOptions = $object->getData('custom_options');

        // Set a special hash
        if ( !isset($customOptions['_hash'])) {
            $customOptions['_hash'] = Mage::helper('core')->uniqHash();
        }

        $object->setData('custom_options', serialize($customOptions));
        return parent::_beforeSave($object); // TODO: Change the autogenerated stub
    }


    /**
     * Perform operations after object save
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Katai_Reports_Model_Resource_Entity
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();

        $table  = $this->getTable('katai_reports/entity_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = array(
                'entity_id = ?'     => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );

            $this->_getWriteAdapter()->delete($table, $where);
        }

        if ($insert) {
            $data = array();

            foreach ($insert as $storeId) {
                $data[] = array(
                    'entity_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }

            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);

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
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $stores = array(
                (int) $object->getStoreId(),
                Mage_Core_Model_App::ADMIN_STORE_ID,
            );

            $select->join(
                array('cbs' => $this->getTable('katai_reports/entity_store')),
                $this->getMainTable().'.entity_id = cbs.entity_id',
                array('store_id')
            )->where('is_active = ?', 1)
                ->where('cbs.store_id in (?) ', $stores)
                ->order('store_id DESC')
                ->limit(1);
        }

        return $select;
    }


    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $adapter = $this->_getReadAdapter();

        $select  = $adapter->select()
            ->from($this->getTable('katai_reports/entity_store'), 'store_id')
            ->where('entity_id = :entity_id');

        $binds = array(
            ':entity_id' => (int) $id
        );

        return $adapter->fetchCol($select, $binds);
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
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
            $object->setData('stores', $stores);

            // unserialize custom_options back
            $customOptions = $object->getData('custom_options');
            if ( strlen($customOptions) > 0 ) {
                $object->setData('custom_options', unserialize($customOptions));
            }
        }

        return parent::_afterLoad($object);
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