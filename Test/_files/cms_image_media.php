<?php
$sourcePath = __DIR__ . '/magento_image.jpg';
$destPath = __DIR__ . '/../../../../../pub/media/' . \MageSuite\CmsTagManager\Model\ImageTeaser::CMS_IMAGE_TEASER_PATH . 'magento_image.jpg';


copy($sourcePath, $destPath);
