<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Speaker\Setup;

use Magento\Eav\Setup\EavSetup as BaseSetup;

class EavSetup extends BaseSetup
{
    /**
     * Delete attribute from set.
     *
     * @param int|string $entityTypeId
     * @param int|string $setId
     * @param int|string $attributeId
     *
     * @return \Wagento\Speaker\Setup\EavSetup
     */
    public function deleteAttributeFromSet($entityTypeId, $setId, $attributeId)
    {
        $setId = $this->getAttributeSetId($entityTypeId, $setId);
        $attributeId = $this->getAttributeId($entityTypeId, $attributeId);
        $table = $this->getSetup()->getTable('eav_entity_attribute');

        $where = [
            'attribute_set_id = ?' => $setId,
            'attribute_id = ?' => $attributeId,
        ];

        $this->getSetup()->getConnection()
            ->delete($table, $where);

        return $this;
    }
}
