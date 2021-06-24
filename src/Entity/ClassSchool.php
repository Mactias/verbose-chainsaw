<?php

namespace App\Entity;

use App\Repository\ClassSchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassSchoolRepository::class)
 */
class ClassSchool
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Teacher::class, mappedBy="aclass", cascade={"persist", "remove"})
     */
    private $tutor;

    /**
     * @ORM\OneToMany(targetEntity=Pupil::class, mappedBy="class")
     */
    private $pupils;

    /**
     * @ORM\Column(type="json")
     */
    private $timetable = [];

    /**
     * @ORM\Column(type="json")
     */
    private $current_timetable = [];

    /**
     * @ORM\OneToMany(targetEntity=Subject::class, mappedBy="class")
     */
    private $subjects;

    public function __construct()
    {
        $this->pupils = new ArrayCollection();
        $this->subjects = new ArrayCollection();
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

    public function getTutor(): ?Teacher
    {
        return $this->tutor;
    }

    public function setTutor(?Teacher $tutor): self
    {
        // unset the owning side of the relation if necessary
        if ($tutor === null && $this->tutor !== null) {
            $this->tutor->setTutor(null);
        }

        // set the owning side of the relation if necessary
        if ($tutor !== null && $tutor->getTutor() !== $this) {
            $tutor->setTutor($this);
        }

        $this->tutor = $tutor;

        return $this;
    }

    /**
     * @return Collection|Pupil[]
     */
    public function getPupils(): Collection
    {
        return $this->pupils;
    }

    public function addPupil(Pupil $pupil): self
    {
        if (!$this->pupils->contains($pupil)) {
            $this->pupils[] = $pupil;
            $pupil->setClass($this);
        }

        return $this;
    }

    public function removePupil(Pupil $pupil): self
    {
        if ($this->pupils->removeElement($pupil)) {
            // set the owning side to null (unless already changed)
            if ($pupil->getClass() === $this) {
                $pupil->setClass(null);
            }
        }

        return $this;
    }

    public function getTimetable(): ?array
    {
        return $this->timetable;
    }

    public function setTimetable(?array $timetable): self
    {
        $this->timetable = $timetable;

        return $this;
    }

    public function getCurrentTimetable(): ?array
    {
        return $this->current_timetable;
    }

    public function setCurrentTimetable(?array $current_timetable): self
    {
        $this->current_timetable = $current_timetable;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->setClass($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->removeElement($subject)) {
            // set the owning side to null (unless already changed)
            if ($subject->getClass() === $this) {
                $subject->setClass(null);
            }
        }

        return $this;
    }
}
