<?php
/**
 * File: Run.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:51
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Run extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'katai_reports';
        $this->_controller = 'adminhtml_katai_reports_run';
        $this->_headerText = Mage::helper('katai_reports')->__('Run Report');
        $this->_backButtonLabel = $this->__('Back');
        $this->_addBackButton();
        parent::__construct();
        $this->_removeButton('add');
    }

    public function getBackUrl()
    {
        return Mage::getUrl('*/*/edit/', ['entity_id' => $this->getReport()->getId()]);
    }

    /**
     * Getter
     *
     * @return Katai_Reports_Model_Entity
     */
    public function getReport()
    {
        return Mage::registry('current_katai_report_entity');
    }

}