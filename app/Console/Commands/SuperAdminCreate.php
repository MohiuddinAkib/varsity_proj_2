<?php

namespace App\Console\Commands;

use App\Facades\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class SuperAdminCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates super user to control the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask("Enter name");
        $email = $this->ask("Enter email address");
        $password = $this->secret("Enter password");

        Validator::make(
            [
                "name" => $name,
                "email" => $email,
                "password" => $password
            ],
            [
                "name" => ["required", "string"],
                "password" => ["required", "string", "min:8"],
                "email" => ["required", "email", "unique:users,email"],
            ]
        )->validate();

        try {
            User::createSuperAdmin($name, $email, $password);
            $this->info("Successfully created user");
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
