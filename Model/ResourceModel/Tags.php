<?php

namespace MageSuite\CmsTagManager\Model\ResourceModel;

class Tags extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('cms_page_tags', 'entity_id');
    }

}