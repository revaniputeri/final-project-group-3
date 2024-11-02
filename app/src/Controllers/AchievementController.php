<?php

namespace PrestaC\Controllers;

use PDO;
use PrestaC\App\View;
use PrestaC\Models\Achievement;

class AchievementController
{
    protected PDO $db;

    function __construct(array $dependencies)
    {
        $this->db = $dependencies['db']->getConnection();
    }

    public function achievementSubmission () 
    {
        View::render('achievementSubmission', '');
    }

    public function submissionForm () 
    {
        View::render('achievementForm', '');
    }

    public function submissionFormProcess ()
    {
        $userId = $_POST['userId'];
        $competitionTitle = $_POST['competitionTitle'];
        $competitionTitleEnglish = $_POST['competitionTitleEnglish'];   
        $competitionPlace = $_POST['competitionPlace'];
        $competitionPlaceEnglish = $_POST['competitionPlaceEnglish'];
        $competitionUrl = $_POST['competitionUrl'];
        $competitionStartDate = $_POST['competitionStartDate'];
        $competitionEndDate = $_POST['competitionEndDate'];
        $numberOfInstitutions = $_POST['numberOfInstitutions'];
        $numberOfStudents = $_POST['numberOfStudents'];
        $letterNumber = $_POST['letterNumber'];
        $letterDate = $_POST['letterDate'];
        $letterFile = $_FILES['letterFile'];
        $certificateFile = $_FILES['certificateFile'];
        $documentationFile = $_FILES['documentationFile'];
        $posterFile = $_FILES['posterFile'];

        session_start();

        
    }
}