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
                'icon' => 'bi bi-building-gear',
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
                'name'=>'conferences',
                'url' =>'',
                'icon'=>'bi bi-building'
            ],
            '5' => [
                'name'=>'abstracts',
                'url'=>'',
                'icon'=>'bi bi-journals'
            ],
            '6' => [
                'name'=>'full Papers',
                'url'=>'',
                'icon'=>'bi bi-journals'
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
                'name'=>'statuses',
                'icon'=>'bi bi-clipboard',
                'url'=>'statuses',
            ],
            '8' => [
                'name'=>"types",
                'icon'=>'bi bi-braces',
                'url'=>'stypes'
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
                'name'=>'tickets',
                'url'=>'tickets',
                'icon'=>'bi bi-ticket'
            ],
            '10' => [
                'name'=>'types',
                'url'=>'ttypes',
                'icon'=>'bi bi-braces'
            ],
            '11' => [
                'name'=>'roles',
                'url'=>'troles',
                'icon'=>'bi bi-building-gear'
            ],
            '12' => [
                'name'=>'states',
                'url'=>'states',
                'icon'=>'bi bi-airplane'
            ],
            '13' => [
                'name'=>'graduation',
                'url'=>'studies',
                'icon'=>'bi bi-mortarboard'
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
                'icon' => 'bi bi-menu-button-wide'
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
    }
}
