<?php
namespace MageSuite\CmsTagManager\Plugin;

class AroundFilterByTag
{
    /**
     * @var \MageSuite\CmsTagManager\Api\TagsRepositoryInterface
     */
    private $tagsRepository;
    /**
     * @var \MageSuite\CmsTagManager\Model\TagsFactory
     */
    private $tagsFactory;

    public function __construct(
        \MageSuite\CmsTagManager\Api\TagsRepositoryInterface $tagsRepository,
        \MageSuite\CmsTagManager\Model\TagsFactory $tagsFactory
    )
    {
        $this->tagsRepository = $tagsRepository;
        $this->tagsFactory = $tagsFactory;
    }

    public function aroundAddFieldToFilter(\Magento\Cms\Model\ResourceModel\Page\Collection $subject, callable $proceed, $field, $condition)
    {
        if($field != 'cms_page_tags'){
            return $proceed($field, $condition);
        }

        $pageIds = $this->tagsRepository->getCmsPageIdsByTags($condition['in']);
        $subject->addFieldToFilter('page_id', ['in' => $pageIds]);

        return $subject;
    }
}
