<ul class="metismenu" id="menu">


    @can('user.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-people-fill"></i></div>
                <div class="menu-title">@lang('general.Manage Admins')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.admin.view') }}">
                        <i class="bi-person-badge-fill"></i>
                        @lang('general.Admins')
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    {{-- إدارة الأدوار --}}
    @can('role.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-diagram-3-fill"></i></div>
                <div class="menu-title">@lang('general.Manage Roles')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.roles.view') }}">
                        <i class="bi-shield-lock-fill"></i>
                        @lang('general.Roles')
                    </a>
                </li>
            </ul>
        </li>
    @endcan


    {{-- إدارة الصلاحيات --}}

    @can('permission.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-shield-check"></i></div>
                <div class="menu-title">@lang('general.Manage Permissions')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.permissions.view') }}">
                        <i class="bi-key-fill"></i>
                        @lang('general.Permissions')
                    </a>
                </li>
            </ul>
        </li>
    @endcan
    @can('user_roles.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-person-check-fill"></i></div>
                <div class="menu-title">@lang('general.Manage Admin Roles')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.admin-role.view') }}">
                        <i class="bi-person-lines-fill"></i>
                        @lang('general.Admin Roles')
                    </a>
                </li>
            </ul>
        </li>
    @endcan

    {{-- @can('Order.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-droplet-fill"></i></div>
                <div class="menu-title">المديرون</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.order.index') }}">
                        <i class="bi bi-circle"></i>
                        @lang('إدارة المدير')
                    </a>
                </li>
            </ul>
        </li>
    @endcan --}}

    @can('stripe_settings.view')
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-credit-card-2-front-fill"></i></div>
                <div class="menu-title">@lang('general.Payment Settings')</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dash.stripe.settings') }}">
                        <i class="bi-currency-dollar"></i>
                        @lang('general.Payment')
                    </a>
                </li>
            </ul>
        </li>
    @endcan
    @can('categories.view')

    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-tags-fill"></i></div>
            <div class="menu-title">@lang('general.Manage Categories')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dash.categories.view') }}">
                    <i class="bi-folder2-open"></i> @lang('general.all_categories')
                </a>
            </li>
        </ul>
    </li>
@endcan

    @can('Products.view')

 
<li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-bag-fill" style="font-size:15px;"></i></div>
            <div class="menu-title">@lang('general.Manage Products')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dash.products.view') }}">
                    <i class="bi-bag"></i>
                    @lang('general.all_products')
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('heritages.view')
    
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-building"></i></div>
            <div class="menu-title">@lang('general.Manage Heritages')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dash.heritage.view') }}">
                    <i class="bi bi-flower1"></i>
                    @lang('general.all_heritages')
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('Artisan')
    
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-scissors"></i></div>
            <div class="menu-title">@lang('general.Manage Artisan')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dash.artisans.view') }}">
                    <i class="bi bi-flower3"></i>
                    @lang('general.all_artisans')
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('messages')
    
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi bi-chat-dots"></i></div>
            <div class="menu-title">@lang('general.Manage Messages')</div>
        </a>
        <ul>
            <li>
                <a href="{{ route('dash.messages.view') }}">
                    <i class="bi bi-journal-text"></i>
                    @lang('general.all_messages')
                </a>
            </li>

            <li>
                <a href="{{ route('dash.info.view') }}">
                    <i class="bi bi-info-circle"></i>
                    @lang('general.all_info')
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('reviews')
    
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
                <i class="bi bi-star-fill"></i>
            </div>
            <div class="menu-title">@lang('general.Manage Reviews')</div>
        </a>

        <ul>
            <li>
                <a href="{{ route('dash.reviews.view') }}">
                    <i class="bi bi-chat-square-text"></i>
                    @lang('general.all_reviews')
                </a>
            </li>
        </ul>
    </li>
@endcan

@can('Order')
    
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon">
                <i class="bi bi-bag-check"></i>
            </div>
            <div class="menu-title">@lang('general.Manage Order')</div>
        </a>

        <ul>
            <li>
                <a href="{{ route('dash.Order.view') }}">
                    <i class="bi bi-receipt"></i> @lang('general.all_order')
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="{{ route('dash.Order-item.view') }}">
                    <i class="bi bi-list-check"></i> @lang('general.all_order-item')
                </a>
            </li>
        </ul>
    </li>
@endcan


</ul>
