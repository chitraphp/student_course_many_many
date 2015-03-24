<?php
    class Course
    {
        private $course_name;
        private $course_id;
        private $course_num;

        function __construct($course_name,$course_num,$course_id)
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

        }

        static function getAll()
        {

        }


        static function deleteAll()
        {

        }

        static function find($search_id)
        {

        }

        function updateCourse($new_name)
        {

        }

        function deleteCourse()
        {

        }

        function addStudent()
        {

        }

        function getStudents()
        {

        }
    }
?>
