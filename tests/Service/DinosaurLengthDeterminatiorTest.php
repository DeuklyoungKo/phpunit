<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오전 1:14
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminatior;
use PHPUnit\Framework\TestCase;

class DinosaurLengthDeterminatiorTest extends TestCase
{

    /**
     * @dataProvider getSpecLengthTests
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determinator = new DinosaurLengthDeterminatior();
        $actualSize = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize);
    }

    public function getSpecLengthTests()
    {
        return [
            // specification, min Length, max length
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            'default response' => ['give me all the cookies', 0, Dinosaur::LARGE],
            ['large berbivore', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            ['huge dinosaur', Dinosaur::HUGE, 100],
            ['huge dino', Dinosaur::HUGE, 100],
            ['huge', Dinosaur::HUGE, 100],
            ['OMG', Dinosaur::HUGE, 100],
            ['😱', Dinosaur::HUGE, 100],
        ];
    }
}