<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-09
 * Time: 오후 11:04
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Enclosure
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure")
     */
    private $dinosaurs;



    public function __construct()
    {
        $this->dinosaurs = new ArrayCollection();
    }


    public function getDinosaures(): Collection
    {
        return $this->dinosaurs;
    }

    /**
     * @return Collection|Dinosaur[]
     */
    public function getDinosaurs(): Collection
    {
        return $this->dinosaurs;
    }

    public function addDinosaur(Dinosaur $dinosaur): self
    {
        if (!$this->dinosaurs->contains($dinosaur)) {
            $this->dinosaurs[] = $dinosaur;
            $dinosaur->setEnclosure($this);
        }

        return $this;
    }

    public function removeDinosaur(Dinosaur $dinosaur): self
    {
        if ($this->dinosaurs->contains($dinosaur)) {
            $this->dinosaurs->removeElement($dinosaur);
            // set the owning side to null (unless already changed)
            if ($dinosaur->getEnclosure() === $this) {
                $dinosaur->setEnclosure(null);
            }
        }

        return $this;
    }
}