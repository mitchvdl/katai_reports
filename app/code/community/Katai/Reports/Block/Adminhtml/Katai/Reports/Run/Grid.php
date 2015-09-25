<?php
/**
 * File: Grid.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:52
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Run_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Internal constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('kataiReportsRunGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(true);
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

    /**
     * Prepare grid collection object
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Run_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Katai_Reports_Model_Resource_Report_Collection */
        $collection = Mage::getModel('katai_reports/report');
        $collection = $collection->getCollection()
            ->setReport($this->getReport());
        $collection->load();
        $this->setCollection($collection);
        return $this->setCollection($collection);
    }

    protected function _prepareGrid()
    {
        $this->_prepareMassactionBlock();
        $this->_prepareCollection();
        $this->_prepareColumns();
        return $this;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->unsetChild('search_button');
        $this->unsetChild('reset_filter_button');

    }


    /**
     * Prepare grid columns
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Grid
     */
    protected function _prepareColumns()
    {
        /** @var Katai_Reports_Helper_Data $helper */
        $helper = Mage::helper('katai_reports');

        /** @var Array $selectFields */
        $selectFields = $this->getReport()->getSelectFields();
        if ( count($selectFields) == 0 ) {
//            Zend_Debug::dump($this->getCollection());
            $selectFields = $helper->getTempMappingDdl($this->getCollection()->getFirstItem()->getData());
        }

        foreach ( $selectFields as $key => $fields ) {
            $type = $helper->convertDataTypeDDL($fields['data_type']);
            if ( $type == 'select') {
                // add options for true/false
                $this->addColumn($key, [
                    'header' => $helper->__($fields['label']),
                    'align'  => 'left',
                    'type'  => $type,
                    'index'  => $key,
                    'width'  => '100',
                    'options' => ['1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')],
                    'order' => $fields['position'],
                    'sortable' => false,
                    'filter' => false,
                ]);
            } else {
                $this->addColumn($key, [
                    'header' => $helper->__($fields['label']),
                    'align'  => 'left',
                    'type'  => $type,
                    'index'  => $key,
                    'width'  => '100',
                    'order' => $fields['position'],
                    'sortable' => false,
                    'filter' => false,
                ]);
            }

        }
        // Get report data fields from mapping
        $this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));

        Mage::dispatchEvent('adminhtml_katai_reports_run_prepare_columns', array('grid' => $this));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     *
     * @return string
     */
    public function getGridUrl()
    {
        return false;
    }

}