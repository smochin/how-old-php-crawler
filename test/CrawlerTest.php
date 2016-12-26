<?php

declare(strict_types=1);

namespace Smochin\HowOld;

use GuzzleHttp\Promise\PromiseInterface;
use Smochin\HowOld\ValueObject\Face;

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
        $faces = $this->crawler->analyze('https://pbs.twimg.com/profile_images/558109954561679360/j1f9DiJi.jpeg');
        $this->assertInternalType('array', $faces);
        $this->assertCount(1, $faces);
        $this->assertInstanceOf(Face::class, $faces[0]);
        $this->assertTrue($faces[0]->isMale());
        $this->assertEquals(60, $faces[0]->getAge());
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
