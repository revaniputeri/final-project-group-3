<?php

require __DIR__ . '/../vendor/autoload.php';

use PrestaC\App\Connection;
use PrestaC\App\Router;
use PrestaC\Controllers\AchievementController;
use PrestaC\Controllers\AuthController;
use PrestaC\Controllers\IndexController;

$connection = new Connection(
    host: "REVANIPUTERI",
    name: "prestac",
    username: "",
    password: ""
);

Router::add(
    method: "GET",
    path: "/",
    controller: AuthController::class,
    function: "redirect",
    dependencies: ["db" => $connection]
);

//guest page
Router::add(
    method: "GET",
    path: "/guest",
    controller: AuthController::class,
    function: "guest",
    dependencies: ['db' => $connection]
);

//register page
Router::add(
    method: "GET",
    path: "/register",
    controller: AuthController::class,
    function: "register",
    dependencies: ['db' => $connection]
);

//register process
Router::add(
    method: "POST",
    path: "/register",
    controller: AuthController::class,
    function: "registerProcess",
    dependencies: ['db' => $connection]
);

//login page
Router::add(
    method: "GET",
    path: "/login",
    controller: AuthController::class,
    function: "login",
    dependencies: ['db' => $connection]
);

//login process
Router::add(
    method: "POST",
    path: "/login",
    controller: AuthController::class,
    function: "loginProcess",
    dependencies: ['db' => $connection]
);

// //leaderboard page
Router::add(
    method: "GET",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboard",
    dependencies: ['db' => $connection]
);

//leaderboard process
Router::add(
    method: "POST",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboardProcess",
    dependencies: ['db' => $connection]
);

//dashboard page
Router::add(
    method: "GET",
    path: "/dashboard",
    controller: IndexController::class,
    function: "dashboard",
    dependencies: ['db' => $connection]
);

//dashboard process
Router::add(
    method: "POST",
    path: "/dashboard",
    controller: IndexController::class,
    function: "dashboardProcess",
    dependencies: ['db' => $connection]
);

// home page within the dashboard
Router::add(
    method: "GET",
    path: "/dashboard/home",
    controller: IndexController::class,
    function: "home",
    dependencies: ['db' => $connection]
);

// achievement submission page
Router::add(
    method: "GET",
    path: "/dashboard/achievement-submission",
    controller: AchievementController::class,
    function: "achievementSubmission",
    dependencies: ['db' => $connection]
);

// achievement submission process
// Router::add(
//     method: "POST",
//     path: "/dashboard/achievement-submission",
//     controller: AchievementController::class,
//     function: "achievementSubmissionProcess",
//     dependencies: ['db' => $connection]
// );

// submission form within achievement submission
Router::add(
    method: "GET",
    path: "/dashboard/achievement-submission/form",
    controller: AchievementController::class,
    function: "submissionForm",
    dependencies: ['db' => $connection]
);

// submission form process
Router::add(
    method: "POST",
    path: "/dashboard/achievement-submission/form",
    controller: AchievementController::class,
    function: "submissionFormProcess",
    dependencies: ['db' => $connection]
);

// achievement history page
Router::add(
    method: "GET",
    path: "/dashboard/achievement-submission/history",
    controller: AchievementController::class,
    function: "achievementHistory",
    dependencies: ['db' => $connection]
);

// info page within achievement submission
Router::add(
    method: "GET",
    path: "/dashboard/achievement-submission/info",
    controller: AchievementController::class,
    function: "achievementInfo",
    dependencies: ['db' => $connection]
);

Router::run();
