<?php
namespace MageSuite\CmsTagManager\Plugin;

class CmsTeaserImageUrlMethod
{
    /**
     * @var \MageSuite\Opengraph\Service\CmsImageUrlProvider
     */
    protected $cmsImageUrlProvider;

    public function __construct(\MageSuite\Opengraph\Service\CmsImageUrlProvider $cmsImageUrlProvider)
    {
        $this->cmsImageUrlProvider = $cmsImageUrlProvider;
    }

    public function aroundGetData(\Magento\Cms\Model\Page $subject, callable $proceed, $key = '', $index = null)
    {
        if ($key != 'cms_teaser_image_url') {
            return $proceed($key, $index);
        }

        $result = $this->cmsImageUrlProvider->getImageUrl($subject->getCmsImageTeaser(), \MageSuite\CmsTagManager\Model\ImageTeaser::CMS_IMAGE_TEASER_PATH);

        return $result;
    }
}