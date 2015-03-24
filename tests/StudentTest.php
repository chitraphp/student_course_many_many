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
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        //Initialize a Student with a name and be able to get it back out of the object using getDescription().
        function testGetStudentName()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31";
            $test_student = new Student($name, $enroll_date);
            //No need to save here because we are communicating with the object only and not the database.
            //Act
            $result = $test_student->getStudentName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetStudentName()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);

            //Act
            $test_student->setStudentName("Liz");
            $result = $test_student->getStudentName();
            //Assert
            $this->assertEquals("Liz", $result);
        }
        // //Next, let's add the Id. property to our Student class. Like any other property it needs a getter and setter.
        // //Create a Student with the id in the constructor and be able to get the id back out.
        function testGetStudentId()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $id = 3;
            $test_student = new Student($name, $enroll_date,$id);

            //Act
            $result = $test_student->getStudentId();
            //Assert
            $this->assertEquals(3, $result);
        }
        // //Create a Student with the id in the constructor and be able to change its value, and then get the new id out.
        function testSetStudentId()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);

            //Act
            $test_student->setStudentId(5);
            $result = $test_student->getStudentId();
            //Assert
            $this->assertEquals(5, $result);
        }

        function testSaveSetStudentId()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);

            //Act
            $test_student->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_student->getStudentId()));
        }


        function testGetEnrollDate()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);

            //Act

            $result = $test_student->getEnrollDate();
            //Assert
            $this->assertEquals("2015-05-31 00:00:00", $result);
        }

        function testSave()
        {
        //Arrange
        $name = "Chitra";
        $enroll_date = "2015-05-31 00:00:00";
        $test_student = new Student($name, $enroll_date);

        //Act
        $test_student->save();
        $result = Student::getAll();
        // $result = $test_student->getStudentId();

        //Assert
        $this->assertEquals($test_student, $result[0]);
        }


        function testGetAll()
        {
            //Arrange
            //Create and save more than one Student object.
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            $name2 = "Liz";
            $enroll_date2 = "2015-01-01 00:00:00";
            $test_student2 = new Student($name2, $enroll_date2);
            $test_student2->save();

            //Act
            //Query the database to get all existing saved tasks as objects.
            $result = Student::getAll();

            //Assert
            //We should get our two test tasks back out in $result.
            //Remember the [$thing1, $thing2] notation is used for an array.
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            $name2 = "Liz";
            $enroll_date2 = "2015-01-01 00:00:00";
            $test_student2 = new Student($name2, $enroll_date2);
            $test_student2->save();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            $name2 = "Liz";
            $enroll_date2 = "2015-01-01 00:00:00";
            $test_student2 = new Student($name2, $enroll_date2);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getStudentId());

            //Assert
            $this->assertEquals($test_student, $result);
        }

        function testUpdate()
        {
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            $new_name = "Liz";

            //Act
            $test_student->update($new_name);

            //Assert
            $this->assertEquals("Liz", $test_student->getStudentName());
        }

        function testDeleteStudent()
        {
            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            $name2 = "Liz";
            $enroll_date2 = "2015-01-01 00:00:00";
            $test_student2 = new Student($name2, $enroll_date2);
            $test_student2->save();

            //Act
            $test_student->deleteStudent();

            //Assert
            $this->assertEquals([$test_student2], Student::getAll());
        }

        // function testAddCourse()
        // {
        //     //Arrange
        //     $course = "PHP";
        //     $course_num = "PHP101";
        //     $course_id = 1;
        //     $test_course = new Course($course, $course_num, $course_id);
        //     $test_course->save();
        //
        //     $name = "Chitra";
        //     $enroll_date = "2015-05-31 00:00:00";
        //     $test_student = new Student($name, $enroll_date);
        //     $test_student->save();
        //
        //     //Act
        //     $test_student->addCourse($test_course);
        //     //Assert
        //     $this->assertEquals([$test_course], $test_student->getCourses());
        // }

        function testGetCourses()
        {
            //Arrange
            $course = "PHP";
            $course_num = "PHP101";
            $course_id = 1;
            $test_course = new Course($course, $course_num, $course_id);
            $test_course->save();

            //Arrange
            $course2 = "math";
            $course_num2 = "math101";
            $course_id2 = 3;
            $test_course2 = new Course($course2, $course_num2, $course_id2);
            $test_course2->save();

            $name = "Chitra";
            $enroll_date = "2015-05-31 00:00:00";
            $test_student = new Student($name, $enroll_date);
            $test_student->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);
            //$result=Course::getAll();
            //$result = $test_course2->getCourseName();


            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
            //$this->assertEquals([$test_course, $test_course2],$result);
            //$this->assertEquals("Chitra",$result);
        }
    }
?>
