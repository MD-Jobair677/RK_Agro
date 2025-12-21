<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2 logo-big">
                <img src="{{ getImage(getFilePath('logoFavicon') . '/logo_dark.png') }}" alt="logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder logo-small">
                <img src="{{ getImage(getFilePath('logoFavicon') . '/favicon.png') }}" alt="logo">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="las la-chevron-left align-middle"></i>
        </a>
    </div>

    <div id="searchBoxSm"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ sideMenuActive('admin.dashboard', 1) }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-tachometer-alt text-primary"></i>
                <div class="text-truncate">@lang('Dashboard')</div>
            </a>
        </li>
        <!-- manange users -->
        {{-- <li class="menu-item {{ sideMenuActive('admin.user*', 2) }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-users text-purple"></i>
                <div class="text-truncate text-nowrap d-inline-block">@lang('Manage Users')</div>
                @if ($bannedUsersCount > 0 || $emailUnconfirmedUsersCount > 0 || $mobileUnconfirmedUsersCount > 0 || $kycUnconfirmedUsersCount > 0 || $kycPendingUsersCount > 0)
                <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">
                    <i class="las la-exclamation"></i>
                </div>
                @endif
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.user.index', 1) }}">
                    <a href="{{ route('admin.user.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('All Users')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.active', 1) }}">
                    <a href="{{ route('admin.user.active') }}" class="menu-link">
                        <div class="text-truncate">@lang('Active')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.banned', 1) }}">
                    <a href="{{ route('admin.user.banned') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('Banned')</div>
                        @if ($bannedUsersCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $bannedUsersCount }}</div>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.kyc.pending', 1) }}">
                    <a href="{{ route('admin.user.kyc.pending') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('KYC Pending')</div>
                        @if ($kycPendingUsersCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $kycPendingUsersCount }}</div>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.kyc.unconfirmed', 1) }}">
                    <a href="{{ route('admin.user.kyc.unconfirmed') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('KYC Unconfirmed')</div>
                        @if ($kycUnconfirmedUsersCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $kycUnconfirmedUsersCount }}</div>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.email.unconfirmed', 1) }}">
                    <a href="{{ route('admin.user.email.unconfirmed') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('Email Unconfirmed')</div>
                        @if ($emailUnconfirmedUsersCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $emailUnconfirmedUsersCount }}</div>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.user.mobile.unconfirmed', 1) }}">
                    <a href="{{ route('admin.user.mobile.unconfirmed') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('Mobile Unconfirmed')</div>
                        @if ($mobileUnconfirmedUsersCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $mobileUnconfirmedUsersCount }}</div>
                        @endif
                    </a>
                </li>
            </ul>
        </li> --}}

        <li class="menu-header small">
            <span class="menu-header-text">@lang('Admins')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.admin*', 1) }}">
            <a href="{{ route('admin.admin.index') }}" class="menu-link">
                <div class="text-truncate">@lang('Admin List')</div>
            </a>
        </li>

        {{-- Category manage --}}
        <li class="menu-header small">
            <span class="menu-header-text">@lang('Category')</span>
        </li>


        <li class="menu-item {{ sideMenuActive('admin.category*', 1) }}">
            <a href="{{ route('admin.category.index') }}" class="menu-link">
                <div class="text-truncate">@lang('Category')</div>
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.cattle.category*', 1) }}">
            <a href="{{ route('admin.cattle.category.index') }}" class="menu-link">
                <div class="text-truncate">@lang('Cattle Category')</div>
            </a>
        </li>

        {{-- Accounts manage --}}
        <li class="menu-header small">
            <span class="menu-header-text">@lang('Expense Manage')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.account*', 3) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Expenses')</div>
            </a>
            <ul class="menu-sub">
                {{-- <li class="menu-item {{ sideMenuActive('admin.account.head.index*', 1) }}">
                    <a href="{{ route('admin.account.head.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Account Head')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.account.sub_head.index*', 1) }}">
                    <a href="{{ route('admin.account.sub_head.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Account Sub Head')</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ sideMenuActive('admin.account.gen_expns.index*', 1) }}">
                    <a href="{{ route('admin.account.gen_expns.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Expense History')</div>
                    </a>
                </li>
            </ul>
        </li>


        {{-- Cattle manage --}}
        <li class="menu-header small">
            <span class="menu-header-text">@lang('Cattle Manage')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.cattle*', 3) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Cattles')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.cattle.index*', 1) }}">
                    <a href="{{ route('admin.cattle.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Cattle List')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.booking.index*', 1) }}">
                    <a href="{{ route('admin.booking.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Cattle bookings')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Common System Manage --}}
        <li class="menu-header small">
            <span class="menu-header-text">@lang('Common System Manage')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.common*', 3) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Common Setup')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.common.warehouse.index*', 1) }}">
                    <a href="{{ route('admin.common.warehouse.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Warehouse')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.common.item.index*', 1) }}">
                    <a href="{{ route('admin.common.item.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Item List')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.supplier.index*', 1) }}">
                    <a href="{{ route('admin.supplier.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Supplier List')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.customer.index*', 1) }}">
                    <a href="{{ route('admin.customer.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Customer List')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Inventory Manage --}}
        <li class="menu-header small">
            <span class="menu-header-text">@lang('Inventory Manage')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.inventory*', 3) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Inventory')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.inventory.stock*', 1) }}">
                    <a href="{{ route('admin.inventory.stock.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Inventory Stock History')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.inventory.issue*', 1) }}">
                    <a href="{{ route('admin.inventory.issue.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Inventory Issues History')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Role & Permission manage --}}

        <li class="menu-header small">
            <span class="menu-header-text">@lang('Role & Permission')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.role*', 3) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Role')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.role.index*', 1) }}">
                    <a href="{{ route('admin.role.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Role List')</div>
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.role.list*', 1) }}">
                    <a href="{{ route('admin.role.list') }}" class="menu-link">
                        <div class="text-truncate">@lang('User Role')</div>
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.role.permission.list*', 1) }}">
                    <a href="{{ route('admin.role.permission.list') }}" class="menu-link">
                        <div class="text-truncate">@lang('Role & Permission')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- 
        <li class="menu-header small">
            <span class="menu-header-text">@lang('FINANCE')</span>
        </li>
        <!-- payment gateway -->
        <li class="menu-item {{ sideMenuActive('admin.gateway*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-credit-card text-info"></i>
                <div class="text-truncate">@lang('Payment Methods')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.gateway.automated*', 1) }}">
                    <a href="{{ route('admin.gateway.automated.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Automated')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.gateway.manual*', 1) }}">
                    <a href="{{ route('admin.gateway.manual.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Manual')</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- deposit -->
        <li class="menu-item {{ sideMenuActive('admin.deposit*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-hand-holding-usd text-success"></i>
                <div class="text-truncate text-nowrap d-inline-block">@lang('Deposit')</div>
                @if ($pendingDepositsCount)
                <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">
                    <i class="las la-exclamation"></i>
                </div>
                @endif
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.deposit.list', 1) }}">
                    <a href="{{ route('admin.deposit.list') }}" class="menu-link">
                        <div class="text-truncate">@lang('All')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.deposit.approved', 1) }}">
                    <a href="{{route('admin.deposit.approved')}}" class="menu-link">
                        <div class="text-truncate">@lang('Approved')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.deposit.pending', 1) }}">
                    <a href="{{route('admin.deposit.pending')}}" class="menu-link">
                        <div class="text-truncate">@lang('Pending')</div>
                        @if ($pendingDepositsCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $pendingDepositsCount }}</div>
                        @endif
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.deposit.successful', 1) }}">
                    <a href="{{route('admin.deposit.successful')}}" class="menu-link">
                        <div class="text-truncate">@lang('Successful')</div>
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.deposit.rejected', 1) }}">
                    <a href="{{route('admin.deposit.rejected')}}" class="menu-link">
                        <div class="text-truncate">@lang('Rejected')</div>
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.deposit.initiated', 1) }}">
                    <a href="{{route('admin.deposit.initiated')}}" class="menu-link">
                        <div class="text-truncate">@lang('Initiated')</div>
                    </a>
                </li>

            </ul>
        </li>
        

        <li class="menu-item {{ sideMenuActive('admin.withdraw*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-university text-pink"></i>
                <div class="text-truncate text-nowrap d-inline-block">@lang('Withdrawals')</div>
                @if ($pendingWithdrawalsCount)
                <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">
                    <i class="las la-exclamation"></i>
                </div>
                @endif
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.withdraw.method*', 1) }}">
                    <a href="{{ route('admin.withdraw.method.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('Methods')</div>
                    </a>
                </li>

                <li class="menu-item {{ sideMenuActive('admin.withdraw.index', 1) }}">
                    <a href="{{ route('admin.withdraw.index') }}" class="menu-link">
                        <div class="text-truncate">@lang('All')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.withdraw.pending', 1) }}">
                    <a href="{{ route('admin.withdraw.pending') }}" class="menu-link">
                        <div class="text-truncate text-nowrap d-inline-block">@lang('Pending')</div>
                        @if ($pendingWithdrawalsCount)
                        <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $pendingWithdrawalsCount }}</div>
                        @endif
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.withdraw.approved', 1) }}">
                    <a href="{{ route('admin.withdraw.approved') }}" class="menu-link">
                        <div class="text-truncate">@lang('Approved')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.withdraw.rejected', 1) }}">
                    <a href="{{ route('admin.withdraw.rejected') }}" class="menu-link">
                        <div class="text-truncate">@lang('Rejected')</div>
                    </a>
                </li>
            </ul>
        </li>

        
        <li class="menu-item {{ sideMenuActive('admin.transaction*', 1) }}">
            <a href="{{ route('admin.transaction.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-exchange-alt text-primary"></i>
                <div class="text-truncate">@lang('Transactions')</div>
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.contact*', 1) }}">
            <a href="{{ route('admin.contact.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-address-book text-info"></i>
                <div class="text-truncate">@lang('Contacts')</div>
                @if ($unansweredContactsCount)
                <div class="badge bg-label-danger fs-tiny rounded-pill ms-auto">{{ $unansweredContactsCount }}</div>
                @endif
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.subscriber*', 1) }}">
            <a href="{{ route('admin.subscriber.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-user-plus text-success"></i>
                <div class="text-truncate">@lang('Subscribers')</div>
            </a>
        </li> --}}

        <li class="menu-header small">
            <span class="menu-header-text">@lang('GENERAL PREFERENCES')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.basic*', 1) }}">
            <a href="{{ route('admin.basic.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-cog text-purple"></i>
                <div class="text-truncate">@lang('Settings')</div>
            </a>
        </li>

        {{-- <li class="menu-item {{ sideMenuActive('admin.notification*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons las la-bell text-cyan"></i>
                <div class="text-truncate">@lang('Email & SMS')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ sideMenuActive('admin.notification.versatile', 1) }}">
                    <a href="{{ route('admin.notification.versatile') }}" class="menu-link">
                        <div class="text-truncate">@lang('Versatile Template')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.notification.email', 1) }}">
                    <a href="{{ route('admin.notification.email') }}" class="menu-link">
                        <div class="text-truncate">@lang('Email Config')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.notification.sms', 1) }}">
                    <a href="{{ route('admin.notification.sms') }}" class="menu-link">
                        <div class="text-truncate">@lang('SMS Config')</div>
                    </a>
                </li>
                <li class="menu-item {{ sideMenuActive('admin.notification.templates', 1) }}">
                    <a href="{{ route('admin.notification.templates') }}" class="menu-link">
                        <div class="text-truncate">@lang('All Templates')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.plugin*', 1) }}">
            <a href="{{ route('admin.plugin.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-plug text-blue"></i>
                <div class="text-truncate">@lang('Plugins')</div>
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.language*', 1) }}">
            <a href="{{ route('admin.language.index') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-language text-indigo"></i>
                <div class="text-truncate">@lang('Language')</div>
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.seo*', 1) }}">
            <a href="{{ route('admin.seo.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-globe text-pink"></i>
                <div class="text-truncate">@lang('SEO')</div>
            </a>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.kyc*', 1) }}">
            <a href="{{ route('admin.kyc.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-user-check text-primary"></i>
                <div class="text-truncate">@lang('KYC')</div>
            </a>
        </li> --}}

        {{-- <li class="menu-header small">
            <span class="menu-header-text">@lang('CLIENT SIDE')</span>
        </li>

        <li class="menu-item {{ sideMenuActive('admin.site.sections*', 2) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons la la-grip-horizontal text-info"></i>
                <div class="text-truncate">@lang('CMS')</div>
            </a>
            <ul class="menu-sub">
                @php $lastSegment = collect(request()->segments())->last(); @endphp

                @foreach (getPageSections(true) as $key => $section)
                <li class="menu-item @if ($lastSegment == $key) active @endif">
                    <a href="{{ route('admin.site.sections', $key) }}" class="menu-link">
                        <div class="text-truncate">{{ __($section['name']) }}</div>
                    </a>
                </li>
                @endforeach
            </ul>
        </li> --}}

        <li class="menu-header small">
            <span class="menu-header-text">@lang('OTHERS')</span>
        </li>

        {{-- <li class="menu-item {{ sideMenuActive('admin.cookie*', 1) }}">
            <a href="{{ route('admin.cookie.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-cookie text-purple"></i>
                <div class="text-truncate">@lang('GDPR Cookie')</div>
            </a>
        </li> --}}


        <li class="menu-item sidebar-menu-item">
            <a href="{{ route('admin.cache.clear') }}" class="menu-link">
                <i class="menu-icon tf-icons las la-eraser text-indigo"></i>
                <div class="text-truncate">@lang('Cache Clear')</div>
            </a>
        </li>

    </ul>
</aside>
