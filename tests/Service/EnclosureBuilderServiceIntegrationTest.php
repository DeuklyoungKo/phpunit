<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-10
 * Time: 오후 12:26
 */

namespace App\Tests\Service;


use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use App\Entity\Security;
use App\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function setUp()
    {
        self::bootKernel();

        $this->truncateEntities([
            Enclosure::class,
            Security::class,
            Dinosaur::class,
        ]);
    }


    public function testItBuildsEnclosureWithDefaltSpecification()
    {



        // returns the real and unchanged service container
        $container = self::$kernel->getContainer();

        // gets the special container that allows fetching private services
        $container = self::$container;

        $enclosureBuilderService = self::$container->get('App\Service\EnclosureBuilderService');

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
    private function truncateEntities(array $entities)
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();

        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }

        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );

            $connection->executeUpdate($query);
        }

        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
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