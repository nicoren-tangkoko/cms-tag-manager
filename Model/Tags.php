<?php

namespace MageSuite\CmsTagManager\Model;

class Tags extends \Magento\Catalog\Model\AbstractModel implements \MageSuite\CmsTagManager\Api\Data\TagsInterface
{

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $storeManager, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('MageSuite\CmsTagManager\Model\ResourceModel\Tags');
    }

    /**
     * @return mixed
     */
    public function getCmsPageId()
    {
        return $this->getData('cms_page_id');
    }

    /**
     * @param string $cmsPageId
     * @return \Magento\Framework\DataObject
     */
    public function setCmsPageId($cmsPageId)
    {
        return $this->setData('cms_page_id', $cmsPageId);
    }

    /**
     * @return mixed
     */
    public function getTagName()
    {
        return $this->getData('tag_name');
    }

    /**
     * @param $tagName
     * @return \Magento\Framework\DataObject
     */
    public function setTagName($tagName)
    {
        return $this->setData('tag_name', $tagName);
    }


}