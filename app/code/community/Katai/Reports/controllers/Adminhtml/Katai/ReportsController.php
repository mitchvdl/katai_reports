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
            ->_addBreadcrumb($this->__('Katai'),
                $this->__('Katai'))
            ->_addBreadcrumb($this->__('Overview Reports'),
                $this->__('Overview Menu'))
        ;
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Katai'))->_title($this->__('Overview Reports'));
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * New Action.
     * Forward to Edit Action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }
    /**
     * Edit Action
     */
    public function editAction()
    {
        $rate = $this->_initReport();
        $this->_title($rate->getId() ? sprintf("Edit Report #%s", $rate->getId()) : $this->__('New Report'));
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * Initialize rate object
     *
     * @return Katai_Reports_Model_Entity
     */
    protected function _initReport()
    {
        $this->_title($this->__('Katai'))->_title($this->__('Overview Reports'));
        $reportId = $this->getRequest()->getParam('entity_id', 0);
        $report = Mage::getModel('katai_reports/entity');
        if ($reportId) {
            $report->load($reportId);
        }
        Mage::register('current_katai_report_entity', $report);
        return $report;
    }





    /**
     * Save Action
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $report = $this->_initReport();
            if ($this->getRequest()->getParam('report_id') && ! $report->getId()) {
                return $this->_redirect('*/*/');
            }
            $report->addData($data);
            try {
                $report->save();
                $this->_getSession()->addSuccess(Mage::helper('katai_reports')->__('The report has been saved.'));
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($this->__('Cannot save Repoport.'));
                return $this->_redirect('*/*/edit', array('report_id' => $report->getId(), '_current' => true));
            }
        }
        return $this->_redirect('*/*/');
    }
    /**
     * Delete Action
     */
    public function deleteAction()
    {
        $report = $this->_initReport();
        if ($report->getId()) {
            try {
                $report->delete();
                $this->_getSession()->addSuccess(Mage::helper('katai_reports')->__('The report has been deleted.'));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('_current' => true));
                return;
            }
        }
        return $this->_redirect('*/*/');
    }

    /**
     * Validate Action
     *
     */
    public function validateAction()
    {
        $response = new Varien_Object(array('error' => false));
        $post     = $this->getRequest()->getPost();
        $message  = null;
        if (!isset($post['title']) || !isset($post['sql_query'])) {
            $message = $this->__('Please enter all Report information.');
        } else {

        }
        if ($message) {
            $this->_getSession()->addError($message);
            $this->_initLayoutMessages('adminhtml/session');
            $response->setError(true);
            $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
        }
        $this->getResponse()->setBody($response->toJson());
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