<?php

namespace App\DataFixtures;

use App\Entity\Pupil;
use App\Repository\ClassSchoolRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PupilFixtures extends Fixture
{
    private $classRepo;

    public function __construct(ClassSchoolRepository $classRepo)
    {
        $this->classRepo = $classRepo;
    }

    public function load(ObjectManager $manager)
    {
        $class1A = $this->classRepo->findOneBy(['name' => '1A']);
        $class1C = $this->classRepo->findOneBy(['name' => '1C']);
        $class2A = $this->classRepo->findOneBy(['name' => '2A']);

        //class 2A
        $pupil = new Pupil();
        $pupil->setName("Michael Clayton");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('077549876');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Joanne Hart");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('835779887');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Eileen Zepeda");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('401848166');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Sonia Hardacre");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('764413428');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Anne Sharp");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('781734371');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Joseph Turner");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('572648184');
        $pupil->setClass($class2A);
        $manager->persist($pupil);

        //Class 1C
        $pupil = new Pupil();
        $pupil->setName("Charles Springer");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('286883977');
        $pupil->setClass($class1C);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Fiona Carr");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('897511979');
        $pupil->setClass($class1C);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Steven Marshall");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('975212611');
        $pupil->setClass($class1C);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Abigail Blake");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('684737112');
        $pupil->setClass($class1C);
        $manager->persist($pupil);

        //Class 1A
        $pupil = new Pupil();
        $pupil->setName("Carmen Madrigal");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('305961293');
        $pupil->setClass($class1A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Daniel Alvarez");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('859240701');
        $pupil->setClass($class1A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Frances McKinney");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('218683163');
        $pupil->setClass($class1A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Victor Rampling");
        $pupil->setSex('m');
        $pupil->setPhoneToParents('222594125');
        $pupil->setClass($class1A);
        $manager->persist($pupil);

        $pupil = new Pupil();
        $pupil->setName("Gabrielle Wilkins");
        $pupil->setSex('f');
        $pupil->setPhoneToParents('376668374');
        $pupil->setClass($class1A);
        $manager->persist($pupil);

        $manager->flush();
    }
}
