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

    public function createLocalAdmin(string $name, string $email, string $password, string $contact_number, string $permanent_address, string $current_address, int $farm_id, int $salary_figure, string $join_date): User
    {
        $user = \App\Models\User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "contact_number" => $contact_number,
            "permanent_address" => $permanent_address,
            "current_address" => $current_address,
            "farm_id" => $farm_id,
            "salary_figure" => $salary_figure,
            "join_date" => $join_date,
        ]);

        $user->assignRole("localadmin", "employee");

        return $user;
    }

    public function createEmployee(string $name, string $contact_number, string $permanent_address, string $current_address, string $position, int $farm_id, int $salary_figure, string $join_date): User
    {
        $user = \App\Models\User::create([
            "name" => $name,
            "password" => "12345678",
            "farm_id" => $farm_id,
            "join_date" => $join_date,
            "salary_figure" => $salary_figure,
            "contact_number" => $contact_number,
            "current_address" => $current_address,
            "permanent_address" => $permanent_address,
        ]);

        $user->assignRole("employee", $position);

        return $user;
    }
}
