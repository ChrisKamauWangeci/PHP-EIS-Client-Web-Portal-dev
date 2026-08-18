<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AclReset extends Command
{
    protected $signature = 'acl:reset {--connection=}';

    protected $description = 'Reset Spatie ACL tables safely for SQL Server (FK-safe, no DBCC)';

    public function handle()
    {
        $connection = $this->option('connection') ?? config('database.default');

        $this->info("Using database connection: {$connection}");
        $db = DB::connection($connection);

        $this->info('Deleting pivot tables first...');

        $db->table('model_has_permissions')->delete();
        $db->table('model_has_roles')->delete();
        $db->table('role_has_permissions')->delete();

        $this->info('Deleting main tables...');

        $db->table('permissions')->delete();
        $db->table('roles')->delete();

        $this->info('ACL tables reset complete.');
        $this->warn('Identity columns NOT reseeded (SQL Server limitation unless using DBCC CHECKIDENT WITH RESEED).');

        return 0;
    }
}

// -- Disable foreign key checks
// ALTER TABLE role_has_permissions NOCHECK CONSTRAINT ALL;
// ALTER TABLE model_has_roles NOCHECK CONSTRAINT ALL;
// ALTER TABLE model_has_permissions NOCHECK CONSTRAINT ALL;

// -- Delete pivot tables
// DELETE FROM role_has_permissions;
// DELETE FROM model_has_roles;
// DELETE FROM model_has_permissions;

// -- Delete main tables
// DELETE FROM permissions;
// DELETE FROM roles;

// -- Reset identity columns (requires ALTER permission)
// DBCC CHECKIDENT ('permissions', RESEED, 0);
// DBCC CHECKIDENT ('roles', RESEED, 0);

// -- Re-enable foreign key checks
// ALTER TABLE role_has_permissions WITH CHECK CHECK CONSTRAINT ALL;
// ALTER TABLE model_has_roles WITH CHECK CHECK CONSTRAINT ALL;
// ALTER TABLE model_has_permissions WITH CHECK CHECK CONSTRAINT ALL;
