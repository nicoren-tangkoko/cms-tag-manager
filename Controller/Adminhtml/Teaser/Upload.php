<?php

namespace MageSuite\CmsTagManager\Controller\Adminhtml\Teaser;

class Upload extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \MageSuite\CmsTagManager\Service\Processor\UploadTeaserFactory
     */
    private $uploadTeaser;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\CmsTagManager\Service\Processor\UploadTeaserFactory $uploadTeaser
    )
    {
        parent::__construct($context);
        $this->uploadTeaser = $uploadTeaser;
    }

    /**
     * @return \Magento\Framework\Controller\ResultFactory
     */
    public function execute()
    {
        try {
            $result = $this->uploadTeaser->create()->processUpload();
        } catch (\Exception $e)
        {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON)->setData($result);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}