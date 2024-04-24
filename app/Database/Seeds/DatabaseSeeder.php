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
                'image' => $fake->imageUrl(),
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
            'image' => $fake->imageUrl(),
            'isActive' => 1,
            'gender' => 0,
            'role_id' => 1,
        ]);

        // menus
        $menus = [
            'Super',
            'Admin',
            'Setting',
        ];

        foreach ($menus as $key => $menu) {
            $this->db->table('menus')->insert([
                'name' => $menu,
            ]);
        }

        // super's submenus
        $superSubmenus = [
            'roles',
        ];

        foreach ($superSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Super')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'name' => ucfirst($submenu),
                'url' => $submenu . '/',
                'icon' => 'person-gear',
            ]);
        }

        // admin's submenus
        $adminSubmenus = [
            'users',
        ];

        foreach ($adminSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Admin')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'name' => ucfirst($submenu),
                'url' => $submenu . '/',
                'icon' => 'people',
            ]);
        }

        // setting's submenus
        $settingSubmenus = [
            'permissions',
            'menus',
            'submenus',
        ];

        foreach ($settingSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Setting')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'name' => ucfirst($submenu),
                'url' => $submenu . '/',
                'icon' => 'gear',
            ]);
        }

        // menu_role
        $menuRoles = [
            ['role' => 'Super Admin', 'menu' => 'Super'],
            ['role' => 'Admin', 'menu' => 'Admin'],
            ['role' => 'Admin', 'menu' => 'Setting'],
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
            'roles/',
            'users/',
            'permissions/',
            'menus/',
            'submenus/',
        ];

        foreach ($permissions as $key => $permission) {
            $this->db->table('permissions')->insert([
                'path' => $permission,
            ]);
        }

        // permission_role
        $permissionRoles = [
            ['role' => 'Super Admin', 'permission' => 'roles/'],
            ['role' => 'Super Admin', 'permission' => 'users/'],
            ['role' => 'Super Admin', 'permission' => 'permissions/'],
            ['role' => 'Super Admin', 'permission' => 'menus/'],
            ['role' => 'Super Admin', 'permission' => 'submenus/'],
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
