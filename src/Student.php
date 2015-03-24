<?php
class Student
{
    private $student_name;
    private $student_id;
    private $enroll_date;

    function __construct($student_name,$enroll_date,$student_id)
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
}
?>
