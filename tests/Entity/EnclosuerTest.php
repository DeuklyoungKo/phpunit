<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-09
 * Time: 오후 11:01
 */

namespace App\Tests\Entity;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffertException;
use PHPUnit\Framework\TestCase;

class EnclosuerTest extends TestCase
{
    public function testItHasNoDinosaursByDefalut()
    {
        $enclosure = new Enclosure();

        $this->assertEmpty($enclosure->getDinosaures());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);

        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaures());
    }

    public function testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffertException::class);

        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
    }

    /**
     * @expectedException \App\Exception\NotABuffertException
     */
    public function testItDoesNotAllowToAddNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
        $enclosure->addDinosaur(new Dinosaur());
    }


    public function testItDoesNotAllowToAddDinosaursToUnsecrueEnclosures()
    {
        $enclosure = new Enclosure();

        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you craaazy?!?');

        $enclosure->addDinosaur(new Dinosaur());
    }
}