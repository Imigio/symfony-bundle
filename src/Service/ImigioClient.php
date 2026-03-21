<?php

declare(strict_types=1);

namespace Imigio\Service;

use GuzzleHttp\Client;
use Imigio\Service\Dto\RelationResponse;
use Imigio\Service\Dto\ResponseInterface;
use Imigio\Service\Dto\StorageResponse;
use Imigio\Service\Dto\StorageTypeResponse;
use Imigio\Service\Dto\UploadRequest;

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

    private function handleErrors($response)
    {
        if ($response->getStatusCode() !== 201) {

        }
    }

    public function fetchStorageTypes(): array
    {
        $response = $this->getClient()->request('GET', '/api/storage-types', [

        ]);

        return $this->deserializeCollection($response, StorageTypeResponse::class);
    }

}
