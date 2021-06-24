<?php

namespace App\Entity;

use App\Repository\CourseGradesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseGradesRepository::class)
 */
class CourseGrades
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $grades = [];

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=Pupil::class, inversedBy="grades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pupil;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrades(): ?array
    {
        return $this->grades;
    }

    public function setGrades(?array $grades): self
    {
        $this->grades = $grades;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPupil(): ?Pupil
    {
        return $this->pupil;
    }

    public function setPupil(?Pupil $pupil): self
    {
        $this->pupil = $pupil;

        return $this;
    }
}
