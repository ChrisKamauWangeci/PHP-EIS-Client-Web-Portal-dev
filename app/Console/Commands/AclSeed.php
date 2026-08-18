<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ContractorAdmin;
use DB;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclSeed extends Command
{
    protected $signature = 'acl:seed {--connection=}';

    protected $description = 'Seed permissions, roles, and assign superadmin role to contractor';

    public function handle()
    {
        $connection = $this->option('connection') ?? config('database.default');

        $this->info("Seeding permissions and roles using connection: {$connection}");

        // Ensure DB queries run on this connection
        DB::setDefaultConnection($connection);

        // 1. Define permissions
        $permissions = [
            'admin.companies.index',
            'admin.contractors.index',
            'admin.requestors.index',
            'admin.contractorlogins.index',
            'admin.workorders.index',
            'admin.websiteconfigs.index',
        ];

        // 2. Create permissions
        foreach ($permissions as $permission) {
            Permission::on($connection)->firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        // 3. Create roles
        $superAdminRole = Role::on($connection)->firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin',
        ]);

        $editorRole = Role::on($connection)->firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'admin',
        ]);

        $viewerRole = Role::on($connection)->firstOrCreate([
            'name' => 'viewer',
            'guard_name' => 'admin',
        ]);

        // 4. Assign permissions to superadmin
        // $superAdminRole->syncPermissions($permissions);

        // 5. Contractors to assign superadmin to
        $contractors = [
            'ANDRAS KENDE',
            'MICHAEL DINIO',
            'ANH LE',
            'RYAN PIMENTEL',
            'ERICK VIVAR',
        ];

        foreach ($contractors as $c) {
            $contractor = ContractorAdmin::on($connection)
                ->where('C_Name', $c)
                ->first();

            if ($contractor) {
                $contractor->assignRole($superAdminRole);
                $this->info("Assigned superadmin role to contractor: {$c}");
            } else {
                $this->warn("Contractor not found: {$c}");
            }
        }

        $this->info('ACL seeding completed successfully.');

        return 0;
    }
}
