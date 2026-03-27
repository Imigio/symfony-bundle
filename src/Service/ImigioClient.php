<?php

declare(strict_types=1);

namespace Imigio\Service;

use GuzzleHttp\Client;
use Imigio\Exception\AccessDeniedImigioException;
use Imigio\Exception\BadRequestImigioException;
use Imigio\Exception\ConflictImigioException;
use Imigio\Exception\ImigioException;
use Imigio\Exception\NotFountImigioException;
use Imigio\Exception\UnauthorizedImigioException;
use Imigio\Exception\UnprocessableEntityImigioException;
use Imigio\Service\Dto\RelationResponse;
use Imigio\Service\Dto\ResponseInterface;
use Imigio\Service\Dto\StorageResponse;
use Imigio\Service\Dto\StorageTypeResponse;
use Imigio\Service\Dto\UploadRequest;
use Symfony\Component\HttpFoundation\Response;

class ImigioClient
{
    private ?Client $client = null;

    public function __construct(
        private readonly string $apiKey,
    )
    {}

    private function getClient(): Client
    {
        if (null === $this->client) {
            $this->client = new Client([
                'base_uri' => 'https://imig.io/api',
                'headers'  => [
                    'Authorization' => $this->apiKey,
                ],
            ]);
        }

        return $this->client;
    }

    public function upload(UploadRequest $uploadInput): StorageResponse
    {
        $response = $this->getClient()->request('POST', '/api/storage/upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($uploadInput->getFile()->getPathname(), 'r'),
                ],
                [
                    'name' => 'relationName',
                    'contents' => $uploadInput->getRelationName(),
                ],
                [
                    'name' => 'relationId',
                    'contents' => $uploadInput->getRelationId(),
                ],
            ],
        ]);

        return $this->deserializeObject($response, StorageResponse::class);
    }

    public function fetchStorage(string $id): StorageResponse
    {
        $response = $this->getClient()->request('GET', '/api/storage/' . $id, [

        ]);

        return $this->deserializeObject($response, StorageResponse::class);
    }

    public function fetchRelations(): array
    {
        $response = $this->getClient()->request('GET', '/api/relation-names', [

        ]);

        return $this->deserializeCollection($response, RelationResponse::class);
    }

    /** @var ResponseInterface $responseClass */
    private function deserializeCollection($response, string $responseClass): array
    {
        $this->handleErrors($response);

        $contents = json_decode((string)$response->getBody(), true);

        $relations = [];

        foreach ($contents as $content) {
            $relations[] = $responseClass::fromArray($content);
        }

        return $relations;
    }

    /** @var ResponseInterface $responseClass */
    private function deserializeObject($response, string $responseClass): ResponseInterface
    {
        $this->handleErrors($response);

        $contents = json_decode((string)$response->getBody(), true);

        return $responseClass::fromArray($contents);
    }

    private function handleErrors($response): void
    {
        $exception = match ($response->getStatusCode()) {
            Response::HTTP_BAD_REQUEST => BadRequestImigioException::class,//400
            Response::HTTP_UNAUTHORIZED => UnauthorizedImigioException::class,//401
            Response::HTTP_FORBIDDEN => AccessDeniedImigioException::class,//403
            Response::HTTP_NOT_FOUND => NotFountImigioException::class,//404
            Response::HTTP_CONFLICT => ConflictImigioException::class,//409
            Response::HTTP_UNPROCESSABLE_ENTITY => UnprocessableEntityImigioException::class,//422

            Response::HTTP_BAD_GATEWAY,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            Response::HTTP_TOO_MANY_REQUESTS,
            Response::HTTP_REQUEST_TIMEOUT,
            Response::HTTP_SERVICE_UNAVAILABLE => ImigioException::class,
            default => null,
        };

        if ($exception) {
            throw new $exception;
        }
    }

    public function fetchStorageTypes(): array
    {
        $response = $this->getClient()->request('GET', '/api/storage-types', [

        ]);

        return $this->deserializeCollection($response, StorageTypeResponse::class);
    }

    public function deleteStorageByFilename(?string $filename): bool
    {
        if (null === $filename) {
            return false;
        }

        $response = $this->getClient()->request('DELETE', '/api/storage/filename/' . $filename);

        $this->handleErrors($response);

        return true;
    }
}
