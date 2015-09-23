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

    protected $_errors = [];

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


    public function runAction()
    {
        /** @var Katai_Reports_Helper_Data $helper */
        $helper = Mage::helper('katai_reports');

        $report = $this->_initReport();

        $processor = $helper->getProcessor();

        echo $processor->filter($report->getSqlQuery());

        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $result = $read->fetchAll($processor->filter($report->getSqlQuery()));

        //Zend_Debug::dump($result);;

        echo $this->getLayout()->createBlock('katai_reports/chart_bar', null, ['result' => $result, 'report' => $report])->toHtml();
    }


    /**
     * Save Action
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost();
        if ($data) {
            $report = $this->_initReport();

            if ($this->getRequest()->getParam('entity_id') && ! $report->getId()) {
                return $this->_redirect('*/*/');
            }
            $report->addData($data);
            Mage::dispatchEvent('katai_report_entity_prepare_save', array('report' => $report, 'request' => $this->getRequest()));

            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('entity_id' => $report->getId(), '_current' => true));
                return $this;
            }


            try {
                $report->save();
                $this->_getSession()->addSuccess(Mage::helper('katai_reports')->__('The report has been saved.'));

                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $report->getId(), '_current'=>true));
                    return $this;
                }

            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($this->__('Cannot save Repoport.'));
                return $this->_redirect('*/*/edit', array('entity_id' => $report->getId(), '_current' => true));
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
        if (!$this->_validatePostData($post) ) {
            $message = $this->__('Please enter all Report information.');
//            $message .= "<br />" . implode($this->getErrors(), '<br />');
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

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if someone item is invalid
     */
    protected function _validatePostData($data)
    {
        $this->_errors = [];

        if (!Zend_Validate::is($data['title'], 'NotEmpty')) {
            $this->_errors[] = $this->__('Please enter a title.');
        }

        if (!Zend_Validate::is($data['sql_query'], 'NotEmpty')) {
            $this->_errors[] = $this->__('Please enter a SQL Query.');
        }
        // TODO : validate the sql_query to see if there are no dangerous keywords in place. This is a pre-check, the final check is performed on the database through a different user if set-up.

        return count($this->_errors) == 0;
    }

    /**
     * Return errors, or else empty array
     * @return array
     */
    protected function getErrors()
    {
        return $this->_errors;
    }
}