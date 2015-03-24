<?php
class Student
{
    private $student_name;
    private $student_id;
    private $enroll_date;

    function __construct($student_name,$enroll_date,$student_id = null)
    {
        $this->student_name = $student_name;
        $this->enroll_date = $enroll_date;
        $this->student_id = $student_id;
    }

    function getStudentName()
    {
        return $this->student_name;
    }

    function setStudentName($new_name)
    {
        $this->student_name = (string) $new_name;
    }

    function getStudentId()
    {
        return $this->student_id;
    }

    function setStudentId($new_id)
    {
        $this->student_id = (int) $new_id;
    }

    function getEnrollDate()
    {
        return $this->enroll_date;
    }

//Add data type for date?
    function setEnrollDate($new_date)
    {
        $this->enroll_date = $new_date;
    }

    function save()
    {
        $statement = $GLOBALS['DB']->query("INSERT INTO students (name, enrollment_date) VALUES ('{$this->getStudentName()}', '{$this->getEnrollDate()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setStudentId($result['id']);
    }

    static function getAll()
    {
        $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
        $students = array();
        foreach($returned_students as $student) {
            $id = $student['id'];
            $student_name = $student['name'];
            $enroll_date = $student['enrollment_date'];
            $new_student = new Student($student_name,$enroll_date, $id);
            array_push($students, $new_student);
        }
        return $students;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM students *;");

    }


    static function find($search_id)
    {
        $found_student = null;
        $students = Student::getAll();
        foreach($students as $student) {
            $student_id = $student->getStudentId();
            if ($student_id == $search_id) {
              $found_student = $student;
            }
    }
    return $found_student;
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}' WHERE id = {$this->getStudentId()};");
        $this->setStudentName($new_name);
    }

    function deleteStudent()
    {
        $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getStudentId()};");
        $GLOBALS['DB']->exec("DELETE FROM enrollments WHERE student_id = {$this->getStudentId()};");
    }

//This adds the student to a specific course--indicates relationship in db
    function addCourse($course)
    {
        $GLOBALS['DB']->exec("INSERT INTO enrollments (student_id, course_id) VALUES ({$this->getStudentId()}, {$course->getCourseId()});");
    }

    function getCourses()
    {
        $query = $GLOBALS['DB']->query("SELECT courses.* FROM students JOIN enrollments ON (students.id = enrollments.student_id) JOIN courses ON (enrollments.course_id = courses.id) WHERE students.id={$this->getStudentId()};");
        $student_courses = $query->fetchAll(PDO::FETCH_ASSOC);
        $all_student_courses = array();
        foreach($student_courses as $student_course) {
            $course_id = $student_course['id'];
            $course = $student_course['course'];
            $course_number = $student_course['course_number'];
            $new_course = new Course($course, $course_number,$course_id);
            array_push($all_student_courses, $new_course);
        }
            return $all_student_courses;
    }
}
?>
