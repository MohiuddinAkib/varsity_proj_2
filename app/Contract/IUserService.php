<?php


namespace App\Contract;

use App\Models\User;

interface IUserService
{
    public function createSuperAdmin(string $name, string $email, string $password): User;

    public function createHostAdmin(string $name, string $email, string $password, ?string $contact_number, ?string $permanent_address, ?string $current_address): User;

    public function createLocalAdmin(string $name, string $email, string $password, string $contact_number, string $permanent_address, string $current_address, int $farm_id, int $salary_figure, string $join_date): User;

    public function createEmployee(string $name, string $contact_number, string $permanent_address, string $current_address, string $position, int $farm_id, int $salary_figure, string $join_date): User;
}
