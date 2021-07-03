<?php

namespace App\Controller;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\CourseGrades;
use App\Entity\ClassSchool;
use App\Entity\Pupil;
use App\Entity\Subject;
use App\Entity\Teacher;
use App\Form\ClassType;
use App\Form\PupilType;
use App\Form\TeacherType;
use App\Form\TeacherUpdateType;
use App\Repository\ClassSchoolRepository;
use App\Repository\CourseGradesRepository;
use App\Repository\PupilRepository;
use App\Repository\SubjectRepository;
use App\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type as FormType;
use Symfony\Component\Form\Extension\Core\Type as Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use function ksort;

class EditEntityController extends AbstractController
{
    private $classRepo;
    private $pupilRepo;
    private $subjectRepo;
    private $teacherRepo;
    private $div_style;

    public function __construct(ClassSchoolRepository $classRepo, PupilRepository $pupilRepo, SubjectRepository $subjectRepo, TeacherRepository $teacherRepo)
    {
        $this->classRepo = $classRepo;
        $this->pupilRepo = $pupilRepo;
        $this->subjectRepo = $subjectRepo;
        $this->teacherRepo = $teacherRepo;

        $this->div_style = "style='font-size: 3.5em'";
    }

    public function createTeacher(Request $request, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->clear();

        $teacher = new Teacher();
        $teacher->setRoles([]);
        $teacher->setSubject(['', '', '', '']);
        $form = $this->createForm(TeacherType::class, $teacher);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $admin = isset($request->request->get('teacher')['isAdmin']);
            if ($data->getAclass() && $admin) {
                $data->setRoles([Teacher::ROLE_EDUCATOR, Teacher::ROLE_ADMIN]);
            } elseif ($data->getAclass() && !$admin) {
                $data->setRoles([Teacher::ROLE_EDUCATOR,]);
            } elseif ($admin) {
                $data->setRoles([Teacher::ROLE_ADMIN,]);
            }

            $data->setPassword($encoder->encodePassword($data, $data->getPassword()));

            $entityManager->persist($data);
            $entityManager->flush();
            $entityManager->clear(Teacher::class);

            $teacher_url = $this->generateUrl('show_teacher', ['slug' => $data->getId()]);

            return new Response(
                "<a href=''>Back</a><br>
                You have created new Teacher!<br>
                <a href='{$teacher_url}'>{$data->getName()}</a>"
            );
        }

        return $this->render('edit_entity/create_teacher.html.twig', ['form' => $form->createView(),]);
    }

    public function updateTeacher(int $slug, UserPasswordEncoderInterface $encoder, Request $request, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $teacher = $this->teacherRepo->find($slug);

        $tarr = $teacher->getSubject();
        array_push($tarr, '', '', '');
        $teacher->setSubject($tarr);

        $form = $this->createForm(TeacherUpdateType::class, $teacher);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $admin = isset($request->request->get('teacher_update')['isAdmin']);
            if ($data->getAclass() && $admin) {
                $data->setRoles([Teacher::ROLE_EDUCATOR, Teacher::ROLE_ADMIN]);
            } elseif ($data->getAclass() && !$admin) {
                $data->setRoles([Teacher::ROLE_EDUCATOR,]);
            } elseif ($admin) {
                $data->setRoles([Teacher::ROLE_ADMIN,]);
            } else {
                $data->setRoles([]);
            }

            $entityManager->flush();
            $entityManager->clear(Teacher::class);

            $teacher_url = $this->generateUrl('show_teacher', ['slug' => $data->getId()]);

            return new Response(
                "Success. You have edited this Teacher!<br>
                <a href='{$teacher_url}'>{$data->getName()}</a>"
            );
        }

        return $this->render('edit_entity/create_teacher.html.twig', ['form' => $form->createView(),]);
    }

    public function deleteTeacher(int $slug, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $teacher = $this->teacherRepo->find($slug);

        $form = $this->createFormBuilder()
            ->add('cancel', Form\SubmitType::class)
            ->add('delete', Form\SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked() && $form->isValid()) {
            return $this->redirectToRoute('show_teacher', ['slug' => $slug]);
        } elseif ($form->get('delete')->isClicked() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($teacher);
            $em->flush();
            $em->clear(Teacher::class);

            $this->addFlash('success', "Successfully deleted {$teacher->getName()}!");
            return $this->redirectToRoute('show_teachers');
        }
        return $this->render('edit_entity/delete_teacher.html.twig', ['form' => $form->createView(), 'teacher' => $teacher]);
    }

    public function createClass(Request $request, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $em->clear();

        $class = new ClassSchool();
        $class->setTimetable(ClassSchool::decodeEmptyTimetableToArray());
        $class->setCurrentTimetable(ClassSchool::decodeEmptyTimetableToArray());

        $form = $this->createForm(ClassType::class, $class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $tutor = $data->getTutor();
            $tutor->addRole(Teacher::ROLE_EDUCATOR);

            $em->persist($class);
            $em->flush();
            $em->clear(ClassSchool::class);
            $em->clear(Teacher::class);

            $this->addFlash('success', "created new class. Class: {$data->getName()}");
            return $this->redirectToRoute('main_menu');
        }
        return $this->render('edit_entity/create_class.html.twig', ['form' => $form->createView()]);
    }

    public function showClasses(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $classes = $this->classRepo->findBy([]);

        return $this->render('edit_entity/classes.html.twig', ['classes' => $classes]);
    }

    public function updateClass(int $slug, Request $request, ValidatorInterface $validator): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();
        $class = $this->classRepo->find($slug);
        $currentTutor = $class->getTutor();

        $form = $this->createForm(ClassType::class, $class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $currentTutor->setAclass(null);
            $currentTutor->removeRole(Teacher::ROLE_EDUCATOR);

            $tutor = $data->getTutor();
            $tutor->addRole(Teacher::ROLE_EDUCATOR);

            $em->flush();
            $em->clear(ClassSchool::class);
            $em->clear(Teacher::class);

            $this->addFlash('success', "Successfully updated Class: {$data->getName()}");
            return $this->redirectToRoute('admin_show_classes');
        }

        return $this->render('edit_entity/create_class.html.twig', ['form' => $form->createView()]);
    }

    public function deleteClass(int $slug, Request $request, ValidatorInterface $validator): Response
    {
        $form = $this->createFormBuilder()
            ->add('cancel', SubmitType::class)
            ->add('delete', SubmitType::class)
            ->getForm();

        $class = $this->classRepo->find($slug);

        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked() && $form->isValid()) {
            return $this->redirectToRoute('admin_show_classes', ['slug' => $slug]);
        } elseif ($form->get('delete')->isClicked() && $form->isValid()) {
            $class->getTutor()->removeRole(Teacher::ROLE_EDUCATOR);
            $class->setTutor(null);

            $em = $this->getDoctrine()->getManager();
            $em->remove($class);
            $em->flush();
            $em->clear(ClassSchool::class);

            $this->addFlash('success', "Successfully deleted {$class->getName()}!");
            return $this->redirectToRoute('admin_show_classes');
        }

        return $this->render('edit_entity/delete_class.html.twig', [
            'class' => $this->classRepo->find($slug),
            'form' => $form->createView()
        ]);
    }

    public function createPupil(Request $request, ValidatorInterface $validator): Response
    {
        $em = $this->getDoctrine()->getManager();

        $pupil = new Pupil();
        $form = $this->createForm(PupilType::class, $pupil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $errors = $validator->validate($data);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $em->persist($data);
            $em->flush($data);
            $em->clear(Pupil::class);

            $this->addFlash('success', "You created new Pupil - {$data->getName()}:(class-{$data->getClass()->getName()})");
            return $this->redirectToRoute('main_menu');
        }

        return $this->render('edit_entity/create_pupil.html.twig', ['form' => $form->createView()]);
    }

    public function updatePupil(int $slug, Request $request): Response
    {
        return new Response("crud pupil");
    }

    public function deletePupil(int $slug, Request $request): Response
    {
        return new Response("crud pupil");
    }

    public function showPupils(Request $request): Response
    {
        $pupils = $this->pupilRepo->findBy([], ['name' => 'ASC']);
        $classId = ['- All -' => 'empty'];
        $classes = $this->classRepo->findBy([]);
        foreach ($classes as $class) {
            $classId[$class->getName()] = $class->getId();
        }
        ksort($classId);

        $form = $this->createFormBuilder()
                 ->add('sex', Form\ChoiceType::class, [
                     'choices' => ['all' => 'empty', 'male' => 'm', 'female' => 'f']
                 ])
                 ->add('class', Form\ChoiceType::class, [
                     'choices' => $classId
                 ])
                 ->add('search', Form\SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pupils = $this->pupilRepo->findByManyFields('empty', $data['sex'], $data['class']);
        }
        return $this->render('edit_entity/pupils.html.twig', ['form' => $form->createView(), 'pupils' => $pupils]);
    }

    public function showTimetables(): Response
    {
        return $this->render('edit_entity/timetables.html.twig');
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
