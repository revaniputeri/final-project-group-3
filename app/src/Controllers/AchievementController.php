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

    public function submissionFormProcess()
    {
        $userId = $_POST['userId'];
        $competitionTitle = $_POST['competitionTitle'];
        $competitionTitleEnglish = $_POST['competitionTitleEnglish'];   
        $competitionPlace = $_POST['competitionPlace'];
        $competitionPlaceEnglish = $_POST['competitionPlaceEnglish'];
        $competitionUrl = $_POST['competitionUrl'];
        $competitionStartDate = new \DateTime($_POST['competitionStartDate']);
        $competitionEndDate = new \DateTime($_POST['competitionEndDate']);
        $numberOfInstitutions = $_POST['numberOfInstitutions'];
        $numberOfStudents = $_POST['numberOfStudents'];
        $letterNumber = $_POST['letterNumber'];
        $letterDate = new \DateTime($_POST['letterDate']);
        $letterFile = $_FILES['letterFile']['tmp_name'];
        $certificateFile = $_FILES['certificateFile']['tmp_name'];
        $documentationFile = $_FILES['documentationFile']['tmp_name'];
        $posterFile = $_FILES['posterFile']['tmp_name'];

        $achievement = new Achievement(
            $userId,
            $competitionTitle,
            $competitionTitleEnglish,
            $competitionPlace,
            $competitionPlaceEnglish,
            $competitionUrl,
            $competitionStartDate,
            $competitionEndDate,
            $numberOfInstitutions,
            $numberOfStudents,
            $letterNumber,
            $letterDate,
            $letterFile,
            $certificateFile,
            $documentationFile,
            $posterFile,
            new \DateTime(),
            new \DateTime(),
            null
        );

        try {
            $achievementId = $achievement->saveAchievement($this->db);
            $_SESSION['success'] = "Achievement saved successfully with ID: " . $achievementId;
        } catch (\InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
        } catch (\Exception $e) {
            $_SESSION['error'] = "An error occurred while saving the achievement.";
        }

        header('Location: /achievement/submission');
        exit();
    }

    public function achievementHistory()
    {
        try {
            $achievements = Achievement::getAllAchievements($this->db);
            View::render('achievementHistory', ['achievements' => $achievements]);
        } catch (\Exception $e) {
            $_SESSION['error'] = "An error occurred while fetching achievement history.";
            header('Location: /dashboard');
            exit();
        }
    }
}