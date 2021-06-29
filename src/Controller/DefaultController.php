<?php

namespace App\Controller;

use App\Repository\CourseGradesRepository;
use App\Entity\CourseGrades;
use App\Entity\Subject;
use App\Entity\ClassSchool;
use App\Entity\Pupil;
use App\Entity\Teacher;
use App\Repository\ClassSchoolRepository;
use App\Repository\PupilRepository;
use App\Repository\SubjectRepository;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    private $pupilRepo;
    private $classRepo;
    private $gradeRepo;
    private $subjectRepo;
    private $teacherRepo;
    private $admins;

    public function __construct(PupilRepository $pupilRepo, ClassSchoolRepository $classRepo, SubjectRepository $subjectRepo, CourseGradesRepository $gradeRepo, TeacherRepository $teacherRepo)
    {
        $this->pupilRepo = $pupilRepo;
        $this->classRepo = $classRepo;
        $this->gradeRepo = $gradeRepo;
        $this->subjectRepo = $subjectRepo;
        $this->teacherRepo = $teacherRepo;

        $this->admins = [];
        foreach ($this->teacherRepo->findBy([]) as $teacher) {
            if (in_array('ROLE_SUPER_ADMIN', $teacher->getRoles())) {
                $this->admins[] = $teacher;
            }
        }
    }

    public function mainMenu(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $class = $user->getAclass();
        $subjects = $this->subjectRepo->findBy(['teacher' => $user->getId()]);

        return $this->render('mainmenu.html.twig', [
            'user' => $user, 'aclass' => $class, 'subjects' => $subjects
        ]);
    }

    public function showTeachers(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $teachers = $this->teacherRepo->findBy([], ['name' => 'ASC']);

        $tid['---'] = 'empty';
        $tsub['---'] = 'empty';
        foreach ($teachers as $teacher) {
            $tid[$teacher->getName()] = $teacher->getName();
            foreach ($teacher->getSubject() as $subject) {
                $tsub[$subject] = $subject;
            }
        }
        ksort($tsub, SORT_FLAG_CASE|SORT_STRING);
        ksort($tid);

        $classes = $this->classRepo->findAll();
        $classid['---'] = 'empty';
        $classid['No Class'] = 'NULL';
        foreach ($classes as $class) {
            $classid[$class->getName()] = $class->getId();
        }

        /* dump([$tid, $tsub, $classid]); */
        $form = $this->createFormBuilder()
                     ->add('name', ChoiceType::class, [
                        'choices' => $tid
                     ])
                     ->add('subject', ChoiceType::class, [
                        'choices' => $tsub
                     ])
                     ->add('aclass', ChoiceType::class, [
                         'choices' => $classid,
                         'label' => 'Class',
                     ])
                     ->add('submit', SubmitType::class)
                     ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();

            $keys = array_keys($form_data);
            $teachers = $this->teacherRepo->findByManyFields($form_data['subject'], $form_data['name'], $form_data['aclass']);
        }

        foreach ($teachers as $key => $value) {
            if (in_array($teachers[$key], $this->admins)) {
                unset($teachers[$key]);
            }
        }

        return $this->render('submenu/teachers.html.twig', [
            'teachers' => $teachers,
            'teacher_form' => $form->createView(),
        ]);
    }

    public function showTeacher(TeacherRepository $repo, int $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $teacher = $repo->find($slug);
        if (in_array('ROLE_SUPER_ADMIN', $teacher->getRoles())) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('submenu/teacher.html.twig', [
            'teacher' => $teacher
        ]);
    }

    public function showClasses(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $classes = $this->classRepo->findAll();

        return $this->render('submenu/classes.html.twig', ['classes' => $classes]);
    }

    public function showClass(int $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $class1 = $this->classRepo->find($slug);

        return $this->render('submenu/class.html.twig', ['aclass' => $class1]);
    }

    public function showPupils(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $pupils = $this->pupilRepo->findBy([], ['name' => 'ASC']);
        $pupilsName['---'] = 'empty';
        foreach ($pupils as $pupil) {
            $pupilsName[$pupil->getName()] = $pupil->getId();
        }

        $classes = $this->classRepo->findAll();
        $classesId['---']  = 'empty';
        foreach ($classes as $class) {
            $classesId[$class->getName()] = $class->getId();
        }

        $form = $this->createFormBuilder()
                     ->add('name', ChoiceType::class, [
                        'choices' => $pupilsName
                     ])
                     ->add('sex', ChoiceType::class, [
                         'choices' => [
                             '---' => 'empty',
                             'male' => 'm',
                             'female' => 'f',
                         ]
                     ])
                     ->add('class', ChoiceType::class, [
                        'choices' => $classesId,
                        'label' => 'Class',
                     ])
                     ->add('submit', SubmitType::class)
                     ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pupils = $this->pupilRepo->findByManyFields($data['name'], $data['sex'], $data['class']);
        }

        return $this->render('submenu/pupil/showall.html.twig', ['pupils' => $pupils, 'pupilForm' => $form->createView()]);
    }
    
    public function showPupil(int $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $pupil = $this->pupilRepo->find($slug);
        
        $class = $pupil->getClass();
        $showGrades = ($user->getAclass() === $class)? true : false;

        return $this->render('submenu/pupil/show.html.twig', ['pupil' => $pupil, 'showGrades' => $showGrades]);
    }

    public function showPupilGrades(int $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDUCATOR');

        $user = $this->getUser();
        $pupil = $this->pupilRepo->find($slug);
        $class = $pupil->getClass();
        if ($user->getAclass() !== $class) {
            throw $this->createAccessDeniedException();
        }

        foreach ($pupil->getGrades() as $grade) {
            $grades[$grade->getSubject()->getName()] = $grade;
        }
        ksort($grades);

        return $this->render('submenu/pupil/grades.html.twig', ['pupil' => $pupil, 'grades' => $grades]);
    }

    public function mTimetable(Request $request, $slug): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $enableEdit = false;

        $class = $this->classRepo->find($slug);

        $referer = $request->headers->get('referer');

        return $this->render('submenu/mtt_edu.html.twig', ['aclass' => $class, 'referer' => $referer, 'enableEdit' => $enableEdit]);
    }

    public function mTimetableEducator(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDUCATOR');

        $enableEdit = true;
        $user = $this->getUser();
        $class = $user->getAclass();

        return $this->render('submenu/mtt_edu.html.twig', ['aclass' => $class, 'enableEdit' => $enableEdit]);
    }

    public function editTimetable(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDUCATOR');

        $class = $this->getUser()->getAclass();
        $timetable = $class->getCurrentTimetable();

        return $this->render('submenu/edit_timetable.html.twig', [
            'class01' => $class
        ]);
    }

    public function saveTimetable(): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_EDUCATOR');

        $entityManager = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $all = $request->request->all();
        $user = $this->getUser();
        $current_tt = $user->getAclass()->getCurrentTimetable();

        if ($all['submit'] === 'Return Default Timetable') {
            $default_tt = $user->getAclass()->getTimetable();
            $user->getAclass()->setCurrentTimetable($default_tt);
        } else {
            $class1 = $this->getUser()->getAclass();
            foreach ($all as $key => $value) {
                $substr = substr($key, 0, 2);
                if ($substr === 'mo') {
                    $current_tt['monday'][$key] = $value;
                } elseif ($substr === 'tu') {
                    $current_tt['tuesday'][$key] = $value;
                } elseif ($substr === 'we') {
                    $current_tt['wednesday'][$key] = $value;
                } elseif ($substr === 'th') {
                    $current_tt['thursday'][$key] = $value;
                } elseif ($substr === 'fr') {
                    $current_tt['friday'][$key] = $value;
                }
            }
            $class1->setCurrentTimetable($current_tt);
        }
        $entityManager->flush();
        $entityManager->clear(ClassSchool::class);

        return $this->redirectToRoute('main_menu');
    }

    public function showSubjects(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $this->getDoctrine()->getManager();

        $classes = $this->classRepo->findAll();
        $classes_name['---'] = 'empty';
        foreach ($classes as $class) {
            $classes_name[$class->getName()] = $class->getId();
        }

        $teachers = $this->teacherRepo->findBy([], ['name' => 'ASC']);
        $teachers_name['---'] = 'empty';
        for ($i=0; $i<count($teachers); $i++) {
            $teachers_name[$teachers[$i]->getName()] = $teachers[$i]->getId();
        }

        $subjects = $this->subjectRepo->findByNameCI();
        $names['---'] = 'empty';
        foreach ($subjects as $subject) {
            $names[$subject->getName()] = $subject->getName();
        }
        $names = array_unique($names);

        $form = $this->createFormBuilder()
            ->add('name', ChoiceType::class, [
                'choices' => $names
            ])
            ->add('teacher', ChoiceType::class, [
                'choices' => $teachers_name
            ])
            ->add('class', ChoiceType::class, [
                'choices' => $classes_name
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data['name'] === 'empty') {
                unset($data['name']);
            }
            if ($data['teacher'] === 'empty') {
                unset($data['teacher']);
            }
            if ($data['class'] === 'empty') {
                unset($data['class']);
            }
            $keys = array_keys($data);
            if (count($data) === 1) {
                $subjects = $this->subjectRepo->findBy([$keys[0] => $data[$keys[0]]]);
            } elseif (count($data) === 2) {
                $subjects = $this->subjectRepo->findBy([$keys[0] => $data[$keys[0]], $keys[1] => $data[$keys[1]]]);
            } elseif (count($data) === 3) {
                $subjects = $this->subjectRepo->findBy([$keys[0] => $data[$keys[0]], $keys[1] => $data[$keys[1]], $keys[2] => $data[$keys[2]]]);
            }
        }
        return $this->render('submenu/subjects.html.twig', ['subjects' => $subjects, 'sub_form' => $form->createView()]);
    }

    public function showAllSubjectGrades($name = ''): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDUCATOR');

        $user = $this->getUser();
        $subjects = $this->subjectRepo->findBy(['class' => $user->getAclass()], ['name' => 'ASC']);

        if ($name === '') {
            $pupilsGrade = [];
        } else {
            $subject = $this->subjectRepo->findBy(['class' => $user->getAclass(), 'name' => $name]);
            $grades = $this->gradeRepo->findBy(['subject' => $subject[0]->getId()]);
            foreach ($grades as $grade) {
                $pupilsGrade[$grade->getPupil()->getName()] = $grade;
            }
            ksort($pupilsGrade);
        }

        return $this->render('submenu/school_register.html.twig', ['subjects' => $subjects, 'grades' => $pupilsGrade]);
    }

    public function showSubjectGrades(int $subject_id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $request = Request::createFromGlobals();
        $pupil_name = $request->query->get('saveData');
        /* $pupil = $this->pupilRepo->find($pupil_id); */

        $user = $this->getUser();
        $subject = $this->subjectRepo->find($subject_id);

        if ($subject->getTeacher() !== $user) {
            throw $this->createAccessDeniedException();
        }
        $grades = $this->gradeRepo->findBy(['subject' => $subject->getId()]);
        $title = "Class: {$subject->getClass()->getName()} - {$subject->getName()}";

        //dump($saveData);
        return $this->render('submenu/grades.html.twig', ['grades' => $grades, 'title' => $title, 'pupil' => $pupil_name]);
    }

    public function editSubjectGrades(int $subject_id, int $pupil_id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $subject = $this->subjectRepo->find($subject_id);
        $pupil = $this->pupilRepo->find($pupil_id);

        if ($subject->getTeacher() !== $user) {
            throw $this->createAccessDeniedException();
        }
        $grades = $this->gradeRepo->findBy(['subject' => $subject->getId(), 'pupil' => $pupil_id]);
        $title = "Class: {$subject->getClass()->getName()} - {$subject->getName()} - {$pupil->getName()}";

        $form = $this->createFormBuilder($grades[0])
             ->add('grades', CollectionType::class, [
                 'entry_type' => TextType::class,
                 'allow_add' => true,
                 'allow_delete' => true,
             ])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $grades[0] = $form->getData();

            $entityManager->persist($grades[0]);
            $entityManager->flush();

            return $this->redirectToRoute('show_subject_grades', [
                'subject_id' => $subject->getId(), 'saveData' => $grades[0]->getPupil()->getName()
            ]);
        }

        return $this->render(
            'submenu/edit_grades.html.twig',
            [
                'grades' => $grades,
                'title' => $title,
                'form1' => $form->createView()
            ]
        );
    }
}
