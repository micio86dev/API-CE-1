<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync roles and permissions';

    // Roles/permissions associations
    protected array $permissionsMap = [
        'editor' => [
            'addresses',
            'addresses.index',
            'addresses.show',
            'addresses.store',
            'addresses.update',
            'authors',
            'authors.index',
            'authors.show',
            'authors.store',
            'authors.update',
            'books',
            'books.index',
            'books.show',
            'books.store',
            'books.update',
            'books_quantity.move_books',
            'collections',
            'collections.index',
            'collections.show',
            'collections.store',
            'collections.update',
            'customers',
            'customers.index',
            'customers.show',
            'customers.store',
            'customers.update',
            'locations',
            'locations.index',
            'locations.show',
            'locations.store',
            'locations.update',
            'types',
            'types.index',
            'types.show',
            'types.store',
            'types.update',
        ],
        'user' => [
            'addresses',
            'addresses.index',
            'addresses.show',
            'authors',
            'authors.index',
            'authors.show',
            'books',
            'books.index',
            'books.show',
            'collections',
            'collections.index',
            'collections.show',
            'customers',
            'customers.index',
            'customers.show',
            'locations',
            'locations.index',
            'locations.show',
            'types',
            'types.index',
            'types.show',
        ],
    ];

    /**
     * Execute the console command.
     */
    protected string $guardName = 'api';

    public function handle(): int
    {
        $roles = config('constants.ROLES', []);

        if (empty($roles)) {
            $this->error('No roles found in config/constants.php');
            return self::FAILURE;
        }

        DB::beginTransaction();
        try {
            $allPermissions = collect($this->permissionsMap)->flatten()->unique()->all();
            foreach ($allPermissions as $perm) {
                Permission::firstOrCreate(['name' => $perm, 'guard_name' => $this->guardName]);
            }

            foreach ($roles as $roleName) {
                $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => $this->guardName]);

                $permissions = $this->permissionsMap[$roleName] ?? [];
                $role->syncPermissions($permissions);
            }

            DB::commit();
            $this->info('Roles/permissions synced.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Sync failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
