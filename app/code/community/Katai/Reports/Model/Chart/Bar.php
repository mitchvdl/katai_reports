<?php
/**
 * File: Bar.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 23.09.15 15:48
 * Package: Katai_Reports
 */

class Katai_Reports_Model_Chart_Bar extends Katai_Reports_Model_Chart_Abstract
{
    public function getDefaultOptions()
    {
        return [
            'chart' => [
                'title' => Mage::helper('katai_reports')->__('Chart Bar'),
                'subtitle' => Mage::helper('katai_reports')->__('Chart subtitle'),
            ],
            'bars' => 'horizontal',
        ];
    }

    public function getChartCode()
    {
        return 'google_bar_horizontal';
    }

    public function getLabel()
    {
        return 'Google Horizontal Bar Chart';
    }


}