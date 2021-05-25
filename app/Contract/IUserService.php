<?php


namespace App\Contract;

use App\Models\User;

interface IUserService
{
    public function createSuperAdmin(string $name, string $email, string $password): User;

    public function createHostAdmin(string $name, string $email, string $password, ?string $contact_number, ?string $permanent_address, ?string $current_address): User;

    public function createLocalAdmin(string $name, string $email, string $password, string $contact_number, string $permanent_address, string $current_address): User;
}
