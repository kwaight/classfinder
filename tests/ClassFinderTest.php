<?php

namespace WSNYC\ClassFinder\Tests;

use PHPUnit\Framework\TestCase;
use WSNYC\ClassFinder\ClassFinder;
use WSNYC\Tests\Fixtures\DummyClass;
use WSNYC\Tests\Fixtures\DummyClassTwo;

class ClassFinderTest extends TestCase
{
     /**
      * @group class-finder-tests
      *
      * @test
      */
     public function it_finds_all_classes_in_directory()
     {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures');

        $this->assertContains(DummyClass::class, $classes);
        $this->assertContains(DummyClassTwo::class, $classes);
     }

    /**
     * @group class-finder-tests
     *
     * @test
     */
    public function it_matches_all_classes_in_directory_with_specified_pattern()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures', '*Two.php');

        $this->assertContains(DummyClassTwo::class, $classes);
        $this->assertNotContains(DummyClass::class, $classes);
    }

     /**
      * @group class-finder-tests
      *
      * @test
      */
     public function it_gets_fully_qualified_class_name_of_class()
     {
         $class = ClassFinder::findClass(__DIR__ . '/Fixtures/DummyClass.php');

         $this->assertEquals(DummyClass::class, $class);
     }
}
