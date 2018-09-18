<?php
namespace MageSuite\CmsTagManager\Test\Integration\Service\Admin;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class ImageTeaserDataProviderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\CmsTagManager\Service\Admin\ImageTeaserDataProvider
     */
    protected $imageTeaserDataProvider;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $filesystem;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->imageTeaserDataProvider = $this->objectManager->create(\MageSuite\CmsTagManager\Service\Admin\ImageTeaserDataProvider::class);

        $this->filesystem = $this->objectManager->create(\Magento\Framework\Filesystem::class);
    }

    /**
     * @magentoDbIsolation enabled
     */
    public function testItReturnsImageDataCorrectly()
    {
        $response = $this->imageTeaserDataProvider->getImageData('magento_image.jpg');

        $this->assertArrayHasKey('url', $response[0]);
        $this->assertArrayHasKey('name', $response[0]);

        $this->assertEquals('http://localhost/pub/media/cmsteaser/magento_image.jpg', $response[0]['url']);
        $this->assertEquals('magento_image.jpg', $response[0]['name']);
    }
}