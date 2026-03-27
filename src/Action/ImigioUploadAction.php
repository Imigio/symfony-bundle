<?php

declare(strict_types=1);

namespace Imigio\Action;

use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Imigio\Event\ImigioFileUploaded;
use Imigio\Service\Dto\UploadRequest;
use Imigio\Service\ImigioClient;
use Imigio\Service\ImigioRelationMapping;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ImigioUploadAction
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private ImigioClient $imigioClient,
        private ImigioRelationMapping $imigioRelationMapping,
        private EventDispatcherInterface $eventDispatcher,
    )
    {}

    #[Route(
        '/imigio/upload',
        name: 'route_imigio_upload',
        methods: ['POST'],
    )]
    public function __invoke(Request $request): Response
    {
        $relationName = $request->request->get('relationName');

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

        $uploadRequest = new UploadRequest(
            $request->files->get('file'),
            $relationName,
            $relationId,
        );

        try {
            $storageResponse = $this->imigioClient->upload($uploadRequest);
        }
        catch (Exception $e) {
            throw new BadRequestHttpException('Imigio upload failed');
        }

        $this->eventDispatcher->dispatch(new ImigioFileUploaded($storageResponse, $object));

//        switch (true) {
//            case $object instanceof Product:
//                $object->setImigioCoverFilename($storageResponse['filename']);
//                break;
//            case $object instanceof Brand:
////                $object->setStorage($data);
//                break;
//        }

//        $this->managerRegistry->getManager()->flush();

        return new JsonResponse($storageResponse->toArray());
    }
}
