<?php
    class Course
    {
        private $course_name;
        private $course_id;
        private $course_num;

        function __construct($course_name,$course_num,$course_id = null)
        {
            $this->$course_name = $course_name;
            $this->$course_num = $course_num;
            $this->$course_id = $course_id;
        }

        function setCourseName($new_name)
        {
            $this->course_name = $new_name;
        }

        function getCourseName()
        {
            return $course_name;
        }

        function setCourseNum($new_num)
        {
            $this->course_num = $new_num;
        }

        function getCourseNum()
        {
            return $course_num;
        }

        function setCourseId($new_id)
        {
            $this->course_id = $new_id;
        }

        function getCourseId()
        {
            return $course_id;
        }


        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO courses (course, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNum()}') RETURNING id;");
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $this->setCourseId($result['id']);
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $course_name = $course['course'];
                $course_id = $course['id'];
                $course_num = $course['course_number'];
                $new_course = new Course($course,$course_num, $course_id);
                array_push($courses, $new_course);
            }
            return $courses;
        }


        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses *;");
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getCourseId();
                if ($course_id == $search_id) {
                  $found_course = $course;
                }
            }
            return $found_course;
        }

        function updateCourse($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course = '{$new_name}' WHERE id = {$this->getCourseId()};");
        }

        function deleteCourse()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getCourseId()};");
            $GLOBALS['DB']->exec("DELETE FROM enrollments WHERE course_id = {$this->getCourseId()};");
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO enrollments (student_id, course_id) VALUES ({$student->getStudentId()}, {$this->getCourseId()});");
        }

        // function getStudents()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT students.* FROM courses JOIN enrollments ON (courses.id = enrollments.course_id) JOIN students ON (enrollments.student_id = students.id) WHERE courses.id={$this->getCourseId()};");
        //     $course_students = $query->fetchAll(PDO::FETCH_ASSOC);
        //     $all_course_students = array();
        //     foreach($course_students as $course_student {
        //         $student_id = $course_student['id'];
        //         $student_name = $course_student['name'];
        //         $enrollment_date = $course_student['enrollment_date'];
        //         $new_student = new Student($student_name, $enrollment_date, $student_id);
        //         array_push($all_course_students, $new_student);
        //     }
        //         return $all_course_students;
        // }
    }


?>
