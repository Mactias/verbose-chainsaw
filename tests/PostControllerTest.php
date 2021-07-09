<?php

namespace App\Tests;

use App\Entity\ClassSchool;
use App\Repository\ClassSchoolRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use function count;

class PostControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'travisred@gmail.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/main-menu');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Welcome Travis Redman');
        $this->assertSelectorTextContains('h3', 'Your class 1A');
        $this->assertCount(1, $crawler->filterXPath("//h3[text()='Your subjects']"));
    }

    public function testListSites(): void
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'travisred@gmail.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/show-subjects');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'List of Subjects');
        $this->assertCount(16, $crawler->filter('tr'));

        $crawler = $client->request('GET', '/teachers');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'list of all teachers');
        $this->assertCount(19, $crawler->filter('tr'));

        $crawler = $client->request('GET', '/classes');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'List of all Classes');
        $this->assertCount(4, $crawler->filter('tr'));

        $crawler = $client->request('GET', '/pupils');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'List of all Pupils');
        $this->assertCount(16, $crawler->filter('tr'));
    }

    public function testAdminCreateTeacher()
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'admin@admin.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/main-menu');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Welcome Admin');

        $client->clickLink('Create new Teacher');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Create new teacher');

        /* $crawler = $client->request('GET', '/create-teacher'); */
        $crawler = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('Submit');

        $form = $buttonCrawlerNode->form();

        $form['teacher[subject][0]']->select('2');
        $form['teacher[subject][1]']->select('6');
        $form['teacher[email]'] = 'benjaminlord@dayrep.com';
        $form['teacher[name]'] = 'Benjamin Lord';
        $form['teacher[phone_number]'] = '078399177';
        $form['teacher[password][first]'] = '123456';
        $form['teacher[password][second]'] = '123456';

        $client->submit($form);

        $this->assertSelectorTextContains('body', 'You have created new Teacher!');
        $client->clickLink('Benjamin Lord');
        $this->assertSelectorTextContains('h2', 'Teacher: Benjamin Lord');

        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'benjaminlord@dayrep.com']);
        $this->assertEquals('Benjamin Lord', $testUser->getName());
        $this->assertEquals('078399177', $testUser->getPhoneNumber());
    }

    public function testAdminUpdateTeacher()
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'admin@admin.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/main-menu');

        $client->clickLink('Update Teacher');
        $this->assertResponseIsSuccessful();

        $client->clickLink('Abby Hooper');
        $this->assertResponseIsSuccessful();

        $client->clickLink('Edit');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Edit Abby Hooper');

        $crawler = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('Submit');

        $form = $buttonCrawlerNode->form();

        $form['teacher_update[subject][0]']->select('1');
        $form['teacher_update[subject][1]']->select('2');
        $form['teacher_update[email]'] = 'abbyhuper@dayrep.com';
        $form['teacher_update[name]'] = 'Abby Huper';
        $form['teacher_update[phone_number]'] = '078422988';

        $client->submit($form);

        $this->assertSelectorTextContains('body', 'Success. You have edited this Teacher!');
        $client->clickLink('Abby Huper');
        $this->assertSelectorTextContains('h2', 'Teacher: Abby Huper');

        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'abbyhuper@dayrep.com']);
        $this->assertEquals('abbyhuper@dayrep.com', $testUser->getEmail());
        $this->assertEquals('Abby Huper', $testUser->getName());
        $this->assertEquals('078422988', $testUser->getPhoneNumber());
    }

    public function testAdminCreateClass()
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'admin@admin.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/main-menu');

        $client->clickLink('Create Class');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Create New Class');
        /* dylanpower@rhyta.com */
        $crawler = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('Submit');

        $form = $buttonCrawlerNode->form();

        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'jordanosullivan@armyspy.com']);

        $form['class[tutor]']->select($testUser->getId());
        $form['class[name]'] = '3G';

        $client->submit($form);

        $client->followRedirect();
        $this->assertSelectorTextContains('div', 'created new class. Class: 3G');

        $classRepo = static::$container->get(ClassSchoolRepository::class);

        $testClass = $classRepo->findOneBy(['name' => '3G']);
        $this->assertEquals('jordanosullivan@armyspy.com', $testClass->getTutor()->getEmail());

        $classes = $classRepo->findBy([]);
        $this->assertEquals(4, count($classes));
    }

    public function testAdminUpdateClass()
    {
        $client = static::createClient();
        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'admin@admin.com']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/main-menu');

        $client->clickLink('Update Class');
        $this->assertResponseIsSuccessful();

        $client->clickLink('Edit');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Create New Class');

        $crawler = $client->getCrawler();
        $buttonCrawlerNode = $crawler->selectButton('Submit');

        $form = $buttonCrawlerNode->form();

        $teacherRepo = static::$container->get(TeacherRepository::class);

        $testUser = $teacherRepo->findOneBy(['email' => 'jordanosullivan@armyspy.com']);

        $form['class[tutor]']->select($testUser->getId());
        $form['class[name]'] = '3G';

        $client->submit($form);

        $client->followRedirect();
        $this->assertSelectorTextContains('div', 'Successfully updated Class: 3G');

        $classRepo = static::$container->get(ClassSchoolRepository::class);

        $testClass = $classRepo->findOneBy(['name' => '3G']);
        $this->assertEquals('jordanosullivan@armyspy.com', $testClass->getTutor()->getEmail());
    }
}
