<?php
/**
 * File: Abstract.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 22.09.15 17:55
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Chart_Abstract extends Mage_Core_Block_Template
{
    protected function _construct()
    {

        $this->setTemplate('katai/reports/render/chart/abstract.phtml');
        parent::_construct();
    }

}