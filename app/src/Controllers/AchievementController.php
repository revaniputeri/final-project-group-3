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

    public function index()
    {
        View::render('achievements', '');
    }

    public function submissionForm()
    {
        session_start();
        View::render('achievement-submission', '');
    }

    public function submissionFormProcess()
    {
        session_start();
        $userId = $_SESSION['user']['id'];
        $competitionType = $_POST['competitionType'];
        $competitionLevel = $_POST['competitionLevel'];
        $competitionPoints = $_POST['competitionPoints'];
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
            null,
            $userId,
            $competitionType,
            $competitionLevel,
            $competitionPoints,
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
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        if (isset($_SESSION['error'])) {
            header('Location: /dashboard/achievement/form');
        } else {
            header('Location: /dashboard/achievement');
        }
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
