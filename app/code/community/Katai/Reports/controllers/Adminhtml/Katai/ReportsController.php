<?php
/**
 * File: ReportsController.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 16:52
 * Package: Katai_Reports
 */

class Katai_Reports_Adminhtml_Katai_ReportsController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('report/katai/reports')
//            ->_setActiveMenu('itaniumextensions/itanium_menu')
            ->_addBreadcrumb(Mage::helper('katai_reports')->__('Katai'),
                Mage::helper('katai_reports')->__('Katai'))
            ->_addBreadcrumb(Mage::helper('katai_reports')->__('Overview Menu'),
                Mage::helper('katai_reports')->__('Overview Menu'))
        ;
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Katai'))->_title($this->__('Overview Menu'));
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * Check ACL permissins
     *
     * @return bool
     */
    protected function _isAllowed()
    {
//        return true;
        return Mage::getSingleton('admin/session')->isAllowed('report/katai/reports');
    }
}