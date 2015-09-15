<?php
/**
 * File: Grid.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 17:52
 * Package: Katai_Reports
 */

class Katai_Reports_Block_Adminhtml_Katai_Reports_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Internal constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('kataiReportsGrid');
    }


    /**
     * Prepare grid collection object
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Katai_Reports_Model_Resource_Entity_Collection */
        $collection = Mage::getModel('katai_reports/entity')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return Katai_Reports_Block_Adminhtml_Katai_Reports_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('rate_id', array(
            'header' => Mage::helper('katai_reports')->__('ID'),
            'align'  => 'left',
            'index'  => 'rate_id',
            'width'  => 1,
        ));
        $this->addColumn('website_id', array(
            'header'  => Mage::helper('katai_reports')->__('Website'),
            'index'   => 'website_id',
            'type'    => 'options',
//            'options' => Mage::getModel('theam_navigation/source_website')->toOptionArray()
        ));
        $this->addColumn('customer_group_id', array(
            'header'  => Mage::helper('katai_reports')->__('Customer Group'),
            'index'   => 'customer_group_id',
            'type'    => 'options',
//            'options' => Mage::getModel('theam_navigation/source_customer_groups')->toOptionArray()
        ));
        $this->addColumn('rate', array(
            'header'   => Mage::helper('katai_reports')->__('Rate'),
            'filter'   => false,
            'sortable' => false,
            'html_decorators' => 'nobr',
        ));
        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('rate_id' => $row->getId()));
    }
}