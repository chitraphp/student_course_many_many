<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Student.php";
    require_once "src/Course.php";

    $DB = new PDO('pgsql:host=localhost;dbname=registrar_test');

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Student::deleteAll();
        //     Course::deleteAll();
        // }

        function testGetCourseName()
        {
            //Arrange
            $course = "PHP";
            $course_num = "PHP101";
            $course_id = 1;
            $test_course = new Course($course, $course_num, $course_id);

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("PHP",$result);

        }

        function testSetStudentName()
        {
            //Arrange
            $course = "PHP";
            $course_num = "PHP101";
            $course_id = 1;
            $test_course = new Course($course, $course_num, $course_id);

            //Act
            $test_course->setCourseName("math");
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("math", $result);
        }
    }
?>
