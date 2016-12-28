<?php

declare(strict_types=1);

namespace Smochin\HowOld;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\GuzzleException;
use Smochin\HowOld\Exception\FacesNotDetectedException;
use Smochin\HowOld\Util\JSONParser;
use Smochin\HowOld\Factory\FaceFactory;

class Crawler
{
    const BASE_URI = 'https://how-old.net';
    const ANALYZE_ENDPOINT = '/Home/Analyze';

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => self::BASE_URI]);
    }

    /**
     * @param string $face
     *
     * @return array
     *
     * @throws FacesNotDetectedException
     * @throws GuzzleException
     */
    public function analyze(string $face): array
    {
        $response = $this->client->request('POST', self::ANALYZE_ENDPOINT, [
            'query' => ['faceUrl' => $face],
        ]);
        $body = JSONParser::parse($response->getBody()->getContents());
        if (count($body['Faces']) == 0) {
            throw new FacesNotDetectedException('Couldn\'t detect any faces');
        }

        return array_map(function ($face) {
            return FaceFactory::create($face['attributes']['gender'], (int) round($face['attributes']['age']));
        }, $body['Faces']);
    }

    /**
     * @param string $face
     *
     * @return PromiseInterface
     */
    public function analyzeAsync(string $face): PromiseInterface
    {
        return $this->client->requestAsync('POST', self::ANALYZE_ENDPOINT, [
            'query' => ['faceUrl' => $face],
        ]);
    }
}
