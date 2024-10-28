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
    function: "prosesLogin",
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
    function: "prosesRegister",
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