<?php

namespace App\Entity;

use App\Repository\ClassSchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use function array_search;

/**
 * @ORM\Entity(repositoryClass=ClassSchoolRepository::class)
 */
class ClassSchool
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(min=2)
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

    public const EMPTY_TIMETABLE = '{"monday":{"mox":"Mo", "mo0":"", "mo1":"", "mo2":"", "mo3":"", "mo4":"", "mo5":"", "mo6":"", "mo7":"", "mo8":"", "mo9":"", "mo10":""},"tuesday":{"tux":"Tu", "tu0":"", "tu1":"", "tu2":"", "tu3":"", "tu4":"", "tu5":"", "tu6":"", "tu7":"", "tu8":"", "tu9":"", "tu10":""},"wednesday":{"wex":"We", "we0":"", "we1":"", "we2":"", "we3":"", "we4":"", "we5":"", "we6":"", "we7":"", "we8":"", "we9":"", "we10":""},"thursday":{"thx":"Th", "th0":"", "th1":"", "th2":"", "th3":"", "th4":"", "th5":"", "th6":"", "th7":"", "th8":"", "th9":"", "th10":""},"friday":{"frx":"Fr", "fr0":"", "fr1":"", "fr2":"", "fr3":"", "fr4":"", "fr5":"", "fr6":"", "fr7":"", "fr8":"", "fr9":"", "fr10":""}}';

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

    public static function decodeEmptyTimetableToArray()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->decode(ClassSchool::EMPTY_TIMETABLE, 'json');
    }

    public function getTutor(): ?Teacher
    {
        return $this->tutor;
    }

    public function setTutor(?Teacher $tutor): self
    {
        // unset the owning side of the relation if necessary
        if ($tutor === null && $this->tutor !== null) {
            $this->tutor->setAclass(null);

            $roles = $this->tutor->getRoles();
            $key = array_search(Teacher::ROLE_EDUCATOR, $roles);
            unset($roles[$key]);
        }

        // set the owning side of the relation if necessary
        if ($tutor !== null && $tutor->getAclass() !== $this) {
            $tutor->setAclass($this);
        }

        $this->tutor = $tutor;

        return $this;
    }
}
