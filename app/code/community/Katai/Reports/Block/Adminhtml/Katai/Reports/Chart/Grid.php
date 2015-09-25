<?php
/**
 * File: Grid.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:52
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Chart_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Internal constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('kataiReportsChartGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(true);
    }


    /**
     * Prepare grid collection object
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Katai_Reports_Model_Resource_Chart_Collection */
        $collection = Mage::getModel('katai_reports/chart')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('katai_reports')->__('ID'),
            'align'  => 'left',
            'index'  => 'entity_id',
            'width'  => '100',
        ));

        $this->addColumn('report_id', array(
            'header'  => Mage::helper('katai_reports')->__('Report Id'),
            'index'   => 'report_id',
//            'width'  => '200',
        ));
        $this->addColumn('chart_type', array(
            'header'  => Mage::helper('katai_reports')->__('Chart Type'),
            'index'   => 'chart_type',
            'width'  => '200',
        ));

//        $this->addColumn('is_active', array(
//            'header'  => Mage::helper('katai_reports')->__('Active'),
//            'index'   => 'is_active',
//            'type'      => 'options',
//            'width'  => '100',
//            'options'   => ['1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')],
//        ));

        $this->addColumn('created_at', array(
            'header'  => Mage::helper('katai_reports')->__('Created At'),
            'index'   => 'created_at',
            'type'      => 'datetime',
            'width'  => '100',
        ));

        $this->addColumn('updated_at', array(
            'header'  => Mage::helper('katai_reports')->__('Updated At'),
            'index'   => 'updated_at',
            'type'      => 'datetime',
            'width'  => '100',
        ));


        Mage::dispatchEvent('adminhtml_katai_reports_chart_prepare_columns', array('grid' => $this));

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }

    /**
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

}