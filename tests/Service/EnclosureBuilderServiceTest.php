<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오전 9:34
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Repository\DinosaurRepository;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $em->expects($this->atLeastOnce())
            ->method('flush');

        $dinoRepository = $this->createMock(DinosaurRepository::class);

        $dinoRepository->expects($this->exactly(2))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'))
        ;

        $builder = new EnclosureBuilderService($em, $dinoRepository);
        $enclouser = $builder->buildEnclosure(1,2);

        $this->assertCount(1,$enclouser->getSecurities());
        $this->assertCount(2,$enclouser->getDinosaurs());

//        dump($enclouser->getDinosaures()->toArray());
    }
}