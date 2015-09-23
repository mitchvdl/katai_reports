<?php
/**
 * File: Bar.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 23.09.15 16:32
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Chart_Bar extends Katai_Reports_Block_Chart_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('katai/reports/render/chart/table.phtml');
    }
}