<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오후 6:09
 */

namespace App\Tests\Controller;

use App\DataFixtures\ORM\LoadBasicParkData;
use App\DataFixtures\ORM\LoadSecurityData;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testEnclosuresAreShownOnTheHomepage()
    {

        $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
            ]);

        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $table = $crawler->filter('.table-enclosures');
        $this->assertCount(3,$table->filter('tbody tr'));
    }

    public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $fixtures = $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class,
        ])->getReferenceRepository();

        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');

        $enclosure = $fixtures->getReference('carnivorous-enclosure');
        $selector = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }
}