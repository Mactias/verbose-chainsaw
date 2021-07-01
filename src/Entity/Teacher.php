<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use function array_search;
use function in_array;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher implements UserInterface
{
    public const ROLE_EDUCATOR = 'ROLE_EDUCATOR';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *      message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 6,
     *      max = 250,
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=9)
     * @Assert\Regex(
     *      pattern="/^(\d){9}$/",
     *      message="phone number must contain 9 numbers!"
     * )
     */
    private $phone_number;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\NotBlank(message="select at lest one subject!")
     */
    private $subject = [];

    /**
     * @ORM\OneToOne(targetEntity=ClassSchool::class, inversedBy="tutor", cascade={"persist", "remove"})
     */
    private $aclass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role)
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
    }

    public function removeRole(string $role)
    {
        $key = array_search($role, $this->roles);
        unset($this->roles[$key]);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getSubject(): ?array
    {
        return $this->subject;
    }

    public function setSubject(?array $subject): self
    {
        foreach ($subject as $key => $value) {
            if ($value === null) {
                unset($subject[$key]);
            }
        }

        $this->subject = $subject;

        return $this;
    }

    public function getAclass(): ?ClassSchool
    {
        return $this->aclass;
    }

    public function setAclass(?ClassSchool $aclass): self
    {
        $this->aclass = $aclass;

        return $this;
    }
}
