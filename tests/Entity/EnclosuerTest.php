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
        $enclosure = new Enclosure();

        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaures());
    }
}