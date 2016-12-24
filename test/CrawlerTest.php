<?php

declare(strict_types=1);

namespace Smochin\HowOld;

use GuzzleHttp\Promise\PromiseInterface;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Crawler
     */
    private $crawler;

    protected function setUp()
    {
        $this->crawler = new Crawler();
    }

    public function testAnalyze()
    {
        $result = $this->crawler->analyze('https://pbs.twimg.com/profile_images/558109954561679360/j1f9DiJi.jpeg');
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('Faces', $result);
        $this->assertCount(1, $result['Faces']);
        $this->assertArrayHasKey('attributes', $result['Faces'][0]);
        $this->assertArrayHasKey('gender', $result['Faces'][0]['attributes']);
        $this->assertArrayHasKey('age', $result['Faces'][0]['attributes']);
        $this->assertEquals('Male', $result['Faces'][0]['attributes']['gender']);
        $this->assertEquals(60, $result['Faces'][0]['attributes']['age']);
    }

    /**
     * @expectedException \Smochin\HowOld\Exception\FacesNotDetectedException
     */
    public function testFacesNotDetectedException()
    {
        $this->crawler->analyze('http://www.underconsideration.com/brandnew/archives/google_2015_logo_detail.png');
    }

    /**
     * @expectedException \GuzzleHttp\Exception\GuzzleException
     */
    public function testGuzzleException()
    {
        $this->crawler->analyze('https://compass-ssl.microsoft.com/assets/bc/84/bc84e95b-76b9-4b24-ad5f-9748a2d75b1b.svg?n=microsoft_account_logo_color.svg');
    }

    public function testAnalyzeAsync()
    {
        $promise = $this->crawler->analyzeAsync('https://pbs.twimg.com/profile_images/558109954561679360/j1f9DiJi.jpeg');
        $this->assertInstanceOf(PromiseInterface::class, $promise);
    }
}
