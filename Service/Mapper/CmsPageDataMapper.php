<?php
namespace MageSuite\CmsTagManager\Service\Mapper;

class CmsPageDataMapper
{
    /**
     * @var \Magento\Cms\Helper\Page
     */
    private $cmsPageHelper;
    /**
     * @var \MageSuite\ContentConstructorFrontend\Service\MediaResolver
     */
    private $mediaResolver;

    public function __construct(
        \Magento\Cms\Helper\Page $cmsPageHelper,
        \MageSuite\ContentConstructorFrontend\Service\MediaResolver $mediaResolver
    )
    {
        $this->cmsPageHelper = $cmsPageHelper;
        $this->mediaResolver = $mediaResolver;
    }

    public function mapPage($page)
    {
        $url = false;
        if($page->getCmsImageTeaser()) {
            $url = $page->getCmsTeaserImageUrl();
        }
        $pagesData = [
            'id' => $page->getId(),
            'headline' => $page->getTitle(),
            'href' => $this->cmsPageHelper->getPageUrl($page->getId()),
            'image' => [
                'src' => $url ? $url :'',
                'srcSet' => $url ? $this->mediaResolver->resolveSrcSet($url) : ''
            ],
            'displayVariant' => 2
        ];

        return $pagesData;
    }
}