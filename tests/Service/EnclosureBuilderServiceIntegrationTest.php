<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오후 12:26
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Entity\Security;
use App\Repository\DinosaurRepository;
use App\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();

        $this->truncateEntities();
    }


    public function testItBuildsEnclosureWithDefaltSpecification()
    {

        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        /** @var EnclosureBuilderService $enclosureBuilderService */
//        $enclosureBuilderService = self::$container->get('App\Service\EnclosureBuilderService');

        $dinoRepository = $this->createMock(DinosaurRepository::class);
        $dinoRepository->expects($this->any())
            ->method('growFromSpecification')
            ->willReturnCallback(function($spec){
                return new Dinosaur();
            });

        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoRepository
        );

        $enclosureBuilderService->buildEnclosure();

        $em = $this->getEntityManager();


        $count = (int) $em->getRepository(Security::class)
                          ->createQueryBuilder('s')
                          ->select('COUNT(s.id)')
                          ->getQuery()
                          ->getSingleScalarResult();

        $this->assertSame(1,$count, 'Amount of security systems is no the same');


        $count = (int) $em->getRepository(Dinosaur::class)
                          ->createQueryBuilder('d')
                          ->select('COUNT(d.id)')
                          ->getQuery()
                          ->getSingleScalarResult();

        $this->assertSame(3,$count, 'Amount of dinosaurs is no the same');

    }

    // just copy this method! :)
    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
                               ->get('doctrine')
                               ->getManager();

    }
    
}