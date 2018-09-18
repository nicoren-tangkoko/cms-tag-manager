<?php

namespace MageSuite\CmsTagManager\Model;

class TagsRepository implements \MageSuite\CmsTagManager\Api\TagsRepositoryInterface
{

    /**
     * @var ResourceModel\Tags\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ResourceModel\Tags
     */
    private $tagsResource;
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    private $cmsPageCollection;
    /**
     * @var \Magento\Cms\Helper\Page
     */
    private $cmsPageHelper;
    /**
     * @var \MageSuite\ContentConstructorFrontend\Service\MediaResolver
     */
    private $mediaResolver;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \MageSuite\CmsTagManager\Model\ResourceModel\Tags\CollectionFactory $collectionFactory,
        \MageSuite\CmsTagManager\Model\ResourceModel\Tags $tagsResource,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $cmsPageCollection,
        \Magento\Cms\Helper\Page $cmsPageHelper,
        \MageSuite\ContentConstructorFrontend\Service\MediaResolver $mediaResolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->tagsResource = $tagsResource;
        $this->cmsPageCollection = $cmsPageCollection;
        $this->cmsPageHelper = $cmsPageHelper;
        $this->mediaResolver = $mediaResolver;
        $this->storeManager = $storeManager;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getTagsByCmsPageId($id)
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->getSelect()->where('cms_page_id =?', $id);

        $pageTags = $tagsCollection->getColumnValues('tag_name');

        return $pageTags;
    }

    /**
     * @param $tagName
     * @return array
     */
    public function getCmsPagesByTagName($tagName)
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->getSelect()->where('tag_name =?', $tagName);

        $cmsPageIds = $tagsCollection->getColumnValues('cms_page_id');

        return $cmsPageIds;
    }

    /**
     * @param $pageId
     * @param $tagName
     * @return \Magento\Framework\DataObject|null
     */
    public function getTag($pageId, $tagName)
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->getSelect()
            ->where('cms_page_id =?', $pageId)
            ->where('tag_name =?', $tagName);

        if($tagsCollection->getSize()){
            return $tagsCollection->getFirstItem();
        }

        return null;
    }

    /**
     * @param \MageSuite\CmsTagManager\Api\Data\TagsInterface $tag
     * @return $this
     */
    public function save(\MageSuite\CmsTagManager\Api\Data\TagsInterface $tag)
    {
        if(!$this->getTag($tag->getCmsPageId(), $tag->getTagName())){
            $this->tagsResource->save($tag);
        }

        return $this;
    }

    /**
     * @param \MageSuite\CmsTagManager\Api\Data\TagsInterface $tag
     * @return $this
     */
    public function delete(\MageSuite\CmsTagManager\Api\Data\TagsInterface $tag)
    {
        if($this->getTag($tag->getCmsPageId(), $tag->getTagName())){
            $this->tagsResource->delete($tag);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAllTags()
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->getSelect()->group('tag_name');

        $availableTags = $tagsCollection->getColumnValues('tag_name');

        return $availableTags;
    }

    /**
     * @param array $tags
     * @return \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    public function getCmsPageCollectionByTags($tags)
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->addFieldToFilter('tag_name', ['in' => $tags]);

        $pagesIds = $tagsCollection->getColumnValues('cms_page_id');

        $collection = $this->cmsPageCollection->create();

        $collection->addFieldToFilter('page_id', ['in' => $pagesIds]);

        return $collection;
    }

    /**
     * @param array $tags
     * @return array
     */
    public function getCmsPageIdsByTags($tags)
    {
        $tagsCollection = $this->collectionFactory->create();

        $tagsCollection->addFieldToFilter('tag_name', ['in' => $tags]);

        $pagesIds = $tagsCollection->getColumnValues('cms_page_id');

        return $pagesIds;
    }
}