{{-- Dashboard --}}
<li data-placement="bottom" title="Go to home"><a class="app-menu__item {{ Request::is('home') ? ' active' : '' }}"
                                                  href="{{ route('home') }}"><i
            class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">{{_lang('dashboard')}}</span></a>
</li>

