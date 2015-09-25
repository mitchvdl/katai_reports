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

    public function convertDataTypeDDL($type)
    {
        switch ($type) {
            case Varien_Db_Ddl_Table::TYPE_TIME:
            case Varien_Db_Ddl_Table::TYPE_DATETIME:
                $type = 'datetime';
                break;
            case Varien_Db_Ddl_Table::TYPE_DATE:
                $type = 'date';
                break;
            case Varien_Db_Ddl_Table::TYPE_CHAR:
            case Varien_Db_Ddl_Table::TYPE_TEXT:
            case Varien_Db_Ddl_Table::TYPE_VARCHAR:
            case Varien_Db_Ddl_Table::TYPE_LONGVARCHAR:
            case Varien_Db_Ddl_Table::TYPE_CLOB:
                $type = 'text';
                break;

            case Varien_Db_Ddl_Table::TYPE_TINYINT:
            case Varien_Db_Ddl_Table::TYPE_DOUBLE:
            case Varien_Db_Ddl_Table::TYPE_REAL:
            case Varien_Db_Ddl_Table::TYPE_FLOAT:
                $type = 'number';
                break;
            case Varien_Db_Ddl_Table::TYPE_BOOLEAN:
                $type = 'select';
                break;

            default:
                $type = 'text';
                break;
        }
        return $type;
    }


    /**
     * Return the key mappings to build the adming grid based on the collection item
     * @param Varien_Object $element
     * @return array
     */
    public function getTempMappingDdl($element)
    {
        $fields = [];
        foreach ( array_keys($element) as $_idx => $key ){
            $fields[$key] = [
                'data_type' => Varien_Db_Ddl_Table::TYPE_TEXT,
                'label' => $key,
                'code' => $key,
                'position' => $_idx
            ];
        }

        return $fields;
    }

}