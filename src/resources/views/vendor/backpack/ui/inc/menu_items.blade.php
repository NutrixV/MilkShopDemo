{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Категорії" icon="la la-list" :link="backpack_url('category')" />
<x-backpack::menu-item title="Продукти" icon="la la-box" :link="backpack_url('product')" />
<x-backpack::menu-item title="Клієнти" icon="la la-users" :link="backpack_url('customer')" />
<x-backpack::menu-item title="Замовлення" icon="la la-shopping-cart" :link="backpack_url('order')" />

<x-backpack::menu-dropdown title="Адміністрування" icon="la la-users">
    <x-backpack::menu-dropdown-item title="Адміністратори" icon="la la-user-shield" :link="backpack_url('admin-user')" />
</x-backpack::menu-dropdown>