<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use App\Repository\ClassSchoolRepository;
use App\Repository\TeacherRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture implements DependentFixtureInterface
{
    private $classRepo;
    private $teacherRepo;

    public function __construct(ClassSchoolRepository $classRepo, TeacherRepository $teacherRepo)
    {
        $this->classRepo = $classRepo;
        $this->teacherRepo = $teacherRepo;
    }

    public function load(ObjectManager $manager)
    {
        //1. lisacmoore@rhyta.com
        $teacher = $this->teacherRepo->findOneBy(['email' => 'lisacmoore@rhyta.com']);

        $subject = new Subject();
        $subject->setName('math');
        $subject->setTeacher($teacher);
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('math');
        $subject->setTeacher($teacher);
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('math');
        $subject->setTeacher($teacher);
        $subject->setClass($this->classRepo->findOneBy(['name' => '2A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('form period');
        $subject->setTeacher($teacher);
        $subject->setClass($this->classRepo->findOneBy(['name' => '2A']));
        $manager->persist($subject);

        //2. barndonp@gmail.com
        $subject = new Subject();
        $subject->setName('biology');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'barndonp@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('biology');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'barndonp@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('form period');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'barndonp@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        //3. travisred@gmail.com
        $subject = new Subject();
        $subject->setName('ethics');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'travisred@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('philosophy');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'travisred@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('ethics');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'travisred@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('form period');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'travisred@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('philosophy');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'travisred@gmail.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        //5. benbradley@rhyta.com
        $subject = new Subject();
        $subject->setName('geography');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'benbradley@rhyta.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1A']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('geography');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'benbradley@rhyta.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '1C']));
        $manager->persist($subject);

        $subject = new Subject();
        $subject->setName('geography');
        $subject->setTeacher($this->teacherRepo->findOneBy(['email' => 'benbradley@rhyta.com']));
        $subject->setClass($this->classRepo->findOneBy(['name' => '2A']));
        $manager->persist($subject);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeacherFixtures::class,
        ];
    }
}
