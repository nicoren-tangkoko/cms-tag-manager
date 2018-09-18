<?php
namespace MageSuite\CmsTagManager\Service\Processor;

class UploadTeaser
{
    protected $uploaderFactory;
    protected $directoryList;
    protected $filesystem;
    protected $storeManager;
    protected $brand;
    /**
     * @var \MageSuite\Frontend\Service\Image\Resizer
     */
    private $resizer;
    /**
     * @var \MageSuite\CmsTagManager\Service\ImageTeaserUrlProvider
     */
    private $imageTeaserUrlProvider;


    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MageSuite\Frontend\Service\Image\Resizer $resizer,
        \MageSuite\CmsTagManager\Service\ImageTeaserUrlProvider $imageTeaserUrlProvider
    )
    {
        $this->uploaderFactory = $uploaderFactory;
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
        $this->resizer = $resizer;
        $this->imageTeaserUrlProvider = $imageTeaserUrlProvider;
    }

    public function processUpload()
    {
        if(!isset($_FILES) && !$_FILES['cms_image_teaser']['name']) {
            $result = ['error' => __('Image file has been not uploaded'), 'errorcode' => __('Image file has been not uploaded')];
            return $result;
        }

        $imageFieldName = array_keys($_FILES);

        $uploader = $this->uploaderFactory->create(['fileId' => $imageFieldName[0]]);

        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'svg']);

        $uploader->setAllowRenameFiles(false);

        $uploader->setFilesDispersion(false);

        $path = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
            ->getAbsolutePath('cmsteaser/');

        $result = $uploader->save($path);

        $imagePath = $uploader->getUploadedFileName();


        if (!$result) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $this->resizer->createThumbs($path . $imagePath);

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);

        $result['url'] = $this->imageTeaserUrlProvider->getCmsTeaserUrl($imagePath);

        $result['name'] = $result['file'];


        return $result;
    }
}