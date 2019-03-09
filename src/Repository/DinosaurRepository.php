<?php

namespace App\Repository;

use App\Entity\Dinosaur;
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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Dinosaur::class);
    }

    public function growVelociraptor(int $length): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function createDinosaur(string $genus, bool $isCarnivorous, int $length)
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }

 }
