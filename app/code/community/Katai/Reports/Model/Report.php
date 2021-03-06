<?php
/**
 * File: Run.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 18:11
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Report extends Katai_Reports_Model_Entity
{
    protected $_eventObject = 'reports_report';

    protected function _construct()
    {
        $this->_init('katai_reports/report');
    }


    public function load($id, $field = null)
    {
        return parent::load($id, $field); // TODO: Change the autogenerated stub
    }


}