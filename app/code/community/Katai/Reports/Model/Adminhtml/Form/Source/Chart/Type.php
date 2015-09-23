<?php
/**
 * File: Type.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 22.09.15 18:06
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Adminhtml_Form_Source_Chart_Type extends Varien_Object
{
    protected $_chartTypes = [];

    protected function _construct()
    {
        parent::_construct();

        $bar = Mage::getSingleton('katai_reports/chart_bar');
        $this->registerChartType($bar->getChartCode(), $bar);
    }


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
     *  Get options in "key-value" format
     *
     * @param bool|false $multiselect
     * @return array
     */
    public function toOptionArray($multiselect = false)
    {
        $charts = [];
        foreach ( $this->_chartTypes as $code => $chart ) {
            $charts[$code] = $chart->getLabel();
        }
        return $charts;
    }
}