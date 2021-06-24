<?php

namespace App\Controller;

use App\Entity\CourseGrades;
use App\Entity\ClassSchool;
use App\Entity\Pupil;
use App\Entity\Subject;
use App\Entity\Teacher;
use App\Repository\CourseGradesRepository;
use App\Repository\PupilRepository;
use App\Repository\SubjectRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditEntityController extends AbstractController
{
    private $pupilRepo;
    private $subjectRepo;
    private $div_style;

    public function __construct(PupilRepository $pupilRepo, SubjectRepository $subjectRepo)
    {
        $this->pupilRepo = $pupilRepo;
        $this->subjectRepo = $subjectRepo;

        $this->div_style = "style='font-size: 3.5em'";
    }

    public function createUser(UserPasswordEncoderInterface $encoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $teacher = new Teacher();
        $teacher->setName("Admin");
        $teacher->setEmail('admin4@admin.com');
        $teacher->setPassword($encoder->encodePassword($teacher, 'admin'));
        $teacher->setPhoneNumber('000000000');
        $teacher->setSubject([]);

        $entityManager->persist($teacher);
        $entityManager->flush();
        $entityManager->clear(Teacher::class);

        return new Response("<div {$this->div_style}>created new user {$teacher->getId()} {$this->generateMenuLink()}</div>");
    }

    public function updateUser(UserPasswordEncoderInterface $encoder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager->clear();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $teacher = $entityManager->getRepository(Teacher::class)->find(21);
        /* $teacher->setSubject(['German', 'Greek',]); */
        /* $teacher->setPassword($encoder->encodePassword($teacher, 'qwerty111')); */
        /* $teacher->setRoles(['ROLE_ADMIN',]); */

        /* $entityManager->flush(); */
        $entityManager->clear(Teacher::class);

        $strResponse = "<div {$this->div_style}>success {$this->generateMenuLink()}</div>";
        return new Response($strResponse);
    }

    public function updateAclass(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $class = $entityManager->getRepository(ClassSchool::class)->find(4);
        $class->setTimetable(['mo1'=>'math', 'fr9'=>'biology']);

        $entityManager->flush();
        $entityManager->clear(ClassSchool::class);

        return new Response("<div {$this->div_style}>updated ClassSchool {$class->getId()} {$this->generateMenuLink()}</div>");
    }

    public function createSubject(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();
        
        $multi = false;
        if ($multi) {
            $names = ['geometry', 'chemistry', 'grammar', 'form period', 'ethics', 'Greek', 'Hebrew', 'physical education', 'biology', 'history', 'geography', 'informatics', 'physics',];
            $teachers = [16, 16, 8, 4, 15, 9, 17, 12, 18, 13, 5, 7, 14,];
            if (count($names) != count($teachers)) {
                throw new Exception("tables 'names' and 'teachers' are not equal!");
            }
            for ($i = 0; $i<count($teachers); $i++) {
                $subject = new Subject();
                $subject->setName($names[$i]);
                $subject->setTeacher($entityManager->getRepository(Teacher::class)->find($teachers[$i]));
                $subject->setClass($entityManager->getRepository(ClassSchool::class)->find(3));

                $entityManager->persist($subject);
                $entityManager->flush();
                $entityManager->clear(Subject::class);
            }
        } else {
            $subject = new Subject();
            $subject->setName("geometry");
            $subject->setTeacher($entityManager->getRepository(Teacher::class)->find(13));
            $subject->setClass($entityManager->getRepository(ClassSchool::class)->find(3));

            $entityManager->persist($subject);
            $entityManager->flush();
            $entityManager->clear(Subject::class);
        }

        return new Response("<div {$this->div_style}>created new subject with id={$subject->getId()} {$this->generateMenuLink()}</div>");
    }

    public function createGrades(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();
        
        $grades = new CourseGrades();
        $grades->setPupil($this->pupilRepo->find(20));

        $grades->setSubject($this->subjectRepo->find(49));
        $grades->setGrades(['3', '2', '+3']);

        $entityManager->persist($grades);
        $entityManager->flush();
        $entityManager->clear(CourseGrades::class);

        return new Response("<div {$this->div_style}>created new CourseGrades id={$grades->getId()} {$this->generateMenuLink()}</div>");
    }

    public function createManyGrades(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $subjects = $this->subjectRepo->findBy(['class' => 3]);

        $grades = [
            ['-2', '-3', '3', '4',], ['-3', '-4', '-4', '3', '3'],
            ['-3', '+2', '+1', '+3'], ['4', '3', '1', '2'],
            ['1', '+3', '+3'], ['-4', '+3', '1'],
            ['4', '3', '3', '+3', '4'], ['+4', '+1', '+3', '+3'],
            ['2', '+1', '3'], ['3', '3', '4', '-3', '3'],
            ['4', '2', '+3'], ['+2', '+3', '4'],
            ['+4', '2', '-3'], ['-4', '2', '2', '+3', '2'],
            ['5', '4', '3', '+3']
        ];

        if (count($subjects) != count($grades)) {
            throw new Exception("lenght of the arrays must be the same! grades:".count($grades).', subjects:'.count($subjects));
        }

        for ($i = 0; $i < count($subjects); $i++) {
            $gradesObj = new CourseGrades();
            $gradesObj->setPupil($this->pupilRepo->find(27));
            $gradesObj->setSubject($subjects[$i]);
            $gradesObj->setGrades($grades[$i]);
            $entityManager->persist($gradesObj);
        }
        $entityManager->flush();
        $entityManager->clear();

        return new Response("<div {$this->div_style}>created new CourseGrades {$this->generateMenuLink()}</div>");
    }

    public function updateGrades(CourseGradesRepository $courseRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $id_arr = [389,];
        $subj_gr = [
            ['+2', '-3'],
        ];
        $grades = [];
        for ($i = 0 ; $i < count($id_arr); $i++) {
            $grades[] = $courseRepo->find($id_arr[$i]);
            $grades[$i]->setGrades($subj_gr[$i]);
        };

        $entityManager->flush();
        $entityManager->clear(CourseGrades::class);

        return new Response("<div {$this->div_style}>Updated Grades. {$this->generateMenuLink()}</div>");
    }

    private function generateMenuLink(): string
    {
        $url = $this->generateUrl('main_menu');
        return "<a href='{$url}'>Back to menu</a>";
    }
}
