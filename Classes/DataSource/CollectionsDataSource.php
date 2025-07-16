<?php

declare(strict_types=1);

namespace Wegmeister\MediaProperties\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Flow\Persistence\PersistenceManagerInterface;
use Neos\Media\Domain\Model\AssetCollection;
use Neos\Media\Domain\Repository\AssetCollectionRepository;
use Neos\Utility\TypeHandling;

class CollectionsDataSource extends AbstractDataSource
{
    /** @var AssetCollectionRepository */
    #[Flow\Inject]
    protected $assetCollectionRepository;

    /** @var PersistenceManagerInterface */
    #[Flow\Inject]
    protected $persistenceManager;

    /** @var string */
    static protected $identifier = 'dwm-collections';

    /**
     * Get all asset collections.
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(?NodeInterface $node = null, array $arguments = [])
    {

        $collections = $this->assetCollectionRepository->findAll();

        // Build the collections-array for the return
        $data = [];
        foreach ($collections as $collection) {
            $data[] = [
                'label' => $collection->getLabel(),
                'value' => [
                    '__identity' => $this->persistenceManager->getIdentifierByObject($collection),
                    '__type' => AssetCollection::class,
                ],
            ];
        }

        return $data;
    }
}
