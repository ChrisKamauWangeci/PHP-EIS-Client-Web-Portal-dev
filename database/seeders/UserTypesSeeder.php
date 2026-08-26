<?php

namespace Database\Seeders;

use App\Models\Accountmanager;
use App\Models\Agent;
use App\Models\Contractor;
use App\Models\ContractorAdmin;
use App\Models\Requestor;
use App\Models\Shelteragent;
use App\Models\Ticketmanager;
use App\Models\Underwriter;
use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. PRIMARY PORTAL USERS
        // -------------------------------------------------------------

        // System Administrator (AuthAdminController / Guard: admin)
        ContractorAdmin::withoutTimestamps(function () {
            return ContractorAdmin::firstOrCreate(
                ['C_Name' => 'Admin User'],
                [
                    'C_Password'    => 'Secret123!',
                    'C_UserCompany' => 'EIS',
                    'C_SysAdmin'    => 1,
                    'is_active'     => 1,
                    'C_Email'       => 'admin@expressimagingservices.com',
                    'C_Location'    => 'US Onsite',
                ]
            );
        });

        // Standard Contractor / Operational User (AuthUserController / Guard: web)
        Contractor::withoutTimestamps(function () {
            return Contractor::firstOrCreate(
                ['C_Name' => 'Standard Contractor'],
                [
                    'C_Password'    => 'Secret123!',
                    'C_UserCompany' => 'EIS',
                    'C_SysAdmin'    => 0,
                    'is_active'     => 1,
                    'C_Email'       => 'contractor@expressimagingservices.com',
                    'C_Location'    => 'US Remote',
                ]
            );
        });

        // -------------------------------------------------------------
        // 2. BUSINESS & ROLE-BASED USER ENTITIES
        // -------------------------------------------------------------

        // Requestors (Client Representative)
        Requestor::withoutTimestamps(function () {
            return Requestor::firstOrCreate(
                ['R_LoginEmail' => 'requestor@acmeinsurance.com'],
                [
                    'R_Name'       => 'Sample Requestor',
                    'R_Company'    => 'ACME Insurance',
                    'R_Email'      => 'requestor@acmeinsurance.com',
                    'R_Password'   => 'Secret123!',
                    'R_Active'     => 1,
                    'R_SuperUser'  => 0,
                ]
            );
        });

        // Shelter Agents (sdl & agent roles)
        Shelteragent::firstOrCreate(
            ['email' => 'sdl.manager@shelter.com'],
            [
                'name'                => 'Shelter District Manager',
                'role'                => 'sdl',
                'sdl_district_number' => 'D-101',
                'agent_code'          => 'S001',
                'is_active'           => true,
                'created_by'          => 'Seeder',
                'updated_by'          => 'Seeder',
            ]
        );

        Shelteragent::firstOrCreate(
            ['email' => 'shelter.agent@shelter.com'],
            [
                'name'                => 'Shelter Local Agent',
                'role'                => 'agent',
                'sdl_district_number' => 'D-101',
                'agent_code'          => 'A001',
                'is_active'           => true,
                'created_by'          => 'Seeder',
                'updated_by'          => 'Seeder',
            ]
        );

        // Ticket Manager
        Ticketmanager::firstOrCreate(
            ['email' => 'support.manager@expressimagingservices.com'],
            [
                'name' => 'Support Manager',
            ]
        );

        // Account Manager
        Accountmanager::withoutTimestamps(function () {
            return Accountmanager::firstOrCreate(
                ['Acc_Company' => 'ACME Insurance'],
                [
                    'Acc_Manager' => 'Sample Account Manager',
                ]
            );
        });

        // Insurance Agent & Underwriter Entities
        Agent::withoutTimestamps(function () {
            return Agent::firstOrCreate(
                ['A_Name' => 'Sample Agent'],
                [
                    'A_Company' => 'ACME Insurance',
                    'A_Email'   => 'agent@acmeinsurance.com',
                ]
            );
        });

        Underwriter::withoutTimestamps(function () {
            return Underwriter::firstOrCreate(
                ['U_Name' => 'Sample Underwriter'],
                [
                    'U_Company' => 'ACME Insurance',
                    'U_Email'   => 'underwriter@acmeinsurance.com',
                ]
            );
        });
    }
}
