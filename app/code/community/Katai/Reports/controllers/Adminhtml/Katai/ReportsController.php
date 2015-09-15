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

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('reports/katai/reports');
        $this->renderLayout();
    }

    /**
     * Check ACL permissins
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
//        return Mage::getSingleton('admin/session')->isAllowed('katai/reports');
    }
}