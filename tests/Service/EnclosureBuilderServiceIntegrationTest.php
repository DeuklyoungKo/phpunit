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
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{

    public function testItBuildsEnclosureWithDefaltSpecification()
    {


        self::bootKernel();

        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        $enclosureBuilderService = self::$container->get('App\Service\EnclosureBuilderService');


        $enclosureBuilderService->buildEnclosure();

        /** @var EntityManager $em */
        $em = self::$kernel->getContainer()
                     ->get('doctrine')
                     ->getManager();

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
}