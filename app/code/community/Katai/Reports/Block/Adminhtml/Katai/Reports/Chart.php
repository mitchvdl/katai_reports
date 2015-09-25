<?php
/**
 * File: Chart.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:51
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Chart extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'katai_reports';
        $this->_controller = 'adminhtml_katai_reports_chart';
        $this->_headerText = Mage::helper('katai_reports')->__('Chart Overview');
        parent::__construct();

    }

}