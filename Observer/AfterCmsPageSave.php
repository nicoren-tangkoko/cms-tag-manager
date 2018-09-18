<?php
namespace MageSuite\CmsTagManager\Observer;

class AfterCmsPageSave implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \MageSuite\CmsTagManager\Service\Processor\SaveTags
     */
    private $saveTagsProcessor;

    public function __construct(
        \MageSuite\CmsTagManager\Service\Processor\SaveTags $saveTagsProcessor
    )
    {
        $this->saveTagsProcessor = $saveTagsProcessor;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pageObject = $observer->getObject();

        $data = [
            'page_id' => $pageObject->getPageId(),
            'page_tags' => $pageObject->getCmsPageTags()
        ];

        $this->saveTagsProcessor->processSave($data);
    }
}