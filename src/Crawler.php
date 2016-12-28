<?php

declare(strict_types=1);

namespace Smochin\HowOld;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\GuzzleException;
use Smochin\HowOld\Exception\FacesNotDetectedException;
use Smochin\HowOld\ValueObject\Face;

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
        $body = self::parseBody($response->getBody()->getContents());
        if (count($body['Faces']) == 0) {
            throw new FacesNotDetectedException('Couldn\'t detect any faces');
        }

        return $this->loadFaces($body['Faces']);
    }

    /**
     * @param array $faces
     *
     * @return array
     */
    public function loadFaces(array $faces): array
    {
        return array_map(function ($face) {
            return new Face($face['attributes']['gender'], (int) round($face['attributes']['age']));
        }, $faces);
    }

    /**
     * @param string $body
     *
     * @return array
     */
    public static function parseBody(string $body): array
    {
        $body = substr($body, 1, -1);
        $body = stripcslashes($body);
        $body = stripcslashes($body);
        $body = str_replace('"[', '[', $body);
        $body = str_replace(']"', ']', $body);

        return json_decode($body, true);
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
