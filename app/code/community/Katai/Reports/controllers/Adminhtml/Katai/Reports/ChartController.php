<?php
/**
 * File: ChartController.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 24.09.15 19:06
 * Package: Katai_Reports
 */

class Katai_Reports_Adminhtml_Katai_Reports_ChartController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('report/katai/charts')
//            ->_setActiveMenu('itaniumextensions/itanium_menu')
            ->_addBreadcrumb($this->__('Katai'),
                $this->__('Katai'))
            ->_addBreadcrumb($this->__('Overview Charts'),
                $this->__('Overview Menu'))
        ;
        return $this;
    }

    public function testAction()
    {
        $report = Mage::getModel('katai_reports/entity');
        $report->load(1);

        /* @var $collection Katai_Reports_Model_Resource_Report_Collection */
        $collection = Mage::getModel('katai_reports/report');
        $collection = $collection->getCollection()
            ->setReport($report);
        $collection->load();

        echo '<pre>';

        /** @var Katai_Reports_Helper_Chart $helper */
        $helper = Mage::helper('katai_reports/chart');

        echo json_encode( $helper->collectionToDataTable($collection, []) );
        echo date('c');
    }

    public function indexAction()
    {
        $this->_title($this->__('Chart Widget Overview'));
        $this->_initAction()
            ->renderLayout();





        return $this;
    }
}