<?php

use PrestaC\App\Connection;
use PrestaC\App\Router;
use PrestaC\Controllers\AuthController;

require __DIR__ . '/../vendor/autoload.php';

$connection = new Connection(
    host: "localhost",
    name: "prestac",
    username: "root",
    password: ""
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
//leaderboard page
Router::add(
    method: "GET",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboard",
    dependencies: ['db' => $connection]
)

//leaderboard process
Router::add(
    method: "POST",
    path: "/leaderboard",
    controller: AchievementController::class,
    function: "leaderboardProcess",
    dependencies: ['db' => $connection]
)

//dashboard page
Router::add(
    method: "GET",
    path: "/dashboard",
    controller: IndexController::class,
    function: "dashboard",
    dependencies: ['db' => $connection]
)

//dashboard process
Router::add(
    method: "POST",
    path: "/dashboard",
    controller: IndexController::class,
    function: "dashboardProcess",
    dependencies: ['db' => $connection]
)

// profile customization page
Router::add(
    method: "GET",
    path: "/dashboard/profile-customization",
    controller: IndexController::class,
    function: "profileCustomization",
    dependencies: ['db' => $connection]
);

// profile customization process
Router::add(
    method: "POST",
    path: "/dashboard/profile-customization",
    controller: IndexController::class,
    function: "profileCustomizationProcess",
    dependencies: ['db' => $connection]
);

Router::run();

