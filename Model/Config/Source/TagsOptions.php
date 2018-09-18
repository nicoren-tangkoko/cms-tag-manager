<?php
namespace MageSuite\CmsTagManager\Model\Config\Source;

class TagsOptions implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var \MageSuite\CmsTagManager\Api\TagsRepositoryInterface
     */
    private $tagsRepository;

    public function __construct(
        \MageSuite\CmsTagManager\Api\TagsRepositoryInterface $tagsRepository
    )
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        $allTags = $this->tagsRepository->getAllTags();

        foreach ($allTags as $tag) {
            $result[] = [
                'value' => $tag,
                'label' => $tag
            ];
        }

        return $result;
    }
}