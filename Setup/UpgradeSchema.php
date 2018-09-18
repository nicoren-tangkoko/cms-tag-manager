<?php

namespace MageSuite\CmsTagManager\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(
        \Magento\Framework\Setup\SchemaSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    )
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            if (!$setup->getConnection()->tableColumnExists($setup->getTable('cms_page'), 'cms_page_tags')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('cms_page'),
                    'cms_page_tags',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'Page Tags'
                    ]
                );
            }
        }

        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            if (!$setup->getConnection()->isTableExists($setup->getTable('cms_page_tags'))) {
                $table = $setup->getConnection()->newTable(
                    $setup->getTable('cms_page_tags')
                )->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'Entity ID'
                )
                    ->addColumn(
                        'cms_page_id',
                        \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        null,
                        ['unsigned' => true, 'nullable' => false, 'primary' => true],
                        'CMS Page Id'
                    )
                    ->addColumn(
                        'tag_name',
                        \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        64,
                        [],
                        'Tag Name'
                    );
                $setup->getConnection()->createTable($table);
            }
        }

        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            if (!$setup->getConnection()->tableColumnExists($setup->getTable('cms_page'), 'cms_image_teaser')) {
                $setup->getConnection()->addColumn(
                    $setup->getTable('cms_page'),
                    'cms_image_teaser',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length' => 255,
                        'comment' => 'Image Teaser'
                    ]
                );
            }
        }

        $setup->endSetup();
    }
}