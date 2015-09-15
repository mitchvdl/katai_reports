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
    }
}