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

    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaluts
        $codeName = 'InG-' . random_int(1,99999);
        $length = $this->getLengthFromSpecification($specification);
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


    private function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            '😱' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE, 'max' => Dinosaur::HUGE - 1],
        ];
        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;

        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);

            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];

                break;
            }
        }

        return random_int($minLength, $maxLength);
    }

 }
