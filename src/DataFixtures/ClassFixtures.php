<?php

namespace App\DataFixtures;

use App\Entity\ClassSchool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

class ClassFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ArrayDenormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $class = new ClassSchool();
        $class->setName("1A");
        $class->setTimetable($serializer->decode('{ "monday":{"mox":"Mo", "mo0":"", "mo1":"", "mo2":"informatics", "mo3":"ethics", "mo4":"grammar", "mo5":"grammar", "mo6":"geography", "mo7":"economics", "mo8":"informatics", "mo9":"", "mo10":""}, "tuesday":{"tux":"Tu", "tu0":"", "tu1":"math", "tu2":"German/French", "tu3":"grammar", "tu4":"chemistry", "tu5":"philosophy", "tu6":"history", "tu7":"ethics", "tu8":"", "tu9":"", "tu10":""}, "wednesday":{"wex":"We", "we0":"", "we1":"physical education", "we2":"form period", "we3":"math", "we4":"grammar", "we5":"biology", "we6":"German/French", "we7":"ethics", "we8":"", "we9":"", "we10":""}, "thursday":{"thx":"Th", "th0":"", "th1":"art history", "th2":"German/French", "th3":"history", "th4":"physical education", "th5":"grammar", "th6":"", "th7":"", "th8":"", "th9":"", "th10":""}, "friday":{"frx":"Fr", "fr0":"", "fr1":"", "fr2":"math", "fr3":"German/French", "fr4":"grammar", "fr5":"physics", "fr6":"history", "fr7":"economics", "fr8":"", "fr9":"", "fr10":""}}', 'json'));
        $class->setCurrentTimetable($serializer->decode('{ "monday":{"mox":"Mo", "mo0":"", "mo1":"", "mo2":"informatics", "mo3":"ethics", "mo4":"grammar", "mo5":"grammar", "mo6":"geography", "mo7":"economics", "mo8":"informatics", "mo9":"", "mo10":""}, "tuesday":{"tux":"Tu", "tu0":"", "tu1":"math", "tu2":"German/French", "tu3":"grammar", "tu4":"chemistry", "tu5":"philosophy", "tu6":"history", "tu7":"ethics", "tu8":"", "tu9":"", "tu10":""}, "wednesday":{"wex":"We", "we0":"", "we1":"physical education", "we2":"form period", "we3":"math", "we4":"grammar", "we5":"biology", "we6":"German/French", "we7":"ethics", "we8":"", "we9":"", "we10":""}, "thursday":{"thx":"Th", "th0":"", "th1":"art history", "th2":"German/French", "th3":"history", "th4":"physical education", "th5":"grammar", "th6":"", "th7":"", "th8":"", "th9":"", "th10":""}, "friday":{"frx":"Fr", "fr0":"", "fr1":"", "fr2":"math", "fr3":"German/French", "fr4":"grammar", "fr5":"physics", "fr6":"history", "fr7":"economics", "fr8":"", "fr9":"", "fr10":""}}', 'json'));
        $manager->persist($class);


        $class = new ClassSchool();
        $class->setName("1C");
        $class->setTimetable($serializer->decode('{"monday":{"mox":"Mo","mo0":"","mo1":"","mo2":"","mo3":"chemistry","mo4":"grammar","mo5":"form period","mo6":"astronomy","mo7":"","mo8":"","mo9":"","mo10":""},"tuesday":{"tux":"Tu","tu0":"","tu1":"ethics","tu2":"German\/French","tu3":"German\/French","tu4":"physical education","tu5":"physical education","tu6":"math","tu7":"philosophy","tu8":"biology","tu9":"","tu10":""},"wednesday":{"wex":"We","we0":"history","we1":"history","we2":"ethics","we3":"geography","we4":"grammar","we5":"informatics","we6":"German\/French","we7":"","we8":"","we9":"","we10":""},"thursday":{"thx":"Th","th0":"","th1":"","th2":"German\/French","th3":"grammar","th4":"math","th5":"history","th6":"physical education","th7":"","th8":"","th9":"","th10":""},"friday":{"frx":"Fr","fr0":"physical education","fr1":"physics","fr2":"math","fr3":"German\/French","fr4":"art history","fr5":"geography","fr6":"","fr7":"","fr8":"","fr9":"","fr10":""}}', 'json'));
        $class->setCurrentTimetable($serializer->decode('{"monday":{"mox":"Mo","mo0":"","mo1":"","mo2":"","mo3":"chemistry","mo4":"grammar","mo5":"form period","mo6":"astronomy","mo7":"","mo8":"","mo9":"","mo10":""},"tuesday":{"tux":"Tu","tu0":"","tu1":"ethics","tu2":"German\/French","tu3":"German\/French","tu4":"physical education","tu5":"physical education","tu6":"math","tu7":"philosophy","tu8":"biology","tu9":"","tu10":""},"wednesday":{"wex":"We","we0":"history","we1":"history","we2":"ethics","we3":"geography","we4":"grammar","we5":"informatics","we6":"German\/French","we7":"","we8":"","we9":"","we10":""},"thursday":{"thx":"Th","th0":"","th1":"","th2":"German\/French","th3":"grammar","th4":"math","th5":"history","th6":"physical education","th7":"","th8":"","th9":"","th10":""},"friday":{"frx":"Fr","fr0":"physical education","fr1":"physics","fr2":"math","fr3":"German\/French","fr4":"art history","fr5":"geography","fr6":"","fr7":"","fr8":"","fr9":"","fr10":""}}', 'json'));
        $manager->persist($class);

        $class = new ClassSchool();
        $class->setName("2A");
        $class->setTimetable($serializer->decode('{"monday":{"mox":"Mo","mo0":"","mo1":"form period","mo2":"form period","mo3":"Greek\/Hebrew","mo4":"Greek\/Hebrew","mo5":"math","mo6":"chemistry","mo7":"","mo8":"","mo9":"","mo10":""},"tuesday":{"tux":"Tu","tu0":"","tu1":"","tu2":"ethics","tu3":"economics","tu4":"art history","tu5":"math","tu6":"grammar","tu7":"grammar","tu8":"","tu9":"","tu10":""},"wednesday":{"wex":"We","we0":"physical education","we1":"ethics","we2":"grammar","we3":"history","we4":"Greek\/Hebrew","we5":"form period","we6":"math","we7":"physical education","we8":"ethics","we9":"ethics","we10":""},"thursday":{"thx":"Th","th0":"informatics","th1":"Greek\/Hebrew","th2":"biology","th3":"chemistry","th4":"history","th5":"geography","th6":"grammar","th7":"art history","th8":"","th9":"","th10":""},"friday":{"frx":"Fr","fr0":"Greek\/Hebrew","fr1":"biology","fr2":"physics","fr3":"geography","fr4":"Greek\/Hebrew","fr5":"grammar","fr6":"history","fr7":"","fr8":"","fr9":"","fr10":""}}', 'json'));
        $class->setCurrentTimetable($serializer->decode('{"monday":{"mox":"Mo","mo0":"","mo1":"form period","mo2":"form period","mo3":"Greek\/Hebrew","mo4":"Greek\/Hebrew","mo5":"math","mo6":"chemistry","mo7":"","mo8":"","mo9":"","mo10":""},"tuesday":{"tux":"Tu","tu0":"","tu1":"","tu2":"ethics","tu3":"economics","tu4":"art history","tu5":"math","tu6":"grammar","tu7":"grammar","tu8":"","tu9":"","tu10":""},"wednesday":{"wex":"We","we0":"physical education","we1":"ethics","we2":"grammar","we3":"history","we4":"Greek\/Hebrew","we5":"form period","we6":"math","we7":"physical education","we8":"ethics","we9":"ethics","we10":""},"thursday":{"thx":"Th","th0":"informatics","th1":"Greek\/Hebrew","th2":"biology","th3":"chemistry","th4":"history","th5":"geography","th6":"grammar","th7":"art history","th8":"","th9":"","th10":""},"friday":{"frx":"Fr","fr0":"Greek\/Hebrew","fr1":"biology","fr2":"physics","fr3":"geography","fr4":"Greek\/Hebrew","fr5":"grammar","fr6":"history","fr7":"","fr8":"","fr9":"","fr10":""}}', 'json'));
        $manager->persist($class);

        $manager->flush();
    }
}
