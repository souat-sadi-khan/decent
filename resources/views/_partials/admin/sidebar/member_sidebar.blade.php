{{-- Main Folder --}}
<li><a class="app-menu__item {{ Request::is('home') ? ' active' : '' }}" href="{{ route('home') }}"><i class="app-menu__icon fa fa-h-square"></i><span class="app-menu__label">{{_lang('Main Folder')}}</span></a></li>


{{-- Dashboard --}}
<li><a class="app-menu__item {{ Request::is('admin/setting/member-setting') ? ' active' : '' }}" href="{{ route('admin.member-setting') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">{{_lang('Dashboard')}}</span></a></li>

@can('member_nationality_setting.view')
    {{-- Nationality --}}
    <li><a class="app-menu__item {{ Request::is('admin/setting/member-setting/nationality*') ? ' active' : '' }}" href="{{ route('admin.setting.member-setting.nationality') }}"><i class="app-menu__icon fa fa-diamond"></i><span class="app-menu__label">{{_lang('Nationality')}}</span></a></li>
@endcan

@can('member_religious_setting.view')
    {{-- Nationality --}}
    <li><a class="app-menu__item {{ Request::is('admin/setting/member-setting/religious*') ? ' active' : '' }}" href="{{ route('admin.setting.member-setting.religious') }}"><i class="app-menu__icon fa fa-gift"></i><span class="app-menu__label">{{_lang('Religious')}}</span></a></li>
@endcan


@can('member_occupation_setting.view')
    {{-- Occupation --}}
    <li><a class="app-menu__item {{ Request::is('admin/setting/member-setting/occupation*') ? ' active' : '' }}" href="{{ route('admin.setting.member-setting.occupation') }}"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">{{_lang('Occupation')}}</span></a></li>
@endcan
