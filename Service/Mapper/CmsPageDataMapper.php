<?php
namespace MageSuite\CmsTagManager\Service\Mapper;

class CmsPageDataMapper
{
    const CMS_TEASER_MODULE = 'MageSuite_ContentConstructorFrontend';
    const CMS_TEASER_IMAGE_ID = 'cms_teaser_image';
    const CMS_TEASER_IMAGE_ID_2X = 'cms_teaser_image_2x';

    /**
     * @var \Magento\Cms\Helper\Page
     */
    protected $cmsPageHelper;

    /**
     * @var \MageSuite\CmsTagManager\Service\Resize
     */
    protected $imageResize;

    public function __construct(
        \Magento\Cms\Helper\Page $cmsPageHelper,
        \MageSuite\CmsTagManager\Service\Resize $imageResize
    ) {
        $this->cmsPageHelper = $cmsPageHelper;
        $this->imageResize = $imageResize;
    }

    public function mapPage($page)
    {
        $imageUrl = '';

        if ($page->getCmsImageTeaser()) {
            $imageUrl = $this->imageResize->getUrl($page->getCmsTeaserImageUrl(), self::CMS_TEASER_MODULE, self::CMS_TEASER_IMAGE_ID);
        }

        $pagesData = [
            'id' => $page->getId(),
            'headline' => $page->getTitle(),
            'href' => $this->cmsPageHelper->getPageUrl($page->getId()),
            'image' => [
                'src' => $imageUrl,
                'srcSet' => $imageUrl ? $this->imageResize->resolveSrcSet($page->getCmsTeaserImageUrl(), self::CMS_TEASER_MODULE, [self::CMS_TEASER_IMAGE_ID, self::CMS_TEASER_IMAGE_ID_2X]) : ''
            ],
            'displayVariant' => 2
        ];

        return $pagesData;
    }
}
