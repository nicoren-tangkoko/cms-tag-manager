<?php
namespace MageSuite\CmsTagManager\Plugin;

class AfterCmsEditDataProvider
{
    /**
     * @var \MageSuite\CmsTagManager\Service\Admin\ImageTeaserDataProvider
     */
    private $imageTeaserDataProvider;

    public function __construct(
        \MageSuite\CmsTagManager\Service\Admin\ImageTeaserDataProvider $imageTeaserDataProvider
    )
    {
        $this->imageTeaserDataProvider = $imageTeaserDataProvider;
    }

    public function afterGetData(\Magento\Cms\Model\Page\DataProvider $subject, $result)
    {
        if (!$result) {
           return $result;
        }

        $pageData = reset($result);

        if (!isset($pageData['cms_image_teaser'])) {
            return $result;
        }

        $imageTeaserDataArray = $this->imageTeaserDataProvider->getImageData($pageData['cms_image_teaser']);

        $result[$pageData['page_id']]['cms_image_teaser'] = $imageTeaserDataArray;

        return $result;
    }
}