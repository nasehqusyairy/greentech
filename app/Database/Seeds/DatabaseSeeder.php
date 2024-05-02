<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $fake = \Faker\Factory::create();

        // roles
        $roles = [
            'Super Admin',
            'Admin',
            'Reviewer',
            'Member',
        ];


        foreach ($roles as $key => $role) {
            $this->db->table('roles')->insert([
                'name' => $role,
                'code' => $key,
            ]);
        }


        // make 10 users with random role
        for ($i = 0; $i < 10; $i++) {
            $role = $roles[rand(0, count($roles) - 1)];
            $role_id = $this->db->table('roles')->where('name', $role)->get()->getRow()->id;

            $this->db->table('users')->insert([
                'name' => $fake->name,
                'email' => $fake->email,
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'image' => null,
                'isActive' => 1,
                'gender' => rand(0, 2),
                'role_id' => $role_id,
            ]);
        }
        // make 1 super admin
        $this->db->table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@greentech.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'image' => null,
            'isActive' => 1,
            'gender' => 0,
            'role_id' => 1,
        ]);

        // menus
        $menus = [
            'Abstract',
            'User',
            'Payment',
            'Status',
            'Ticket',
            'Setting',
        ];

        foreach ($menus as $key => $menu) {
            $this->db->table('menus')->insert([
                'code' => $key,
                'name' => strtoupper($menu),
            ]);
        }

        // abstract submenus
        $abstractSubmenus = [
            '0' => [
                'name' => 'abstracts',
                'url' => 'abstracs',
                'icon' => 'bi bi-file-earmark-text'
            ],
            '1' => [
                'name' => 'topics',
                'url' => 'topics',
                'icon' => 'bi bi-list-ul'
            ],
        ];

        foreach ($abstractSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Abstract')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // user's submenus
        $usersSubmenus = [
            '2' => [
                'name' => 'users',
                'icon' => 'bi bi-people',
                'url' => 'users',
            ],

            '3' => [
                'name' => 'roles',
                'icon' => 'bi bi-person-gear',
                'url' => 'roles',
            ],


        ];

        foreach ($usersSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'User')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }


        // Payment submenus
        $paymentSubmenus = [
            '4' => [
                'name' => 'conferences',
                'url' => '',
                'icon' => 'bi bi-building'
            ],
            '5' => [
                'name' => 'abstracts',
                'url' => '',
                'icon' => 'bi bi-file-earmark-text'
            ],
            '6' => [
                'name' => 'full Papers',
                'url' => '',
                'icon' => 'bi bi-journals'
            ],
        ];

        foreach ($paymentSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Payment')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // Refeerence submenus
        $statusSubmenus = [
            '7' => [
                'name' => 'statuses',
                'icon' => 'bi bi-clipboard',
                'url' => 'statuses',
            ],
            '8' => [
                'name' => "types",
                'icon' => 'bi bi-braces',
                'url' => 'stypes'
            ],
        ];

        foreach ($statusSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Status')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // Ticket submenus
        $ticketSubmenus = [
            '9' => [
                'name' => 'tickets',
                'url' => 'tickets',
                'icon' => 'bi bi-ticket'
            ],
            '10' => [
                'name' => 'types',
                'url' => 'ttypes',
                'icon' => 'bi bi-braces'
            ],
            '11' => [
                'name' => 'roles',
                'url' => 'troles',
                'icon' => 'bi bi-person-gear'
            ],
            '12' => [
                'name' => 'states',
                'url' => 'states',
                'icon' => 'bi bi-airplane'
            ],
            '13' => [
                'name' => 'Studies',
                'url' => 'studies',
                'icon' => 'bi bi-mortarboard'
            ],
        ];

        foreach ($ticketSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Ticket')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // setting's submenus
        $settingSubmenus = [
            '14' => [
                'name' => 'permissions',
                'url'  => 'permissions',
                'icon' => 'bi bi-key'
            ],
            '15' => [
                'name' => 'menus',
                'url'  => 'menus',
                'icon' => 'bi bi-menu-button-wide'
            ],
            '16' => [
                'name' => 'submenus',
                'url'  => 'submenus',
                'icon' => 'bi bi-menu-down'
            ],
            '17' => [
                'name' => 'systems',
                'url' => 'systems',
                'icon' => 'bi bi-gear'
            ],
        ];

        foreach ($settingSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Setting')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['url'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // menu_role
        $menuRoles = [
            ['role' => 'Super Admin', 'menu' => $menus[0]],
            ['role' => 'Super Admin', 'menu' => $menus[1]],
            ['role' => 'Super Admin', 'menu' => $menus[2]],
            ['role' => 'Super Admin', 'menu' => $menus[3]],
            ['role' => 'Super Admin', 'menu' => $menus[4]],
            ['role' => 'Super Admin', 'menu' => $menus[5]],
            ['role' => 'Admin', 'menu' => $menus[1]],
            ['role' => 'Admin', 'menu' => $menus[2]],
            ['role' => 'Admin', 'menu' => $menus[3]],
            ['role' => 'Admin', 'menu' => $menus[4]],
            ['role' => 'Admin', 'menu' => $menus[5]],

        ];

        foreach ($menuRoles as $key => $menuRole) {
            $role_id = $this->db->table('roles')->where('name', $menuRole['role'])->get()->getRow()->id;
            $menu_id = $this->db->table('menus')->where('name', $menuRole['menu'])->get()->getRow()->id;

            $this->db->table('menu_role')->insert([
                'role_id' => $role_id,
                'menu_id' => $menu_id,
            ]);
        }

        // permissions
        $permissions = [
            'roles',
            'users',
            'permissions',
            'menus',
            'submenus',
        ];

        foreach ($permissions as $key => $permission) {
            $this->db->table('permissions')->insert([
                'path' => $permission,
            ]);
        }

        // permission_role
        $permissionRoles = [
            ['role' => 'Super Admin', 'permission' => $permissions[0]],
            ['role' => 'Super Admin', 'permission' => $permissions[1]],
            ['role' => 'Super Admin', 'permission' => $permissions[2]],
            ['role' => 'Super Admin', 'permission' => $permissions[3]],
            ['role' => 'Super Admin', 'permission' => $permissions[4]],
            ['role' => 'Admin', 'permission' => $permissions[1]],
            ['role' => 'Admin', 'permission' => $permissions[2]],
            ['role' => 'Admin', 'permission' => $permissions[3]],
            ['role' => 'Admin', 'permission' => $permissions[4]],
        ];

        foreach ($permissionRoles as $key => $permissionRole) {
            $role_id = $this->db->table('roles')->where('name', $permissionRole['role'])->get()->getRow()->id;
            $permission_id = $this->db->table('permissions')->where('path', $permissionRole['permission'])->get()->getRow()->id;

            $this->db->table('permission_role')->insert([
                'role_id' => $role_id,
                'permission_id' => $permission_id,
            ]);
        }

        // Add stypes
        $stypes = [
            'payment',
            'acceptence',
            'paper',
        ];

        foreach ($stypes as $key => $stype) {
            $this->db->table('stypes')->insert([
                'name' => $stype,
                'code' => ++$key,
            ]);
        }

        // Add statuses
        $statuses = [
            ['text' => 'Unavailable', 'color' => 'secondary', 'stype' => $stypes[0]],
            ['text' => 'Unpaid', 'color' => 'warning', 'stype' => $stypes[0]],
            ['text' => 'Paid', 'color' => 'success', 'stype' => $stypes[0]],
            ['text' => 'Unsigned', 'color' => 'secondary', 'stype' => $stypes[1]],
            ['text' => 'Reviewing', 'color' => 'info', 'stype' => $stypes[1]],
            ['text' => 'Accepted', 'color' => 'success', 'stype' => $stypes[1]],
            ['text' => 'Rejected', 'color' => 'danger', 'stype' => $stypes[1]],
            ['text' => 'Comfirmed', 'color' => 'success', 'stype' => $stypes[2]],
            ['text' => 'Rejected', 'color' => 'danger', 'stype' => $stypes[2]],
            ['text' => 'Waiting', 'color' => 'info', 'stype' => $stypes[2]],
        ];

        foreach ($statuses as $key => $status) {
            $stype_id = $this->db->table('stypes')->where('name', $status['stype'])->get()->getRow()->id;

            $this->db->table('statuses')->insert([
                'text' => $status['text'],
                'color' => $status['color'],
                'code' => ++$key,
                'stype_id' => $stype_id,
            ]);
        }

        // Add ticket roles
        $troles = [
            'Presenter',
            'Listener',
        ];

        foreach ($troles as $key => $trole) {
            $this->db->table('troles')->insert([
                'name' => $trole,
                'code' => ++$key,
            ]);
        }

        // Add ttypes 
        $ttypes = [
            'Early Bird',
            'Regular',
        ];

        foreach ($ttypes as $key => $ttype) {
            $this->db->table('ttypes')->insert([
                'name' => $ttype,
                'code' => ++$key,
            ]);
        }

        // Add states 
        $states = [
            'Local',
            'International',
            'National'
        ];

        foreach ($states as $key => $state) {
            $this->db->table('states')->insert([
                'name' => $state,
                'code' => ++$key,
            ]);
        }

        // Add studies 
        $studies = [
            'Not a Student',
            'Undergraduate Student',
            'Master and Doctoral Student',
            'Postgraduate Student'
        ];

        foreach ($studies as $key => $studie) {
            $this->db->table('studies')->insert([
                'name' => $studie,
                'code' => ++$key,
            ]);
        }

        // Add tickets 
        $tickets = [
            ['name' => 'Ticket1', 'attendance' => 'online', 'price' => 400000, 'type' => $ttypes[0], 'role' => $troles[0], 'state' => $states[0], 'study' => $studies[0]],
            ['name' => 'Ticket2', 'attendance' => 'offline', 'price' => 800000, 'type' => $ttypes[1], 'role' => $troles[1], 'state' => $states[1], 'study' => $studies[3]],
        ];

        foreach ($tickets as $key => $ticket) {
            $type_id = $this->db->table('ttypes')->where('name', $ticket['type'])->get()->getRow()->id;
            $role_id = $this->db->table('troles')->where('name', $ticket['role'])->get()->getRow()->id;
            $state_id = $this->db->table('states')->where('name', $ticket['state'])->get()->getRow()->id;
            $study_id = $this->db->table('studies')->where('name', $ticket['study'])->get()->getRow()->id;

            $this->db->table('tickets')->insert([
                'name' => $ticket['name'],
                'attendance' => $ticket['attendance'],
                'price' => $ticket['price'],
                'type_id' => $type_id,
                'role_id' => $role_id,
                'state_id' => $state_id,
                'study_id' => $study_id,
            ]);
        }

        // Add publications 
        $publications = [
            'IOP Earth and Environmental Science (Scopus Indexed)',
            'Proceedings of the International Conference on Green Technology',
            'JIA (Journal of Islamic Architecture) ** (Scopus Indexed)',
            'Jurnal Neutrino: Jurnal Fisika dan Aplikasinya (Accredited SINTA-3)',
            'El-Hayah: Journal of Biology (Accredited SINTA-3)',
        ];

        foreach ($publications as $key => $publication) {
            $this->db->table('publications')->insert([
                'name' => $publication,
            ]);
        }
    }
}
