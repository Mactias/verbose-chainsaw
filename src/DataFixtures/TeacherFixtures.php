<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use App\Repository\ClassSchoolRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    private $passwordEncoder;
    private $classRepo;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ClassSchoolRepository $classRepo)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->classRepo = $classRepo;
    }

    public function load(ObjectManager $manager)
    {
        $teacher = new Teacher();
        $teacher->setName('Admin');
        $teacher->setEmail('admin@admin.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, 'admin'));
        $teacher->setPhoneNumber('000000000');
        $teacher->setRoles(['ROLE_SUPER_ADMIN']);
        /* $teacher->setSubject([]); */
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Lisa Moore");
        $teacher->setEmail('lisacmoore@rhyta.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('443591975');
        $teacher->setRoles(["ROLE_EDUCATOR"]);
        $teacher->setSubject(["philosophy"]);
        $teacher->setAclass($this->classRepo->findOneBy(['name' => '2A']));
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Brandon Parman");
        $teacher->setEmail('barndonp@gmail.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('310448740');
        $teacher->setRoles(["ROLE_EDUCATOR"]);
        $teacher->setSubject(["biology"]);
        $teacher->setAclass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Travis Redman");
        $teacher->setEmail('travisred@gmail.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('415451078');
        $teacher->setRoles(["ROLE_EDUCATOR"]);
        $teacher->setSubject(["math"]);
        $teacher->setAclass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName('Ben Bradley');
        $teacher->setEmail('benbradley@rhyta.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070694257');
        /* $teacher->setRoles([]); */
        $teacher->setSubject(["physical education"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Jordan O'Sullivan");
        $teacher->setEmail('jordanosullivan@armyspy.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070161660');
        /* $teacher->setRoles([]); */
        $teacher->setSubject(["chemistry"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Francesca Dickinson");
        $teacher->setEmail('francescadickinson@teleworm.us');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070386521');
        /* $teacher->setRoles([]); */
        $teacher->setSubject(["French"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Abby Hooper");
        $teacher->setEmail('abbyhooper@armyspy.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('078422995');
        /* $teacher->setRoles([]); */
        $teacher->setSubject(["grammar"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Dominic Goodwin");
        $teacher->setEmail('dominicgoodwin@jourrapide.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070543128');
        /* $teacher->setRoles([]); */
        $teacher->setSubject(["informatics"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("James Martin");
        $teacher->setEmail('JamesMartin@teleworm.us');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('254355108');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["geography"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Dylan Power");
        $teacher->setEmail('dylanpower@rhyta.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070691117');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["history"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Katie Bibi");
        $teacher->setEmail('bibi1@gmail.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070786437');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["economics"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Harry Hall");
        $teacher->setEmail('harryhall@dayrep.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070786437');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["biology"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Francesca Chadwick");
        $teacher->setEmail('francescach@teleworm.us');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('070373164');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["Hebrew"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Lily Jenkins");
        $teacher->setEmail('lilyjenkins@jourrapide.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('079392887');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["German", "Greek"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Rebecca Gallagher");
        $teacher->setEmail('rebbgallagher@teleworm.us');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('079632980');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["chemistry"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Alexandra Norris");
        $teacher->setEmail('alexandrann@armyspy.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('078151663');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["art history", "history"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Oliver Andrews");
        $teacher->setEmail('oliverandrews@rhyta.com');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('079602970');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["astronomy"]);
        $manager->persist($teacher);

        $teacher = new Teacher();
        $teacher->setName("Elizabeth Wilson");
        $teacher->setEmail('elizabethwilson@teleworm.us');
        $teacher->setPassword($this->passwordEncoder->encodePassword($teacher, '123456'));
        $teacher->setPhoneNumber('079592850');
        /* $teacher->setRoles([""]); */
        $teacher->setSubject(["physics"]);
        $manager->persist($teacher);

        $manager->flush();
    }
}
