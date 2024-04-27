<!-- SIDEBAR -->
<aside class="bd-sidebar">
  <div class="offcanvas-lg offcanvas-start text-bg-dark pb-5" id="sidebar">

    <!-- SIDEBAR HEADER -->
    <div class="sidebar-header p-3 position-sticky top-0 bg-dark z-3 d-block d-lg-none">
      <div class="text-end">
        <button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas" data-bs-target="#sidebar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
    <!-- END OF SIDEBAR HEADER -->

    <!-- LOGO -->
    <div class="p-3 text-center sidebar-logo">
      <a href="<?= base_url() ?>">
        <img src="<?= base_url() ?>assets/img/LOGO_TRANSPARAN.png" alt="LOGO TRANSPARAN" class="img-fluid rectangular-logo">
        <img src="<?= base_url() ?>assets/img/LOGO BULAT TRANSPARAN.png" alt="LOGO BULAT TRANSPARAN" width="50" class="dark-mode-logo">
      </a>
      <!-- <img src="<?= base_url() ?>assets/img/logo greentech.png" loading="lazy" alt="" class="img-fluid"> -->
    </div>
    <hr>

    <!-- SIDEBAR BODY -->
    <div class="sidebar-body mb-3">

      <div class="accordion accordion-flush">

        <?php

        use App\Models\User;

        $user = User::find(session('user'));


        $user->load('role.menus.submenus')->role->menus->each(function ($menu) {
        ?>
          <!-- <?= strtoupper($menu->name); ?> MENU -->
          <div class="accordion-item text-bg-dark border-0">

            <!-- <?= strtoupper($menu->name); ?> MENU HEADER -->
            <div class="accordion-header px-3">
              <button class="accordion-button text-bg-dark shadow-none p-0 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#submenu-<?= $menu->id; ?>">
                <?= $menu->name ?>
              </button>
            </div>

            <!-- <?= strtoupper($menu->name); ?> SUBMENU -->
            <div id="submenu-<?= $menu->id; ?>" class="accordion-collapse collapse show">
              <div class="accordion-body p-0 px-3">
                <div class="list-group list-group-flush">

                  <?php
                  $menu->submenus->each(function ($submenu) {
                    $uri = new \CodeIgniter\HTTP\URI($submenu->url);
                    $firstSegment = $uri->getSegment(1);
                  ?>
                    <a href="<?= $submenu->url ?>" class="list-group-item list-group-item-action border-0 mb-1 text-bg-dark <?= current_url(true)->getSegment(1) == $firstSegment ? 'active' : ''; ?>" data-bs-placement="right" data-bs-title="<?= $submenu->name ?>">
                      <i class="bi bi-<?= $submenu->icon ?> me-3"></i>
                      <span class="submenu-title"><?= $submenu->name ?></span>
                    </a>
                  <?php }); ?>

                </div>
              </div>
            </div>
            <!-- END OF <?= strtoupper($menu->name); ?> SUBMENU -->

          </div>
          <!-- END OF <?= strtoupper($menu->name); ?> MENU -->
        <?php
        });
        ?>


        <!-- GENERAL MENU -->
        <div class="accordion-item text-bg-dark border-0">
          <!-- GENERAL MENU HEADER -->
          <div class="accordion-header px-3">
            <button class="accordion-button text-bg-dark shadow-none p-0 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#submenu-general">
              GENERAL
            </button>
          </div>

          <!-- GENERAL SUBMENU -->
          <div id="submenu-general" class="accordion-collapse collapse show">
            <div class="accordion-body p-0 px-3">
              <div class="list-group list-group-flush">

                <a href="<?= base_url('profile'); ?>" class="list-group-item list-group-item-action border-0 mb-1 text-bg-dark <?= current_url(true)->getSegment(1) == 'profile' ? 'active' : ''; ?>" data-bs-placement="right" data-bs-title="Profile">
                  <img src="<?= $user->image ?? base_url('assets/img/person-circle.svg') ?>" alt="" width="16" class="me-3 rounded-circle border border-light">
                  <span class="submenu-title">Profile</span>
                </a>

                <a href="javascript:void()" class="list-group-item list-group-item-action border-0 mb-1 text-bg-dark" data-bs-toggle="modal" data-bs-target="#logoutModal" data-bs-placement="right" data-bs-title="Log Out">
                  <i class="bi bi-box-arrow-left me-3"></i>
                  <span class="submenu-title">Log Out</span>
                </a>

              </div>
            </div>
          </div>
          <!-- END OF GENERAL SUBMENU -->

        </div>
        <!-- END OF GENERAL MENU -->

      </div>
    </div>
    <!-- END OF SIDEBAR BODY -->

    <!-- <div class="bg-danger" style="height: 100vh;"></div> -->

  </div>

</aside>
<!-- END OF SIDEBAR -->