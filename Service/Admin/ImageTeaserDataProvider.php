<?php
namespace MageSuite\CmsTagManager\Service\Admin;

class ImageTeaserDataProvider
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \MageSuite\CmsTagManager\Service\ImageTeaserUrlProvider
     */
    private $imageTeaserUrlProvider;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MageSuite\CmsTagManager\Service\ImageTeaserUrlProvider $imageTeaserUrlProvider
    )
    {
        $this->storeManager = $storeManager;
        $this->imageTeaserUrlProvider = $imageTeaserUrlProvider;
    }

    /**
     * @param string $imageName
     * @return array
     */
    public function getImageData($imageName)
    {
        $size = file_exists('media/cmsteaser/' . $imageName) ? filesize('media/cmsteaser/' . $imageName) : 0;

        $url = $this->imageTeaserUrlProvider->getCmsTeaserUrl($imageName);

        $imageData = [
            0 => [
                'url' => $url,
                'name' => $imageName,
                'size' => $size
            ]
        ];

        return $imageData;
    }

}