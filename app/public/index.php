<?php

require __DIR__ . '/../vendor/autoload.php';

use PrestaC\App\Connection;
use PrestaC\App\Router;
use PrestaC\Controllers\AchievementController;
use PrestaC\Controllers\AuthController;
use PrestaC\Controllers\IndexController;
use PrestaC\Controllers\AssetsController;
use PrestaC\Controllers\ProfileController;
use PrestaC\Middleware\AuthMiddleware;

$config = require __DIR__ . '/../config.php';
$connection = new Connection(
    host: $config['host'],
    name: $config['name'],
    username: $config['username'],
    password: $config['password']
);

// AuthController routes
Router::add(
    method: "GET",
    path: "/",
    controller: AuthController::class,
    function: "redirect",
    dependencies: ["db" => $connection]
);

Router::add(
    method: "GET",
    path: "/guest",
    controller: AchievementController::class,
    function: "getTopAchievementsForGuest",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/login",
    controller: AuthController::class,
    function: "login",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/login",
    controller: AuthController::class,
    function: "loginProcess",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/logout",
    controller: AuthController::class,
    function: "logoutProcess",
    dependencies: ['db' => $connection]
);

// AchievementController routes
Router::add(
    method: "GET",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboard",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboardProcess",
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

Router::add(
    method: "GET",
    path: "/dashboard/achievement/view/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "viewAchievement",
    dependencies: ['db' => $connection]
);

// profile customization page
Router::add(
    method: "GET",
    path: "/dashboard/profile",
    controller: ProfileController::class,
    function: "viewProfile",
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

Router::add(
    method: "GET",
    path: "/download/skema-poin",
    controller: AssetsController::class,
    function: "downloadSkemaPoin",
    dependencies: []
);

Router::add(
    method: "GET",
    path: "/download/laporan",
    controller: AssetsController::class,
    function: "downloadLaporanExcel",
    dependencies: ['db' => $connection]
);

// submission form within achievement submission
Router::add(
    method: "GET",
    path: "/dashboard/achievement/form",
    controller: AchievementController::class,
    function: "submissionForm",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/dashboard/achievement/form",
    controller: AchievementController::class,
    function: "submissionFormProcess",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/dashboard/achievement/history",
    controller: AchievementController::class,
    function: "achievementHistory",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/admin/achievement/history",
    controller: AchievementController::class,
    function: "adminHistory",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/admin/achievement/view/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "adminView",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/dashboard/achievement/delete/(?<id>[0-9]+)",
    controller: AchievementController::class,
    function: "deleteAchievement",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "POST",
    path: "/admin/achievement/update-validation",
    controller: AchievementController::class,
    function: "adminValidationProcess",
    dependencies: ['db' => $connection]
);

// IndexController routes
Router::add(
    method: "GET",
    path: "/dashboard/home",
    controller: IndexController::class,
    function: "getDataTableAchievements",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/dashboard/home",
    controller: IndexController::class,
    function: "getSemesterPerformance",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/admin/dashboard",
    controller: IndexController::class,
    function: "dashboardAdmin",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/admin/info",
    controller: IndexController::class,
    function: "info",
    dependencies: ['db' => $connection]
);

Router::add(
    method: "GET",
    path: "/dashboard/info",
    controller: IndexController::class,
    function: "info",
    dependencies: ['db' => $connection]
);

// AssetsController routes
Router::add(
    method: "GET",
    path: "/assets/(?<path>.*)",
    controller: AssetsController::class,
    function: "serve",
    dependencies: []
);

Router::add(
    method: "GET",
    path: "/storage/achievements/(?<path>.*)",
    controller: AssetsController::class,
    function: "serveUploadedFile",
    dependencies: []
);


Router::run();
