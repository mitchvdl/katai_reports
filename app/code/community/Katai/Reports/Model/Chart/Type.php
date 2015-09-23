<?php
/**
 * File: Type.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 22.09.15 18:06
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Chart_Type
{

    protected $_chartTypes = [];

    /**
     * Register a chartype
     *
     * @param string $code
     * @param Varien_Object $chart
     * @return $this
     */
    public function registerChartType($code, Varien_Object $chart)
    {
        $this->_chartTypes[$code] = $chart;
        return $this;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }

    /**
     *  Get options in "key-value" format
     *
     * @param bool|false $multiselect
     * @return array
     */
    public function toOptionArray($multiselect = false)
    {

    }
}