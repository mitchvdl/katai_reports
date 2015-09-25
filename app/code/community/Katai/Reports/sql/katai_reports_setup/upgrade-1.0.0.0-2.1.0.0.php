<?php
/**
 * File: upgrade-1.0.0.0-2.1.0.0.php
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
    ->newTable($installer->getTable('katai_reports/role'))
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
    ->addColumn('role_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Role Id')
    ->addIndex($installer->getIdxName('katai_reports/role', array('report_id')),
        array('report_id'))
    ->addForeignKey($installer->getFkName('katai_reports/entity', 'report_id', 'katai_reports/entity', 'report_id'),
        'report_id', $installer->getTable('katai_reports/entity'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Reports Role Table permissions');
$installer->getConnection()->createTable($table);


$installer->endSetup();