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
}