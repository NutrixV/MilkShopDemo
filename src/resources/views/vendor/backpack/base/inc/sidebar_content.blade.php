<!-- This file is used to store sidebar items, inside the Backpack admin panel -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Категорії -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="la la-list nav-icon"></i> Категорії</a></li>

<!-- Продукти -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="la la-box nav-icon"></i> Продукти</a></li>

<!-- Клієнти -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('customer') }}"><i class="la la-users nav-icon"></i> Клієнти</a></li>

<!-- Замовлення -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="la la-shopping-cart nav-icon"></i> Замовлення</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Адміністрування</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('admin-user') }}"><i class="nav-icon la la-user-shield"></i> Адміністратори</a></li>
    </ul>
</li> 