<?php

namespace App\Entity;

use App\Repository\PupilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PupilRepository::class)
 */
class Pupil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=4)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=ClassSchool::class, inversedBy="pupils")
     * @ORM\JoinColumn(nullable=false)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=9)
     * @Assert\NotBlank
     * @Assert\Length(min=9, max=9)
     */
    private $phone_to_parents;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Choice({"m", "f"})
     */
    private $sex;

    /**
     * @ORM\OneToMany(targetEntity=CourseGrades::class, mappedBy="pupil")
     */
    private $grades;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->grades = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getClass(): ?ClassSchool
    {
        return $this->class;
    }

    public function setClass(?ClassSchool $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getPhoneToParents(): ?string
    {
        return $this->phone_to_parents;
    }

    public function setPhoneToParents(string $phone_to_parents): self
    {
        $this->phone_to_parents = $phone_to_parents;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * @return Collection|CourseGrades[]
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(CourseGrades $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->setPupil($this);
        }

        return $this;
    }

    public function removeGrade(CourseGrades $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getPupil() === $this) {
                $grade->setPupil(null);
            }
        }

        return $this;
    }
}
