<?php

namespace App\ApiClient\Google;

use App\Data\CoordinatesData;
use Illuminate\Support\Facades\Http;

class GoogleApiClient
{
    private const ADDRESS_ENDPOINT_FORMAT = 'address=%s';
    private CoordinatesDataMapper $coordinatesDataMapper;
    private string $baseUrl;
    private string $apiKey;

    public function __construct(CoordinatesDataMapper $coordinatesDataMapper, string $baseUrl, string $apiKey)
    {
        $this->coordinatesDataMapper = $coordinatesDataMapper;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function getCoordinatesForCity(string $cityName): CoordinatesData
    {
        $baseUrlWithApikey = $this->getBaseUrlWithApikey();

        $url = $baseUrlWithApikey . sprintf(
                self::ADDRESS_ENDPOINT_FORMAT,
                $cityName
            );

        return $this->coordinatesDataMapper->map(Http::get($url));
    }

    private function getBaseUrlWithApikey(): string
    {
        return sprintf(
            '%skey=%s&',
            $this->baseUrl,
            $this->apiKey
        );
    }
}
