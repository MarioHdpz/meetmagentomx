<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Setup;


use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    const SPONSORS_TYPES = 'sponsors_types';
    const SPONSORS = 'sponsors';
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable(self::SPONSORS_TYPES));
        $installer->getConnection()->dropTable($installer->getTable(self::SPONSORS));

        /*
         * Create table sponsors_types
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable(self::SPONSORS_TYPES))
            ->addColumn(
                'sponsors_type_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Sponsors Type Id'
            )->addColumn(
                'title',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Title'
            )->addColumn(
                'required_sponsors',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Required Sponsors'
            )->addColumn(
                'column',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Column'
            )->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Status'
            )->addColumn(
                'sort_order',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Sort Order'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Update At'
            )->addIndex(
                $setup->getIdxName(
                    $installer->getTable(self::SPONSORS_TYPES),
                    ['title'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )->setComment('SPONSORS TYPES TABLE');

        $installer->getConnection()->createTable($table);

        /*
        * Create table magetitans_sponsors
        */
        $table = $installer->getConnection()
            ->newTable($installer->getTable(self::SPONSORS))
            ->addColumn(
                'sponsors_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Sponsors Id'
            )->addColumn(
                'sponsors_type_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => true, 'nullable' => true],
                'Sponsors Type Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Name'
            )->addColumn(
                'url_key',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Url Key'
            )->addColumn(
                'image',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Image'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Status'
            )->addColumn(
                'position',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => true],
                'Position'
            )->addColumn(
                'created_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => true],
                'Update At'
            )->addIndex(
                $installer->getIdxName(self::SPONSORS, ['sponsors_type_id']),
                ['sponsors_type_id']
            )->addIndex(
                $setup->getIdxName(
                    $installer->getTable(self::SPONSORS),
                    ['name', 'url_key'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name', 'url_key'],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            )->addForeignKey(
                $installer->getFkName(self::SPONSORS, 'sponsors_type_id', self::SPONSORS_TYPES, 'sponsors_type_id'),
                'sponsors_type_id',
                $installer->getTable(self::SPONSORS_TYPES),
                'sponsors_type_id',
                Table::ACTION_CASCADE
            )->setComment(
                'SPONSORS TABLE'
            );

        $installer->getConnection()->createTable($table);
        $installer->endSetup();

    }
}