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
}