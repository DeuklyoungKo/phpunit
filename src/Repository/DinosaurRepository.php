<?php

namespace App\Repository;

use App\Entity\Dinosaur;
use App\Service\DinosaurLengthDeterminatior;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Dinosaur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dinosaur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dinosaur[]    findAll()
 * @method Dinosaur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DinosaurRepository extends ServiceEntityRepository
{
    /**
     * @var DinosaurLengthDeterminatior
     */
    private $lengthDeterminatior;

    public function __construct(RegistryInterface $registry, DinosaurLengthDeterminatior $lengthDeterminatior)
    {
        parent::__construct($registry, Dinosaur::class);
        $this->lengthDeterminatior = $lengthDeterminatior;
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaluts
        $codeName = 'InG-' . random_int(1,99999);

        $length = $this->lengthDeterminatior->getLengthFromSpecification($specification);
//        $length = $this->lengthDeterminatior->getLengthFromSpecification('foo');

        $isCarnivorous = false;

        if (strpos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

        return $dinosaur;
    }


    public function createDinosaur(string $genus, bool $isCarnivorous, int $length)
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }


 }
