<?php

namespace App\DataFixtures;

use App\Entity\ClassSchool;
use App\Entity\CourseGrades;
use App\Repository\ClassSchoolRepository;
use App\Repository\PupilRepository;
use App\Repository\SubjectRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use function random_int;

class CourseGradesFixtures extends Fixture implements DependentFixtureInterface
{
    private $classRepo;
    private $pupilRepo;
    private $subjectRepo;

    public function __construct(ClassSchoolRepository $classRepo, PupilRepository $pupilRepo, SubjectRepository $subjectRepo)
    {
        $this->classRepo = $classRepo;
        $this->pupilRepo = $pupilRepo;
        $this->subjectRepo = $subjectRepo;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        /* $class1A = $this->classRepo->findOneBy(['name' => '1A']); */
        /* $subject = $this->subjectRepo->findOneBy(['name' => 'math', 'class' => $class1A]); */
        /* $pupils = $this->pupilRepo->findBy(['class' => $class1A]); */

        /* foreach ($pupils as $pupil) { */
        /*     $grades = new CourseGrades(); */
        /*     $grades->setSubject($subject); */
        /*     $grades->setPupil($pupil); */
        /*     $grades->setGrades(['-3', '2', '-4']); */
        /*     $manager->persist($grades); */
        /* } */
        $class1A = $this->classRepo->findOneBy(['name' => '1A']);
        $subjects = $this->subjectRepo->findBy(['class' => $class1A]);
        $pupils = $this->pupilRepo->findBy(['class' => $class1A]);

        $gr = [];
        $list = [1, 2, 3, 4, 5, '-2', '+2', '-3', '+3', '-4', '+4', '-5', '+5', 6];
        foreach ($subjects as $subject) {
            foreach ($pupils as $pupil) {
                $gr[0] = $list[random_int(0, count($list) - 1)];
                $gr[1] = $list[random_int(0, count($list) - 1)];
                $gr[2] = $list[random_int(0, count($list) - 1)];
                $gr[3] = $list[random_int(0, count($list) - 1)];
                $grades = new CourseGrades();
                $grades->setSubject($subject);
                $grades->setPupil($pupil);
                $grades->setGrades($gr);

                $manager->persist($grades);
            }
        }

        $class1A = $this->classRepo->findOneBy(['name' => '1C']);
        $subjects = $this->subjectRepo->findBy(['class' => $class1A]);
        $pupils = $this->pupilRepo->findBy(['class' => $class1A]);

        $gr = [];
        $list = [1, 2, 3, 4, 5, '-2', '+2', '-3', '+3', '-4', '+4', '-5', '+5', 6];
        foreach ($subjects as $subject) {
            foreach ($pupils as $pupil) {
                $gr[0] = $list[random_int(0, count($list) - 1)];
                $gr[1] = $list[random_int(0, count($list) - 1)];
                $gr[2] = $list[random_int(0, count($list) - 1)];
                $gr[3] = $list[random_int(0, count($list) - 1)];
                $grades = new CourseGrades();
                $grades->setSubject($subject);
                $grades->setPupil($pupil);
                $grades->setGrades($gr);

                $manager->persist($grades);
            }
        }

        $class1A = $this->classRepo->findOneBy(['name' => '2A']);
        $subjects = $this->subjectRepo->findBy(['class' => $class1A]);
        $pupils = $this->pupilRepo->findBy(['class' => $class1A]);

        $gr = [];
        $list = [1, 2, 3, 4, 5, '-2', '+2', '-3', '+3', '-4', '+4', '-5', '+5', 6];
        foreach ($subjects as $subject) {
            foreach ($pupils as $pupil) {
                $gr[0] = $list[random_int(0, count($list) - 1)];
                $gr[1] = $list[random_int(0, count($list) - 1)];
                $gr[2] = $list[random_int(0, count($list) - 1)];
                $gr[3] = $list[random_int(0, count($list) - 1)];
                $grades = new CourseGrades();
                $grades->setSubject($subject);
                $grades->setPupil($pupil);
                $grades->setGrades($gr);

                $manager->persist($grades);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PupilFixtures::class,
            SubjectFixtures::class,
        ];
    }
}
