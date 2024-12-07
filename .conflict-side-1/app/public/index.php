<?php

require __DIR__ . '/../vendor/autoload.php';

use PrestaC\App\Connection;
use PrestaC\App\Router;
use PrestaC\Controllers\AchievementController;
use PrestaC\Controllers\AuthController;
use PrestaC\Controllers\IndexController;
use PrestaC\Controllers\AssetsController;
use PrestaC\Controllers\StudentController;
use PrestaC\Middleware\AuthMiddleware;

$config = require __DIR__ . '/../config.php';
$connection = new Connection(
    host: $config['host'],
    name: $config['name'],
    username: $config['username'],
    password: $config['password']
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

//logout process
Router::add(
    method: "POST",
    path: "/logout",
    controller: AuthController::class,
    function: "logoutProcess",
    dependencies: ['db' => $connection]
);

//leaderboard page
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
    path: "/dashboard/home",
    controller: IndexController::class,
    function: "getDataTableAchievements",
    dependencies: ['db' => $connection]
);

//dashboard process
Router::add(
    method: "POST",
    path: "/dashboard/home",
    controller: IndexController::class,
    function: "getDataTableAchievements",
    dependencies: ['db' => $connection]
);  

Router::add(
    method: "GET",
    path: "/dashboard/achievement/edit/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "edit",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/dashboard/achievement/edit/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "editFormProcess",
    dependencies: ['db' => $connection]
);

// profile customization page
Router::add(
    method: "GET",
    path: "/dashboard/profile-customization",
    controller: StudentController::class,
    function: "viewProfile",
    dependencies: ['db' => $connection]
);

// Profile customization process
Router::add(
    method: "POST",
    path: "/dashboard/profile-customization",
    controller: StudentController::class,
    function: "editProfileProcess",
    dependencies: ['db' => $connection]
);

// assets route
Router::add(
    method: "GET",
    path: "/assets/(?<path>.*)",
    controller: AssetsController::class,
    function: "serve",
    dependencies: []
);

// submission form within achievement submission
Router::add(
    method: "GET",
    path: "/dashboard/achievement/form",
    controller: AchievementController::class,
    function: "submissionForm",
    dependencies: ['db' => $connection]
);

// submission form process
Router::add(
    method: "POST",
    path: "/dashboard/achievement/form",
    controller: AchievementController::class,
    function: "submissionFormProcess",
    dependencies: ['db' => $connection]
);

// achievement history page
Router::add(
    method: "GET",
    path: "/dashboard/achievement/history",
    controller: AchievementController::class,
    function: "achievementHistory",
    dependencies: ['db' => $connection]
);

// info page within achievement submission
Router::add(
    method: "GET",
    path: "/dashboard/achievement/info",
    controller: AchievementController::class,
    function: "achievementInfo",
    dependencies: ['db' => $connection]
);


//SUPERVISOR
//supervisor validation process
Router::add(
    method: "POST",
    path: "/dashboard/supervisor/validation",
    controller: AchievementController::class,
    function: "supervisorValidationProcess",
    dependencies: ['db' => $connection]
);

//ADMIN
//admin validation process
Router::add(
    method: "POST",
    path: "/dashboard/admin/validation",
    controller: AchievementController::class,
    function: "adminValidationProcess",
    dependencies: ['db' => $connection]
);

// Add this route for serving uploaded files
Router::add(
    method: "GET",
    path: "/storage/achievements/(?<path>.*)",
    controller: AssetsController::class,
    function: "serveUploadedFile",
    dependencies: []
);

// achievement delete process
Router::add(
    method: "POST",
    path: "/dashboard/achievement/delete/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "deleteAchievement",
    dependencies: ['db' => $connection]
);

Router::run();
