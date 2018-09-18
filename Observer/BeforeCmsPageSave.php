<?php
namespace MageSuite\CmsTagManager\Observer;

class BeforeCmsPageSave implements \Magento\Framework\Event\ObserverInterface
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

        $imageTeaserData = $pageObject->getData('cms_image_teaser');

        if ($imageTeaserData && isset($imageTeaserData[0]['name'])) {
            $pageObject->setData('cms_image_teaser', $imageTeaserData[0]['name']);
        }
    }
}