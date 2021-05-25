<?php


namespace App\Services;


use App\Models\User;
use App\Contract\IUserService;

class UserService implements IUserService
{

    public function createSuperAdmin(string $name, string $email, string $password): User
    {
        $user = \App\Models\User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password
        ]);

        $user->assignRole("superadmin");

        return $user;
    }

    public function createHostAdmin(string $name, string $email, string $password, ?string $contact_number, ?string $permanent_address, ?string $current_address): User
    {
        $user = \App\Models\User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "contact_number" => $contact_number,
            "permanent_address" => $permanent_address,
            "current_address" => $current_address,
        ]);

        $user->assignRole("hostadmin");

        return $user;
    }

    public function createLocalAdmin(string $name, string $email, string $password, string $contact_number, string $permanent_address, string $current_address): User
    {
        $user = \App\Models\User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "contact_number" => $contact_number,
            "permanent_address" => $permanent_address,
            "current_address" => $current_address,
        ]);

        $user->assignRole("localadmin", "employee");

        return $user;
    }
}
