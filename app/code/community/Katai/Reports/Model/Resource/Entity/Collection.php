<?php
/**
 * File: Collection.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:13
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Resource_Entity_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('katai_reports/entity');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Katai_Reports_Model_Resource_Entity_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }

        $this->addFilter('store', array('in' => $store), 'public');

        return $this;
    }

    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     *
     * @return Varien_Db_Select
     */
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();

        $countSelect->reset(Zend_Db_Select::GROUP);

        return $countSelect;
    }

    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('katai_reports/entity_store')),
                'main_table.entity_id = store_table.entity_id',
                array()
            )->group('main_table.entity_id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
}