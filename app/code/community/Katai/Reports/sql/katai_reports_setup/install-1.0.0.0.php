<?php
/**
 * File: install-1.0.0.0.php
 *
 * User: Mitch Vanderlinden
 * email: magento@mitchvdl.be
 * Date: 15.09.15 16:06
 * Package: Katai_Reports
 */

/** @var Katai_Reports_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('katai_reports/entity'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_BIGINT, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Event Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Store Id')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Report Title')
    ->addColumn('sql_query', Varien_Db_Ddl_Table::TYPE_TEXT, Varien_Db_Ddl_Table::MAX_TEXT_SIZE, array(
        'nullable'  => false,
    ), 'SQL Query')
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
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '1',
    ), 'Defines Is Entity Active')
    ->addIndex($installer->getIdxName('katai_reports/entity', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('katai_reports/entity', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Reports Entity Table');
$installer->getConnection()->createTable($table);


$installer->endSetup();