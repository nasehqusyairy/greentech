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
            'Presenter',
            'Listener',
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

        // make 1 presenter
        $this->db->table('users')->insert([
            'name' => 'Presenter',
            'email' => 'presenter@greentech.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'image' => null,
            'isActive' => 1,
            'gender' => 0,
            'role_id' => 4,
        ]);

        // make 1 reviewer
        $this->db->table('users')->insert([
            'name' => 'Reviewer',
            'email' => 'reviewer@greentech.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'image' => null,
            'isActive' => 1,
            'gender' => 0,
            'role_id' => 3,
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
                'order' => $key + 1,
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
            '2' => [
                'name' => 'publications',
                'url' => 'publications',
                'icon' => 'bi bi-arrow-up-circle-fill'
            ],
            '001' => [
                'name' => 'reviews',
                'url' => 'reviews',
                'icon' => 'bi bi-chat-left-text'
            ],
        ];

        foreach ($abstractSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Abstract')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => $submenu['url'],
                'icon' => $submenu['icon'],
            ]);
        }

        // user's submenus
        $usersSubmenus = [
            '3' => [
                'name' => 'users',
                'icon' => 'bi bi-people',
                'url' => 'users',
            ],

            '4' => [
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
                'url' => $submenu['url'],
                'icon' => $submenu['icon'],
            ]);
        }


        // Payment submenus
        $paymentSubmenus = [
            '5' => [
                'name' => 'conferences',
                'url' => '/',
                'icon' => 'bi bi-building'
            ],
            '6' => [
                'name' => 'abstracts',
                'url' => 'abstractpayments',
                'icon' => 'bi bi-file-earmark-text'
            ],
            '7' => [
                'name' => 'full Papers',
                'url' => 'papers',
                'icon' => 'bi bi-journals'
            ],
        ];

        foreach ($paymentSubmenus as $key => $submenu) {
            $menu_id = $this->db->table('menus')->where('name', 'Payment')->get()->getRow()->id;

            $this->db->table('submenus')->insert([
                'menu_id' => $menu_id,
                'code' => $key,
                'name' => ucfirst($submenu['name']),
                'url' => $submenu['url'],
                'icon' => $submenu['icon'],
            ]);
        }

        // Refeerence submenus
        $statusSubmenus = [
            '8' => [
                'name' => 'statuses',
                'icon' => 'bi bi-clipboard',
                'url' => 'statuses',
            ],
            '9' => [
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
                'url' => $submenu['url'],
                'icon' => $submenu['icon'],
            ]);
        }

        // Ticket submenus
        $ticketSubmenus = [
            '10' => [
                'name' => 'tickets',
                'url' => 'tickets',
                'icon' => 'bi bi-ticket'
            ],
            '11' => [
                'name' => 'ticket Types',
                'url' => 'ttypes',
                'icon' => 'bi bi-braces'
            ],
            '12' => [
                'name' => 'Ticket Roles',
                'url' => 'troles',
                'icon' => 'bi bi-person-gear'
            ],
            '13' => [
                'name' => 'states',
                'url' => 'states',
                'icon' => 'bi bi-airplane'
            ],
            '14' => [
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
                'url' => $submenu['url'],
                'icon' => $submenu['icon'],
            ]);
        }

        // setting's submenus
        $settingSubmenus = [
            '15' => [
                'name' => 'permissions',
                'url'  => 'permissions',
                'icon' => 'bi bi-key'
            ],
            '16' => [
                'name' => 'menus',
                'url'  => 'menus',
                'icon' => 'bi bi-menu-button-wide'
            ],
            '17' => [
                'name' => 'submenus',
                'url'  => 'submenus',
                'icon' => 'bi bi-menu-down'
            ],
            '18' => [
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
                'url' => $submenu['url'],
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

            // presenter
            ['role' => 'Presenter', 'menu' => $menus[0]],
            ['role' => 'Presenter', 'menu' => $menus[2]],

            // reviewer
            ['role' => 'Reviewer', 'menu' => $menus[0]],
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
        $permissions = [];

        foreach ($permissions as $key => $permission) {
            $this->db->table('permissions')->insert([
                'path' => $permission,
            ]);
        }

        // permission_role
        $permissionRoles = [
            // ['role' => 'Super Admin', 'permission' => $permissions[0]],
            // ['role' => 'Super Admin', 'permission' => $permissions[1]],
            // ['role' => 'Super Admin', 'permission' => $permissions[2]],
            // ['role' => 'Super Admin', 'permission' => $permissions[3]],
            // ['role' => 'Super Admin', 'permission' => $permissions[4]],
            // ['role' => 'Admin', 'permission' => $permissions[1]],
            // ['role' => 'Admin', 'permission' => $permissions[2]],
            // ['role' => 'Admin', 'permission' => $permissions[3]],
            // ['role' => 'Admin', 'permission' => $permissions[4]],
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
                'code' => $key++,
            ]);
        }

        // Add statuses
        $statuses = [
            ['text' => 'Unavailable', 'color' => 'secondary', 'stype' => $stypes[0]],
            ['text' => 'Unpaid', 'color' => 'warning', 'stype' => $stypes[0]],
            ['text' => 'Paid', 'color' => 'success', 'stype' => $stypes[0]],
            ['text' => 'Unsigned', 'color' => 'secondary', 'stype' => $stypes[1]],
            ['text' => 'Reviewing', 'color' => 'info', 'stype' => $stypes[1]],
            ['text' => 'Need Revision', 'color' => 'warning', 'stype' => $stypes[1]],
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
        ];

        foreach ($studies as $key => $studie) {
            $this->db->table('studies')->insert([
                'name' => $studie,
                'code' => ++$key,
            ]);
        }

        // Add tickets 
        $tickets = [
            [
                'id' => $fake->uuid(),
                'name' => 'Ticket1', 'attendance' => 'online', 'price' => 400000, 'type' => $ttypes[0], 'role' => $troles[0], 'state' => $states[0],
                'currency' => 'IDR',
                'study' => $studies[0]
            ],
            [
                'id' => $fake->uuid(),
                'name' => 'Ticket2', 'attendance' => 'offline', 'price' => 800000, 'type' => $ttypes[1], 'role' => $troles[1], 'state' => $states[1],
                'currency' => 'IDR',
                'study' => $studies[2]
            ],
        ];

        foreach ($tickets as $key => $ticket) {
            $type_id = $this->db->table('ttypes')->where('name', $ticket['type'])->get()->getRow()->id;
            $role_id = $this->db->table('troles')->where('name', $ticket['role'])->get()->getRow()->id;
            $state_id = $this->db->table('states')->where('name', $ticket['state'])->get()->getRow()->id;
            $study_id = $this->db->table('studies')->where('name', $ticket['study'])->get()->getRow()->id;

            $this->db->table('tickets')->insert([
                'id' => $ticket['id'],
                'name' => $ticket['name'],
                'attendance' => $ticket['attendance'],
                'price' => $ticket['price'],
                'ttype_id' => $type_id,
                'trole_id' => $role_id,
                'state_id' => $state_id,
                'study_id' => $study_id,
            ]);
        }

        // Add publications 
        $publications = [
            ['name' => 'IOP Earth and Environmental Science (Scopus Indexed)', 'price' => 1000000],
            ['name' => 'Proceedings of the International Conference on Green Technology', 'price' => 1000000],
            ['name' => 'JIA (Journal of Islamic Architecture) ** (Scopus Indexed)', 'price' => 1000000],
            ['name' => 'Jurnal Neutrino: Jurnal Fisika dan Aplikasinya (Accredited SINTA-3)', 'price' => 1000000],
            ['name' => 'El-Hayah: Journal of Biology (Accredited SINTA-3)', 'price' => 1000000],
        ];

        foreach ($publications as $key => $publication) {
            $this->db->table('publications')->insert([
                'name' => $publication['name'],
                'price' => $publication['price']
            ]);
        }

        // Add topics
        $topics = [
            ['name' => 'Renewable Energy', 'description' => 'Renewable energy is energy that is collected from renewable resources, which are naturally replenished on a human timescale, such as sunlight, wind, rain, tides, waves, and geothermal heat.'],
            ['name' => 'Green Building', 'description' => 'Green building (also known as green construction or sustainable building) refers to both a structure and the application of processes that are environmentally responsible and resource-efficient throughout a building\'s life-cycle: from planning to design, construction, operation, maintenance, renovation, and demolition.'],
            ['name' => 'Waste Management', 'description' => 'Waste management (or waste disposal) includes the activities and actions required to manage waste from its inception to its final disposal.'],
            ['name' => 'Climate Change', 'description' => 'Climate change includes both global warming driven by human-induced emissions of greenhouse gases and the resulting large-scale shifts in weather patterns.'],
            ['name' => 'Sustainable Agriculture', 'description' => 'Sustainable agriculture is farming in sustainable ways meeting society\'s present food and textile needs, without compromising the ability for current or future generations to meet their needs.'],
        ];

        foreach ($topics as $key => $topic) {
            $this->db->table('topics')->insert([
                'name' => $topic['name'],
                'description' => $topic['description'],
            ]);
        }

        // Add abstracts
        $abstracts = [
            [
                'title' => 'The Role of Renewable Energy in Sustainable Development',
                'authors' => $fake->name,
                'emails' => $fake->email,
                'text' => $fake->text,
                'file' => base_url('uploads/jpg/1714203807_81cf61d0a2e6271dca3a.jpg'),
                'status_id' => 1,
                'creator_id' => 1,
                'topic_id' => 1,
                'reviewer_id' => 1,
            ],
        ];

        foreach ($abstracts as $abstract) {
            $this->db->table('abstracs')->insert($abstract);
        }

        // Add reviews
        $reviews = [
            [
                'file' => base_url('uploads/jpg/1714203807_81cf61d0a2e6271dca3a.jpg'),
                'comment' => $fake->text,
                'abstrac_id' => 1,
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($reviews as $review) {
            $this->db->table('reviews')->insert($review);
        }

        // Add settings
        $settings = [
            [
                'code' => '1',
                'title' => 'Abstract Submission',
                'description' => 'Enable or disable abstract submissions',
                'value' => '1',
            ],
            [
                'code' => '2',
                'title' => 'Payment',
                'description' => 'Open or close payments',
                'value' => '1',
            ]
        ];

        foreach ($settings as $setting) {
            $this->db->table('settings')->insert($setting);
        }
    }
}
