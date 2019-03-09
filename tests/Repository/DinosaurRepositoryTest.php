<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-09
 * Time: 오후 6:58
 */

namespace App\Tests\Repository;


use App\Entity\Dinosaur;
use App\Repository\DinosaurRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DinosaurRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    /**
     * @var DinosaurRepository
     */
    private $repository;

    public function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
                                      ->get('doctrine')
                                      ->getManager();

        $this->repository = $this->entityManager->getRepository(Dinosaur::class);

    }
    
    public function testItGrowsAVelociraptor()
    {

        $dinosaur = $this->repository->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5,$dinosaur->getLength());
    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waitng for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby');
        }

        $dinosaur = $this->repository->growVelociraptor(1);
        $this->assertSame(1,$dinosaur->getLength());
    }
}