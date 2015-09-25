<?php
/**
 * File: Chart.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 25.09.15 22:54
 * Package: Katai_Reports
 */

class Katai_Reports_Helper_Chart extends Mage_Core_Helper_Abstract
{
    const DATA_TYPE_NUMBER = 'number';
    const DATA_TYPE_STRING = 'string';
    const DATA_TYPE_DATE = 'date';

    /**
     * Transform any collection into a Google Visualsation Datatable
     *
     * By specifying array $cols for the columns the data can be better described
     *
     * @see https://developers.google.com/chart/interactive/docs/reference#DataTable
     * @param Varien_Data_Collection $collection
     * @param array $cols optional
     * @return stdClass
     */
    public function collectionToDataTable(Varien_Data_Collection $collection, $cols = [])
    {
        $dataTable = [];
        if ( count($cols) == 0 ) {
            foreach ( array_keys($collection->getFirstItem()->getData()) as $key ) {
                $cols[] = (Object) ['id' => $key, 'label' => $key, 'type' => self::DATA_TYPE_STRING];
            }
        }
        $dataTable['cols'] = $cols;
        $rows = [];

        /** @var Varien_Object $data */
        foreach ($collection as $data) {
            $rows['c'][] =(Object) array_map( function ($v) {return (Object) ['v' => $v];}, array_values($data->getData()));
        }

        $dataTable['rows'] = $rows;
        return (Object) $dataTable;
    }
}