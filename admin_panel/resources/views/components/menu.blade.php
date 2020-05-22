<aside id="aside" class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset('/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <div class="sidebar">
        <div>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ $user->profile->avatar ? $user->profile->avatar : '/img/avatar.svg' }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ $user->name }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <x-menu-item link="{{ route('admin.home') }}" icon="fas fa-tachometer-alt" label="داشبرد"></x-menu-item>

                    <x-menu-item icon="fab fa-product-hunt" link="#" :root="true" label="محصولات">
                        <ul class="nav nav-treeview">
                            <x-menu-item icon="fas fa-plus-circle" link="{{ route('admin.product.create') }}" label="افزودن محصول"></x-menu-item>
                            <x-menu-item icon="fa fa-ellipsis-h" link="{{ route('admin.product.index') }}" label="مدیریت محصول"></x-menu-item>
                            <x-menu-item icon="fas fa-ellipsis-h" link="{{ route('admin.category.index') }}" label="مدیریت دسته بندی ها"></x-menu-item>
                            <li class="dropdown-divider"></li>
                        </ul>
                    </x-menu-item>

                    <x-menu-item icon="fa fa-eye" link="#" :root="true" label="نمایش">
                        <ul class="nav nav-treeview">
                            <x-menu-item icon="fa fa-plus-circle" link="{{ route('admin.event.create') }}" label="افزودن رویداد"></x-menu-item>
                            <x-menu-item icon="fas fa-ellipsis-h" link="{{ route('admin.product.index') }}" label="مدیریت رویداد ها"></x-menu-item>
                            <x-menu-item icon="fas fa-plus-circle" link="{{ route('admin.slide.create') }}" label="افزودن اسلاید"></x-menu-item>
                            <x-menu-item icon="fas fa-ellipsis-h" link="{{ route('admin.slide.index') }}" label="مدیریت اسلایدها"></x-menu-item>
                            <li class="dropdown-divider"></li>
                        </ul>
                    </x-menu-item>

                    <x-menu-item icon="fa fa-users" link="#" :root="true" label="کاربران">
                        <ul class="rounded nav nav-treeview">
                            <x-menu-item icon="fas fa-ellipsis-h" link="{{ route('admin.user.index') }}" label="مدیریت کاربران"></x-menu-item>
                            <x-menu-item icon="fas fa-universal-access" link="" label="دسترسی ها"></x-menu-item>
                            <li class="dropdown-divider"></li>
                        </ul>
                    </x-menu-item>

                    <x-menu-item icon="fas fa-cogs" link="#" label="تنظیمات"></x-menu-item>

                    <x-menu-item icon="fas fa-eye" link="{{ route('admin.comment.index') }}" label="نظرات"></x-menu-item>

                    <x-menu-item icon="fas fa-sign-out-alt" link="{{ route('logout') }}" label="خروج"></x-menu-item>

                </ul>
            </nav>
        </div>
    </div>

    <script>
        let active  = aside.querySelector('.active');
        let ulParent = active.parentElement.parentElement;
        let liParent = ulParent.parentElement
        ulParent.classList.add('menu-open');
        liParent.classList.add('menu-open');
        ulParent.style.display = 'block';
        ulParent.previousElementSibling.classList.add('active')
    </script>
</aside>

