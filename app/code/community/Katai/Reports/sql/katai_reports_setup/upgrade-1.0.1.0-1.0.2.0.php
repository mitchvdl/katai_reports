<?php
/**
 * File: upgrade-1.0.1.0-1.0.2.0.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Package: Katai_Reports
 */

/** @var Katai_Reports_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('katai_reports/chart'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Event Id')
    ->addColumn('report_id', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Report Id')
    ->addColumn('chart_type', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Chart Type')
    ->addColumn('custom_options', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE, array(
        'nullable'  => true,
    ), 'Custom Options')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
    ), 'Updated At')

//    ->addIndex($installer->getIdxName('katai_reports/chart', array('entity_id', 'store_id')), array('entity_id', 'store_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY))
    ->addForeignKey($installer->getFkName('katai_reports/chart', 'report_id', 'katai_reports/chart', 'entity_id'),
        'report_id', $installer->getTable('katai_reports/entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
//    ->addForeignKey($installer->getFkName('katai_reports/entity', 'store_id', 'katai_reports/entity', 'store_id'),
//        'store_id', $installer->getTable('core/store'), 'store_id',
//        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Report Charts');
$installer->getConnection()->createTable($table);


$installer->endSetup();