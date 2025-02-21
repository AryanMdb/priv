<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex align-items-center">
    <a class="navbar-brand brand-logo text-center" href="/">
      <img src="<?php echo e(asset('images/logo3.png')); ?>" style="width: 50px; height: 50px;">
    </a>
  </div>

  <!-- Header -->
  <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
    <?php 
          use Illuminate\Support\Facades\Route;
$routeName = Route::current()->getName();
if (in_array($routeName, ['dashboard', 'user.detail', 'admin.profile'])) {
  $name = 'dashboard';
} else if (in_array($routeName, ['cms.index', 'cms.create', 'cms.store', 'cms.show', 'cms.edit', 'cms.update', 'cms.destroy', 'cms.status'])) {
  $name = 'cms manager';
} else if (in_array($routeName, ['user.index', 'user.create', 'user.store', 'user.show', 'user.edit', 'user.update', 'user.update.password', 'user.destroy', 'user.switch.toggle', 'book.switch.toggle'])) {
  $name = 'user manager';
} else if (in_array($routeName, ['category.index', 'category.create', 'category.edit', 'category.store', 'category.update', 'category.destroy', 'category.status'])) {
  $name = 'category manager';
} else if (in_array($routeName, ['faq.index', 'faq.create', 'faq.store', 'faq.show', 'faq.edit', 'faq.update', 'faq.destroy', 'faq.status'])) {
  $name = 'faq manager';
} else if (in_array($routeName, ['page.package.index', 'page.package.create', 'page.package.store', 'page.package.edit', 'page.package.update', 'page.package.destroy', 'page.package.status'])) {
  $name = 'page price manager';
} else if (in_array($routeName, ['background_images.index', 'background_images.create', 'background_images.create', 'background_images.store', 'background_images.show', 'background_images.edit', 'background_images.update', 'background_images.destroy', 'background_images.status'])) {
  $name = 'background image manager';
} else if (in_array($routeName, ['page.size.index', 'page.size.create', 'page.size.store', 'page.size.edit', 'page.size.update', 'page.size.destroy', 'page.size.status'])) {
  $name = 'page size manager';
} else {
  $name = "";
}

            ?>

    <h5 class="mb-0 font-weight-medium d-none d-lg-flex header-title">Welcome <strong
        style="color:#03ac51;padding:0 5px; text-transform:uppercase;"> Privykart </strong>Admin!</h5>
    <ul class="navbar-nav navbar-nav-right ml-auto">
      <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="font-weight-normal"> Privykart Admin </span></a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center px-0">
            <a href="<?php echo e(route('changepassword')); ?>">
              <p class="mb-1 mt-3 text-capitalize" id="userName">Change Password</p>
            </a>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <button type="submit" class="dropdown-item justify-content-center">
                <i class="dropdown-item-icon icon-power text-primary"></i>Sign Out
              </button>
            </form>
          </div>
        </div>
      </li>

    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" data-toggle="collapse"
      data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/layouts/header.blade.php ENDPATH**/ ?>