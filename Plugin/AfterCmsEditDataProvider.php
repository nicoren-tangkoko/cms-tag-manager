<?php
namespace MageSuite\CmsTagManager\Plugin;

class AfterCmsEditDataProvider
{
    /**
     * @var \MageSuite\Opengraph\Service\Admin\CmsImageDataProvider
     */
    protected $cmsImageDataProvider;

    public function __construct(\MageSuite\Opengraph\Service\Admin\CmsImageDataProvider $cmsImageDataProvider)
    {
        $this->cmsImageDataProvider = $cmsImageDataProvider;
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

        $imageTeaserDataArray = $this->cmsImageDataProvider->getImageData($pageData['cms_image_teaser'], \MageSuite\CmsTagManager\Model\ImageTeaser::CMS_IMAGE_TEASER_PATH);

        $result[$pageData['page_id']]['cms_image_teaser'] = $imageTeaserDataArray;

        return $result;
    }
}