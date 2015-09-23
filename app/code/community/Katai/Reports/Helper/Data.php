<?php
/**
 * File: Data.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 16:05
 * Package: Katai_Reports
 */

class Katai_Reports_Helper_Data extends Mage_Core_Helper_Abstract
{

    const XML_PATH_CONTENT_TEMPLATE_FILTER = 'global/katai_reports/content/tempate_filter';


    /**
     * Retrieve template processor for catalog content
     *
     * @return Katai_Reports_Model_Template_Filter
     */
    public function getProcessor()
    {
        $model = (string)Mage::getConfig()->getNode(self::XML_PATH_CONTENT_TEMPLATE_FILTER);
//        return Mage::getModel($model);
        return Mage::getModel($model);
    }

    /**
     * Parse data in required Json string
     * @param $data
     * @return String
     */
    public function arrayToDataTable($data)
    {
       return [
           ['Galaxy', 'Distance', 'Brightness'],
           ['Canis Major Dwarf', 8000, 23.3],
           ['Sagittarius Dwarf', 24000, 4.5],
           ['Ursa Major II Dwarf', 30000, 14.3],
           ['Lg. Magellanic Cloud', 50000, 0.9],
           ['Bootes I', 60000, 13.1]
       ];
    }

}