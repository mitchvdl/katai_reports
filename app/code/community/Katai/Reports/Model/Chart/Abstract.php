<?php
/**
 * File: Abstract.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 22.09.15 18:12
 * Package: Katai_Reports
 */

abstract class Katai_Reports_Model_Chart_Abstract extends Varien_Object
{
    /**
     * Return default options for a chart type
     * @return array
     */
    abstract public function getDefaultOptions();

    /**
     * Chart code is a unique identifier for charts
     * @return String
     */
    abstract public function getChartCode();

    /**
     * Chart label for display purposes only
     * @return String
     */
    abstract public function getLabel();
}