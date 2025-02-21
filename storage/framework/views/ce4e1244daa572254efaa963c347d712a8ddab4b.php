<nav class="sidebar sidebar-offcanvas overflow-auto h-100" id="sidebar">
  <a class="navbar-brand brand-logo mt-3 d-block text-center mx-0" href="/">
    <img src="<?php echo e(asset('images/logo3.png')); ?>" style="width: 150px; border-radius: 8px;" />
  </a>
  <div class="nav-item nav-profile text-center">
    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link justify-content-center px-0">
      <div class="text-wrapper">
        <p class="profile-name text-white mb-0">ADMIN</p>
        <p class="designation text-gray">Administrator</p>
      </div>
    </a>
  </div>
  <ul class="nav">
    <li class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
        <span class="menu-title">Dashboard</span>
        <i class="icon-screen-desktop menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('user*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('user.index')); ?>">
        <span class="menu-title">Manage Users</span>
        <i class="icon-user menu-icon"></i>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" href="<?php echo e(route('category.index')); ?>">
        <span class="menu-title">Category Manage</span>
        <i class="icon-grid menu-icon"></i>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <span class="menu-title">Category Manage</span>
        <i class="icon-arrow-down menu-icon"></i>
      </a>
      <div class="collapse <?php echo e(request()->routeIs('category.index', 'subcategory.index') ? 'show' : ''); ?>" id="auth">
        <ul class="nav flex-column sub-menu"> 
          <li class="nav-item <?php echo e(request()->routeIs('category*') ? 'active' : ''); ?>"> <a class="nav-link" href="<?php echo e(route('category.index')); ?>"> Category </a></li>
          <li class="nav-item <?php echo e(request()->routeIs('subcategory*') ? 'active' : ''); ?>"> <a class="nav-link" href="<?php echo e(route('subcategory.index')); ?>"> Subcategory </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('coupon*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('coupon.index')); ?>">
        <span class="menu-title">Coupons</span>
        <i class="icon-tag menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('product*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('product.index')); ?>">
        <span class="menu-title">Products Manage</span>
        <i class="icon-grid menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('cms*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('cms.index')); ?>">
        <span class="menu-title">CMS Pages Manage</span>
        <i class="icon-notebook menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('faq*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('faq.index')); ?>">
        <span class="menu-title">FAQs Manage</span>
        <i class="icon-pencil menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('sliders*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('sliders.index')); ?>">
        <span class="menu-title">Sliders Manage</span>
        <i class="icon-puzzle menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('order*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('order.index')); ?>">
        <span class="menu-title">Orders Manage</span>
        <i class="icon-magnifier menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('enquiry*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('enquiry.index')); ?>">
        <span class="menu-title">Enquiries</span>
        <i class="icon-phone menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('push_notification*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('push_notification.index')); ?>">
        <span class="menu-title">Push Notifications</span>
        <i class="icon-speech menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('manage_forms*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('manage_forms.index')); ?>">
        <span class="menu-title">Manage Forms</span>
        <i class="icon-list menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('delivery_charges.view') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('delivery_charges.view')); ?>">
        <span class="menu-title">Delivery Charges</span>
        <i class="icon-rocket menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('roles*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('roles.index')); ?>">
        <span class="menu-title">Roles</span>
        <i class="icon-graduation menu-icon"></i>
      </a>
    </li>
    <li class="nav-item <?php echo e(request()->routeIs('subadmins*') ? 'active' : ''); ?>">
      <a class="nav-link" href="<?php echo e(route('subadmins.index')); ?>">
        <span class="menu-title">SubAdmin</span>
        <i class="icon-user-follow menu-icon"></i>
      </a>
    </li>
    <!-- <li class="nav-item nav-category"><span class="nav-link">Sample Pages</span></li> -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
        <span class="menu-title">Settings</span>
        <i class="icon-arrow-down menu-icon"></i>
      </a>
      <div class="collapse <?php echo e(request()->routeIs('changepassword', 'store_location.view') ? 'show' : ''); ?>" id="auth1">
        <ul class="nav flex-column sub-menu"> 
          <li class="nav-item <?php echo e(request()->routeIs('changepassword') ? 'active' : ''); ?>"> <a class="nav-link" href="<?php echo e(route('changepassword')); ?>">Change Password</a></li>
          <li class="nav-item <?php echo e(request()->routeIs('store_location.view') ? 'active' : ''); ?>"> <a class="nav-link" href="<?php echo e(route('store_location.view')); ?>">Privykart Store Location</a></li>
          <li class="nav-item <?php echo e(request()->routeIs('minimum_order') ? 'active' : ''); ?>"> <a class="nav-link" href="<?php echo e(route('min_order')); ?>">Minimum Order</a></li>
          <li class="nav-item"> 
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <a class="nav-link" href="#"><button type="submit" style="background: none; border: none;">Sign Out</button></a>
            </form>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>
<?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>