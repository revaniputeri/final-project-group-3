<?php

namespace PrestaC\Models;

use DateTime;

class User
{
    public int $id;
    public string $fullName;
    public string $username;
    public string $password;
    public string $email;
    public string $phone;
    public string $avatar;
    public string $role;
    public DateTime $createdAt;
    public DateTime $updatedAt;
    public DateTime $deletedAt;

    
}