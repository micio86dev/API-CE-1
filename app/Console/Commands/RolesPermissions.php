<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RolesPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    // Roles/permissions associations
    protected $rolesPermissions = [
        'admin' => [
            'books',
            'books.index',
        ],
        'user' => [
            'books',
            'books.index',
        ],
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $roles = config('constants.ROLES');
        // $request->loggedUser->assignRole('admin');

        // Alla fine lancia call->(php artisan permission:cache-reset)
    }
}
