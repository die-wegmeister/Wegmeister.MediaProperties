<?php

declare(strict_types=1);

namespace Wegmeister\MediaProperties\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Persistence\PersistenceManagerInterface;
use Neos\Media\Domain\Model\Tag;
use Neos\Media\Domain\Repository\TagRepository;
use Neos\Media\Domain\Repository\AssetCollectionRepository;

class TagsDataSource extends AbstractDataSource
{
    /** @var TagRepository */
    #[Flow\Inject]
    protected $tagRepository;

    /** @var AssetCollectionRepository */
    #[Flow\Inject]
    protected $assetCollectionRepository;

    /** @var PersistenceManagerInterface */
    #[Flow\Inject]
    protected $persistenceManager;

    /** @var string */
    static protected $identifier = 'dwm-tags';

    /**
     * Get tags, optionally filtered by asset collections.
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(?NodeInterface $node = null, array $arguments = [])
    {
        // Check, if we have assetCollections defined to limit the tags
        if (isset($arguments['assetCollections']) && !empty($arguments['assetCollections'])) {

            // If assetCollections are defined,
            // select tags for those assetCollections only
            if (!is_array($arguments['assetCollections'])) {
                $arguments['assetCollections'] = [(string)$arguments['assetCollections']];
            }

            // Get the assetCollections
            $assetCollections = [];
            foreach ($arguments['assetCollections'] as $assetCollection) {
                $assetCollections[] = $this->assetCollectionRepository->findOneByTitle($assetCollection);
            }

            // Get tags that are joined with those assetCollections
            $tags = $this->tagRepository->findByAssetCollections($assetCollections);
        } else {
            // If no assetCollections are defined, select all tags
            $tags = $this->tagRepository->findAll();
        }

        // Build the tags-array for the return
        $data = [];
        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $data[] = [
                'label' => $tag->getLabel(),
                'secondaryLabel' => implode(
                    ', ',
                    $tag->getAssetCollections()->map(function ($assetCollection) {
                        return $assetCollection->getTitle();
                    })->toArray()
                ),
                // 'value' => $tag->getLabel(),
                'value' => $this->persistenceManager->getIdentifierByObject($tag),
            ];
        }

        return $data;
    }
}
