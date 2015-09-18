<?php
/**
 * File: upgrade-1.0.0.0-1.0.1.0.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Package: Katai_Reports
 */

/** @var Katai_Reports_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('katai_reports/entity_store'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Report Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Store Id')
    ->addIndex($installer->getIdxName('katai_reports/entity_store', array('entity_id', 'store_id')), array('entity_id', 'store_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_PRIMARY))
    ->addForeignKey($installer->getFkName('katai_reports/entity', 'entity_id', 'katai_reports/entity', 'entity_id'),
        'entity_id', $installer->getTable('katai_reports/entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('katai_reports/entity', 'store_id', 'katai_reports/entity', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Reports visible in stores');
$installer->getConnection()->createTable($table);


$installer->endSetup();