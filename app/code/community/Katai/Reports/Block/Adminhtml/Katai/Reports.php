<?php
/**
 * File: Reports.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:51
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'katai_reports';
        $this->_controller = 'adminhtml_katai_reports';
        $this->_headerText = Mage::helper('katai_reports')->__('Manage Reports');
        parent::__construct();
        $this->_updateButton('add', 'label', Mage::helper('katai_reports')->__('Add New Report'));

    }
    protected function _prepareLayout()
    {
        $this->setChild( 'grid',
            $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',
                $this->_controller . '.grid')->setSaveParametersInSession(true) );
        return parent::_prepareLayout();
    }
}