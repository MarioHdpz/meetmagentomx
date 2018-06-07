<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\Speaker\Setup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Catalog\Setup\CategorySetupFactory;

class InstallData implements InstallDataInterface {

    /**
     * Attribute set factory.
     *
     * @var \Magento\Eav\Model\Entity\Attribute\SetFactory
     */
    private $attributeSetFactory;
    

    /**
     * Category setup factory.
     *
     * @var \Magento\Catalog\Setup\CategorySetupFactory
     */
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavSetup
     */
    private $eavAttribute;

    /**
     * @var \Magento\Eav\Api\AttributeRepositoryInterface
     */
    private $attributeRepository;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute
     * @param \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository
     */


    private $categorySetupFactory;

    public function __construct( AttributeSetFactory $attributeSetFactory,
                                 CategorySetupFactory $categorySetupFactory,
                                 \Wagento\Speaker\Setup\EavSetupFactory $eavSetupFactory,
                                 \Magento\Eav\Model\ResourceModel\Entity\Attribute $eavAttribute,
                                 \Magento\Eav\Api\AttributeRepositoryInterface $attributeRepository)
    {
                    $this->attributeSetFactory = $attributeSetFactory;
                    $this->categorySetupFactory = $categorySetupFactory;
                    $this->eavSetupFactory = $eavSetupFactory;
                    $this->eavAttribute = $eavAttribute;
                    $this->attributeRepository = $attributeRepository;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $speakerAttributeSet = $this->addAttributeSet($setup, $context, 'Speaker');

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $entityType = \Magento\Catalog\Model\Product::ENTITY;

        $keynote_speaker_enabled = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'keynote_speaker');
        if (!$keynote_speaker_enabled) {
            $eavSetup->addAttribute(
                $entityType,
                'keynote_speaker',
                [
                    'type' => 'int',
                    'label' => 'Keynote Speaker',
                    'input' => 'select',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'backend' => '',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'default' => 0,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, [
                'keynote_speaker',
            ]);
        }

        $speaker_title = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'speaker_title');
        if (!$speaker_title) {
            $eavSetup->addAttribute(
                $entityType,
                'speaker_title',
                [
                    'type' => 'varchar',
                    'label' => 'Speaker Title',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => false,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, ['speaker_title']);
        }

        $website_url = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'website_url');
        if (!$website_url) {
            $eavSetup->addAttribute(
                $entityType,
                'website_url',
                [
                    'type' => 'varchar',
                    'label' => 'Website URL',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, ['website_url']);
        }

        $twitter = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'twitter');
        if (!$twitter) {
            $eavSetup->addAttribute(
                $entityType,
                'twitter',
                [
                    'type' => 'varchar',
                    'label' => 'Twitter',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, ['twitter']);

        }

        $talk_title = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'talk_title');
        if (!$talk_title) {
            $eavSetup->addAttribute(
                $entityType,
                'talk_title',
                [
                    'type' => 'varchar',
                    'label' => 'Talk Title',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, [
                'talk_title',
            ]);
        }

        $workshop_title = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'workshop_title');
        if (!$workshop_title) {
            $eavSetup->addAttribute(
                $entityType,
                'workshop_title',
                [
                    'type' => 'varchar',
                    'label' => 'Workshop Title',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, [
                'workshop_title',
            ]);
        }

        $talk_synopsis = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'talk_synopsis');
        if (!$talk_synopsis) {
            $eavSetup->addAttribute(
                $entityType,
                'talk_synopsis',
                [
                    'type' => 'text',
                    'label' => 'Talk Synopsis',
                    'input' => 'textarea',
                    'sort_order' => 4,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'required' => false,
                    'searchable' => true,
                    'comparable' => true,
                    'wysiwyg_enabled' => true,
                    'is_html_allowed_on_front' => true,
                    'visible_in_advanced_search' => true,
                    'used_in_product_listing' => true,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => false,
                    'is_filterable_in_grid' => false,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, [
                'talk_synopsis',
            ]);
        }
        $view_slides = $this->eavAttribute->getIdByCode(\Magento\Catalog\Model\Product::ENTITY, 'view_slides');
        if (!$view_slides) {
            $eavSetup->addAttribute(
                $entityType,
                'view_slides',
                [
                    'type' => 'varchar',
                    'label' => 'View Slides',
                    'input' => 'text',
                    'required' => false,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible' => true,
                    'user_defined' => true,
                    'used_in_product_listing' => true,
                    'group' => 'Speaker',
                    'attribute_set' => $speakerAttributeSet->getName(),
                ]
            );
            $this->deleteAttributesFromDefaultAttributeSet($setup, $context, [
                'view_slides',
            ]);
        }
        $setup->endSetup();
    }
    /**
     * Add attribute set.
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface   $context
     * @param string                                            $name
     *
     * @return \Magento\Eav\Model\Entity\Attribute\Set
     */
    private function addAttributeSet(ModuleDataSetupInterface $setup, ModuleContextInterface $context, $name)
    {
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $attributeSet = $this->attributeSetFactory->create();

        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);

        $data = [
            'attribute_set_name' => $name,
            'entity_type_id' => $entityTypeId,
            'sort_order' => 200,
        ];

        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

        return $attributeSet;
    }

    /**
     * Delete attributes from default
     * attribute set.
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface   $context
     * @param array                                             $attributes
     */
    private function deleteAttributesFromDefaultAttributeSet(ModuleDataSetupInterface $setup, ModuleContextInterface $context, array $attributes)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);

        foreach ($attributes as $attributeCode) {
            $eavSetup->deleteAttributeFromSet($entityTypeId, $attributeSetId,
                $eavSetup->getAttributeId($entityTypeId, $attributeCode));
        }
    }
}