<?php

namespace WSNYC\ClassFinder\Tests;

use PHPUnit\Framework\TestCase;
use WSNYC\ClassFinder\ClassFinder;
use WSNYC\Tests\Fixtures\DummyClass;
use WSNYC\Tests\Fixtures\DummyClassTwo;
use WSNYC\Tests\Fixtures\Nested\DummyClassNested;

/**
 * @covers \WSNYC\ClassFinder\ClassFinder::<protected>
 */
class ClassFinderTest extends TestCase
{
    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @group class-finder-tests
     *
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
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @group class-finder-tests
     *
     * @test
     */
    public function it_finds_all_nested_classes_in_directory()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/Fixtures');

        $this->assertContains(DummyClassNested::class, $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
     * @group class-finder-tests
     *
     * @test
     */
    public function it_suppresses_non_existent_directory_exceptions()
    {
        $classes = ClassFinder::findClasses(__DIR__ . '/FixturesThatDoNotExist');

        $this->assertEquals([], $classes);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClasses
     *
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
     * @covers \WSNYC\ClassFinder\ClassFinder::findClass
     *
     * @group class-finder-tests
     *
     * @test
     */
    public function it_gets_fully_qualified_class_name_of_class()
    {
        $class = ClassFinder::findClass(__DIR__ . '/Fixtures/DummyClass.php');

        $this->assertEquals(DummyClass::class, $class);
    }

    /**
     * @covers \WSNYC\ClassFinder\ClassFinder::findClass
     *
     * @group class-finder-tests
     *
     * @test
     */
    public function it_returns_null_for_non_classes()
    {
        $class = ClassFinder::findClass(__DIR__ . '/Fixtures/not_a_class.php');

        $this->assertNull($class);
    }
}
