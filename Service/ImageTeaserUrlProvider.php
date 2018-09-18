<?php
namespace MageSuite\CmsTagManager\Service;

class ImageTeaserUrlProvider
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
    }

    public function getCmsTeaserUrl($image = null)
    {
        if (!$image) {
            return '';
        }

        $mediaUrl = $this->storeManager
            ->getStore()
            ->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            );

        return sprintf("%scmsteaser/%s", $mediaUrl, $image);
    }
}