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

        // super's submenus
        $superSubmenus = [
            '4' => [
                'name' => 'users',
                'icon' => 'bi bi-people'
            ],
            '0' => [
                'name' => 'roles',
                'icon' => 'bi bi-person-gear'
            ],
        ];

        foreach ($superSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'User')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // admin's submenus
        $adminSubmenus = [
            // '1' => [
            //     'name' => 'dashboard',
            //     'icon' => 'bi bi-speedometer'
            // ],
            '2' => [
                'name' => 'abstracts',
                'icon' => 'bi bi-file-earmark-text'
            ],
            '3' => [
                'name' => 'topics',
                'icon' => 'bi bi-list-ul'
            ],
        ];

        foreach ($adminSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Abstract')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }



        // setting's submenus
        $settingSubmenus = [
            '6' => [
                'name' => 'permissions',
                'icon' => 'bi bi-key'
            ],
            '7' => [
                'name' => 'menus',
                'icon' => 'bi bi-menu-button-wide'
            ],
            '8' => [
                'name' => 'submenus',
                'icon' => 'bi bi-menu-button-wide'
            ],
            '9' => [
                'name' => 'systems',
                'icon' => 'bi bi-gear'
            ],
        ];

        foreach ($settingSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Setting')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // Payment submenus
        $paymentSubmenus = [
            '10' => [
                'name' => 'conferences',
                'icon' => 'bi bi-building'
            ],
            '11' => [
                'name' => 'abstracts',
                'icon' => 'bi bi-journals'
            ],
            '18' => [
                'name' => 'fullpapers',
                'icon' => 'bi bi-journals'
            ],
        ];

        foreach ($paymentSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Payment')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ]);
        }

        // Refeerence submenus
        $paymentSubmenus = [
            '12' => [
                'name' => 'statuses',
                'icon' => 'bi bi-clipboard'
            ],
            '13' => [
                'name' => "Types",
                'icon' => 'bi bi-braces'
            ],
        ];

        foreach ($paymentSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Status')->get()->getRow()->id;

            $record = [
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ];

            if ($key == '13') {
                $record['url'] = base_url() . 'stypes/';
            }

            $this->db->table('submenus')->insert($record);
        }

        // Ticket submenus
        $paymentSubmenus = [
            '5' => [
                'name' => 'tickets',
                'icon' => 'bi bi-people'
            ],
            '14' => [
                'name' => 'Types',
                'icon' => 'bi bi-braces'
            ],
            '15' => [
                'name' => 'roles',
                'icon' => 'bi bi-building-gear'
            ],
            '16' => [
                'name' => "states",
                'icon' => 'bi bi-airplane'
            ],
            '17' => [
                'name' => "graduation",
                'icon' => 'bi bi-mortarboard'
            ],
        ];

        foreach ($paymentSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Ticket')->get()->getRow()->id;

            $record = [
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => base_url() . $submenu['name'] . '/',
                'icon' => $submenu['icon'],
            ];

            if ($key == '14') {
                $record['url'] = base_url() . 'ttypes/';
            }

            $this->db->table('submenus')->insert($record);
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
    }
}
