# Imigio Symfony Bundle

## install

```
 {
  ...
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/Imigio/symfony-bundle.git"
    }
  ]
  ...
}
```

```
{
  ...
  "require": [
    "imigio/imigio-bundle": "0.*",
  ],
  ...
}
```


## Configuration

`config/packages/imigio.yaml`:

```yaml
imigio:
    token: ...
    relations:
        relationName: App\Entity\Relation
```


## Listener

Events:
- Imigio\Event\ImigioFileUploaded
- Imigio\Event\ImigioFileDeleted

Example:
`src/Listener/ImigioRelationListener`:

```php
<?php

declare(strict_types=1);

namespace App\Listener\Imigio;

use App\Entity\Relation;
use Doctrine\Persistence\ManagerRegistry;
use Imigio\Event\ImigioFileUploaded;
use Imigio\Service\ImigioClient;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
readonly class ImigioRelationListener
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private ImigioClient $imigioClient,
    )
    {}

    public function __invoke(ImigioFileUploaded $imigioFileUploaded): void
    {
        if (!$imigioFileUploaded->getRelation() instanceof Relation) {
            return;
        }

        if ($imigioFileUploaded->getStorageResponse()->getRelationName() !== 'relationName') {
            return;
        }

        /** @var Relation $relation */
        $relation = $imigioFileUploaded->getRelation();

        if ($relation->getImigioFilename()) {
            $this->imigioClient->deleteStorageByFilename($relation->getImigioFilename());
        }

        $relation->setImigioFilename($imigioFileUploaded->getStorageResponse()->getFilename8());

        $this->managerRegistry->getManager()->flush();
    }
}
```
