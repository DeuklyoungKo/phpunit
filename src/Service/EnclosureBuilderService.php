<?php

namespace App\Service;

use App\Entity\Enclosure;
use App\Entity\Security;
use App\Repository\DinosaurRepository;
use Doctrine\ORM\EntityManagerInterface;

class EnclosureBuilderService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DinosaurRepository
     */
    private $dinosaurRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DinosaurRepository $dinosaurRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->dinosaurRepository = $dinosaurRepository;
    }

    public function buildEnclosure(
        int $numberOfSecuritySystems = 1,
        int $numberOfDinosaurs = 3
    ): Enclosure
    {
        $enclosure = new Enclosure();

        $this->addSecuritySystems($numberOfSecuritySystems, $enclosure);

        $this->addDinosaurs($numberOfDinosaurs, $enclosure);

        $this->entityManager->persist($enclosure);
        $this->entityManager->flush();

        return $enclosure;
    }

    private function addSecuritySystems(int $numberOfSecuritySystems, Enclosure $enclosure)
    {
        for ($i = 0; $i < $numberOfSecuritySystems; $i++) {
            $securityName = array_rand(['Fence', 'Electric fence', 'Guard tower']);
            $security = new Security($securityName, true, $enclosure);

            $enclosure->addSecurity($security);
        }
    }

    private function addDinosaurs(int $numberOfDinosaurs, Enclosure $enclosure)
    {

        for ($i = 0; $i < $numberOfDinosaurs; $i++ ) {
            $length = array_rand(['small', 'large', 'huge']);
            $diet = array_rand(['herbivore', 'carnivorous']);
            $specification = "{$length} {$diet} dinosaur";
            $dinosaur = $this->dinosaurRepository->growFromSpecification($specification);

            $enclosure->addDinosaur($dinosaur);
        }

    }
}
