<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오전 10:59
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Repository\DinosaurRepository;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnclosureBuilderServiceProphecyTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->prophesize(EntityManagerInterface::class);

        $em->persist(Argument::type(Enclosure::class))
            ->shouldBeCalledTimes(1);

        $em->flush()->shouldBeCalled();

        $dinoRepository = $this->prophesize(DinosaurRepository::class);

        $dinoRepository->growFromSpecification(Argument::type('string'))
            ->shouldBeCalledTimes(2)
            ->willReturn(new Dinosaur());

        $builder = new EnclosureBuilderService(
            $em->reveal(),
            $dinoRepository->reveal()
        );
        $enclouser = $builder->buildEnclosure(1,2);

        $this->assertCount(1,$enclouser->getSecurities());
        $this->assertCount(2,$enclouser->getDinosaurs());

    }
}