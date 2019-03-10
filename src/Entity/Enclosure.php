<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019-03-09
 * Time: 오후 11:04
 */

namespace App\Entity;


use App\Exception\DinosaursAreRunningRampantException;
use App\Exception\NotABuffertException;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist", "remove"})
     */
    private $dinosaurs;

    /**
     * @var Collection|Security[]
     * @ORM\OneToMany(targetEntity="App\Entity\Security", mappedBy="enclosure", cascade={"persist", "remove"})
     */
    private $securities;




    public function __construct(bool $withBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($withBasicSecurity) {
            $this->addsecurities(new Security('Fence', true, $this));
        }
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

        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffertException();
        }

        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are you craaazy?!?');
        }

        /*
        if (!$this->dinosaurs->contains($dinosaur)) {
            $this->dinosaurs[] = $dinosaur;
            $dinosaur->setEnclosure($this);
        }*/

        $this->dinosaurs[] = $dinosaur;

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



    public function canAddDinosaur(Dinosaur $dinosaur): bool
    {
        return count($this->dinosaurs) === 0 || $this->dinosaurs->first()->isCarnivorous() === $dinosaur->isCarnivorous();
    }

    /**
     * @return Collection|Security[]
     */
    public function getsecurities(): Collection
    {
        return $this->securities;
    }

    public function addsecurities(Security $securities): self
    {
        if (!$this->securities->contains($securities)) {
            $this->securities[] = $securities;
            $securities->setEnclosure($this);
        }

        return $this;
    }

    public function removesecurities(Security $securities): self
    {
        if ($this->securities->contains($securities)) {
            $this->securities->removeElement($securities);
            // set the owning side to null (unless already changed)
            if ($securities->getEnclosure() === $this) {
                $securities->setEnclosure(null);
            }
        }

        return $this;
    }

    public function isSecurityActive(): bool
    {
        foreach ($this->securities as $security){
            if ($security->getIsActive()) {
                return true;
            }
        }

        return false;
    }


    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDinosaurCount(): int
    {
        return $this->dinosaurs->count();
    }
}