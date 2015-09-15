<?php
/**
 * File: IndexController.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 16:52
 * Package: Katai_Reports
 */

class Katai_Reports_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
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