<?php

declare(strict_types=1);

namespace Imigio\Action;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Imigio\Event\ImigioFileDeleted;
use Imigio\Service\ImigioClient;
use Imigio\Service\ImigioRelationMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ImigioDeleteAction
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private ImigioClient $imigioClient,
        private ImigioRelationMapping $imigioRelationMapping,
        private EventDispatcherInterface $eventDispatcher,
    )
    {}

    #[Route(
        '/imigio/delete',
        name: 'route_imigio_delete',
        methods: ['POST','DELETE'],
    )]
    public function __invoke(Request $request): Response
    {
        $relationName = $request->request->get('relationName');

        if (!$relationName) {
            throw new BadRequestHttpException();
        }

        $entityClassNamespace = $this->imigioRelationMapping->getClassNamespace($relationName);

        if (null === $entityClassNamespace) {
            throw new BadRequestHttpException('Unable to define relation');
        }

        $relationId = (string)$request->request->get('relationId');

        $object = $this->managerRegistry
            ->getRepository($entityClassNamespace)
            ->find($relationId)
        ;

        if (null === $object) {
            throw new NotFoundHttpException('Relation not found');
        }

        $filename = (string)$request->request->get('filename');

        try {
            $storageResponse = $this->imigioClient->deleteStorageByFilename($filename);
        }
        catch (Exception $e) {
            throw new BadRequestHttpException('Imigio delete failed');
        }

        $this->eventDispatcher->dispatch(new ImigioFileDeleted($filename, $object));

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
