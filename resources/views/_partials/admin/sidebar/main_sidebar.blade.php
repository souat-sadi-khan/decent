{{-- Dashboard --}}
<li data-placement="bottom" title="Go to home">
    <a class="app-menu__item {{ Request::is('home') ? ' active' : '' }}" href="{{ route('home') }}">
        <i class="app-menu__icon fa fa-dashboard"></i>
        <span class="app-menu__label">
            {{_lang('dashboard')}}
        </span>
    </a>
</li>

@can('ecommerce.view')
@if(Request::is('admin/eCommerce*'))
    {{-- Ecommerce Dashboard --}}
    <li data-placement="bottom" title="Go to eCommerce Dashboard">
        <a class="app-menu__item {{ Request::is('admin/eCommerce') ? ' active' : '' }}" href="{{ route('admin.eCommerce.index') }}">
            <i class="app-menu__icon fa fa-etsy"></i>
            <span class="app-menu__label">
                {{_lang('Ecommerce Dashboard')}}
            </span>
        </a>
    </li>

    {{--About us --}}
    @can('ecommerce_about_us.view')
        <li data-placement="bottom" title="Go to eCommerce About Us Page Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/about-us/index*') ? 'active':''}}" href="{{ route('admin.eCommerce.about-us.index') }}">
                <i class="app-menu__icon fa fa-telegram"></i>
                <span class="app-menu__label">
                    {{_lang('About Us')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Page Banner --}}
    @can('ecommerce_page_banner.view')
        <li data-placement="bottom" title="Ecommerce Page Banner Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/page-banner*') ? 'active':''}}" href="{{ route('admin.eCommerce.page-banner.index') }}">
                <i class="app-menu__icon fa fa-picture-o"></i> 
                <span class="app-menu__label">
                    {{_lang('Banner')}}
                </span>
            </a>
        </li>
    @endcan

    <li class="treeview {{ (Request::is('admin/eCommerce/blog*')) ? ' is-expanded' : '' }}">
        <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-rss-square"
                aria-hidden="true"></i>
            <span class="app-menu__label">{{_lang('Blog')}}</span><i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
    
            <li data-placement="bottom" title="Ecommerce Offer Section">
                <a class="treeview-item {{Request::is('admin/eCommerce/blog-category') ? 'active':''}}"
                    href="{{ route('admin.eCommerce.blog-category.index') }}">
                    <i class="icon fa fa-circle-o"></i>
                    {{_lang('Blog Category')}}
                </a>
            </li>
    
            <li data-placement="bottom" title="Ecommerce Offer Section">
                <a class="treeview-item {{Request::is('admin/eCommerce/blog-post') ? 'active':''}}"
                    href="{{ route('admin.eCommerce.blog-post.index') }}">
                    <i class="icon fa fa-circle-o"></i>
                    {{_lang('Blog Post')}}
                </a>
            </li>

            <li data-placement="bottom" title="Ecommerce Offer Section">
                <a class="treeview-item {{Request::is('admin/eCommerce/blog-post/comment') ? 'active':''}}"
                    href="{{ route('admin.eCommerce.blog-post.comment') }}">
                    <i class="icon fa fa-circle-o"></i>
                    {{_lang('Blog Comment')}}
                </a>
            </li>
        </ul>
    </li>
    
    {{--Contact Message --}}
    @can('ecommercce_contact_message.view')
        <li data-placement="bottom" title="Ecommerce Contact Message Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/contact-msg*') ? 'active':''}}" href="{{ route('admin.eCommerce.contact-msg.index') }}">
                <i class="app-menu__icon fa fa-envelope-open-o"></i>
                <span class="app-menu__label">
                    {{_lang('Contact Message')}}
                </span>
            </a>
        </li>
    @endcan
    
    {{-- Coupon --}}
    @can('ecommerce_coupon.view')
        <li data-placement="bottom" title="Ecommerce Coupon Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/coupons*') ? 'active':''}}" href="{{ route('admin.eCommerce.coupons.index') }}">
                <i class="app-menu__icon fa fa-ravelry"></i>
                <span class="app-menu__label">
                    {{_lang('Coupons')}}
                </span>
            </a>
        </li>
    @endcan
    
    {{-- Customer --}}
    @can('ecommerce_customer.view')
        <li data-placement="bottom" title="Ecommerce Customer Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/customer*') ? 'active':''}}" href="{{ route('admin.eCommerce.e_customer') }}">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">
                    {{_lang('Customer')}}
                </span>
            </a>
        </li>
    @endcan
    
    {{-- Featured Product  --}}
    @can('ecommerce_featured_product.view')
        <li data-placement="bottom" title="Ecommerce Featured Product Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/feature-product*') ? 'active':''}}" href="{{ route('admin.eCommerce.feature-product.index') }}">
                <i class="app-menu__icon fa fa-meetup"></i>
                <span class="app-menu__label">
                    {{_lang('Feature Product')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Hot sale Product  --}}
    @can('ecommerce_hot_sale_product.view')
        <li data-placement="bottom" title="Ecommerce Hot Sale Product Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/hotsale-product*') ? 'active':''}}" href="{{ route('admin.eCommerce.hotsale-product.index') }}">
                <i class="app-menu__icon fa fa-free-code-camp"></i>
                <span class="app-menu__label">
                    {{_lang('Hot Sale Product')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Offer --}}
    @can('ecommerce_offer.view')
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/eCommerce-Offer*') ? 'active':''}}" href="{{ route('admin.eCommerce.eCommerce-offer.index') }}">
                <i class="app-menu__icon fa fa-superpowers"></i>
                <span class="app-menu__label">
                    {{_lang('Offer')}}
                </span>
            </a>
        </li>
    @endcan

    {{--Ecommerce Orders --}}
    @can('ecommerce_order.view')
        <li data-placement="bottom" title="Ecommerce Orders Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/orders*') ? 'active':''}}" href="{{ route('admin.eCommerce.order.index') }}">
                <i class="app-menu__icon fa fa-handshake-o"></i>
                <span class="app-menu__label">
                    {{_lang('Orders')}}
                </span>
            </a>
        </li>
    @endcan

    {{--Our Team--}}
    @can('ecommerce_our_team.view')
        <li data-placement="bottom" title="Ecommerce Our Team Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/our-team*') ? 'active':''}}" href="{{ route('admin.eCommerce.our-team.index') }}">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">
                    {{_lang('Our Team')}}
                </span>
            </a>
        </li>
    @endcan
        
    {{--Our workspace--}}
    @can('ecommerce_our_workspace.view')
        <li data-placement="bottom" title="Ecommerce Our workspace Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/our-workspace*') ? 'active':''}}" href="{{ route('admin.eCommerce.our-workspace.index') }}">
                <i class="app-menu__icon fa fa-space-shuttle"></i>
                <span class="app-menu__label">
                    {{_lang('Our Workspace')}}
                </span>
            </a>
        </li>
    @endcan

    {{--Product Rating --}}
    @can('ecommerce_product_rating.view')
        <li data-placement="bottom" title="Ecommerce Product Rating Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/product-rating*') ? 'active':''}}" href="{{ route('admin.eCommerce.product-rating.index') }}">
                <i class="app-menu__icon fa fa-star"></i>
                <span class="app-menu__label">
                    {{_lang('Product Rating')}}
                </span>
            </a>
        </li>
    @endcan

    {{--Privacy Policy--}}
    @can('ecommerce_privecy_policy.view')
        <li data-placement="bottom" title="Ecommerce Privacy Policy Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/privacy-policy/index*') ? 'active':''}}" href="{{ route('admin.eCommerce.privacy-policy.index') }}">
                <i class="app-menu__icon fa fa-shield"></i>
                <span class="app-menu__label">
                    {{_lang('Privacy Policy')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Qurier --}}
    @can('ecommerce_qurier.view')
        <li data-placement="bottom" title="Ecommerce Privacy Policy Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/qurier/*') ? 'active':''}}" href="{{ route('admin.eCommerce.qurier.index') }}">
                <i class="app-menu__icon fa fa-shield"></i>
                <span class="app-menu__label">
                    {{_lang('Qurier')}}
                </span>
            </a>
        </li>
    @endcan

    {{--Seo --}}
    @can('ecommerce_seo.view')
        <li data-placement="bottom" title="Ecommerce Seo Section">
            <a class="app-menu__item {{Request::is('admin/c/seo/index*') ? 'active':''}}" href="{{ route('admin.eCommerce.seo.index') }}">
                <i class="app-menu__icon fa fa-globe"></i>
                <span class="app-menu__label">
                    {{_lang('SEO')}}
                </span>
            </a>
        </li>
    @endcan 
    
    {{-- Shipping Charge --}}
    @can('ecommerce_shiping_charge.view')
        <li data-placement="bottom" title="Ecommerce Shipping Charge Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/shipping-charge*') ? 'active':''}}" href="{{ route('admin.eCommerce.shipping-charge.index') }}">
                <i class="app-menu__icon fa fa-truck"></i>
                <span class="app-menu__label">
                    {{_lang('Shipping Charge')}}
                </span>
            </a>
        </li>
    @endcan
    
    {{-- Special Category  --}}
    @can('ecommerce_special_category.view')
        <li data-placement="bottom" title="Ecommerce Special Category Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/special-category*') ? 'active':''}}" href="{{ route('admin.eCommerce.special-category.index') }}">
                <i class="app-menu__icon fa fa-envira"></i>
                <span class="app-menu__label">
                    {{_lang('Special Category')}}
                </span>
            </a>
        </li>
    @endcan
                
    {{-- Special Offer  --}}
    @can('ecommerce_special_offer.view')
        <li data-placement="bottom" title="Ecommerce Special Offer Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/special-offer*') ? 'active':''}}" href="{{ route('admin.eCommerce.special-offer.index') }}">
                <i class="app-menu__icon fa fa-deviantart"></i>
                <span class="app-menu__label">
                    {{_lang('Special Offer')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Stock transfer --}}
    @can('ecommerce_stock.view')
        <li data-placement="bottom" title="Ecommerce Stock transfer Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/production-to-ecommerce*') ? 'active':''}}" href="{{ route('admin.eCommerce.production-to-ecommerce.index') }}">
                <i  class="app-menu__icon fa fa-gg-circle"></i>
                <span class="app-menu__label">
                    {{_lang('Stock')}}
                </span>
            </a>
        </li>
    @endcan 

    {{-- Subscribers --}}
    @can('ecommerce_subscribers.view')
        <li data-placement="bottom" title="Ecommerce Subscribers Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/subscribers*') ? 'active':''}}" href="{{ route('admin.eCommerce.subscribers.index') }}">
                <i  class="app-menu__icon fa fa-envelope"></i>
                <span class="app-menu__label">
                    {{_lang('Subscribers')}}
                </span>
            </a>
        </li>
    @endcan 
    
    {{--Term and Condition --}}
    @can('ecommerce_terms_and_condition.view')
        <li data-placement="bottom" title="Ecommerce Term and Condition Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/terams-conditions/index*') ? 'active':''}}" href="{{ route('admin.eCommerce.terams-conditions.index') }}">
                <i class="app-menu__icon fa fa-terminal"></i>
                <span class="app-menu__label">
                    {{_lang('Terms & Conditions')}}
                </span>
            </a>
        </li>
    @endcan

    {{-- Whole Sale  --}}
    @can('ecommerce_whole_sale.view') 
        <li data-placement="bottom" title="Ecommerce Whole Sale Section">
            <a class="app-menu__item {{Request::is('admin/eCommerce/whole-sale*') ? 'active':''}}" href="{{ route('admin.eCommerce.whole-sale') }}">
                <i class="app-menu__icon fa fa-address-book"></i>
                <span class="app-menu__label">
                    {{_lang('Whole Sale Page')}}
                </span>
            </a>
        </li>
    @endcan 
@endif
@endcan

@if (!Request::is('admin/eCommerce*'))
@if (!Request::is('admin/report*'))
    
    @can('ecommerce.view')
        {{-- Ecommerce Dashboard --}}
        <li data-placement="bottom" title="Go to eCommerce Dashboard">
            <a class="app-menu__item {{ Request::is('admin/eCommerce') ? ' active' : '' }}" href="{{ route('admin.eCommerce.index') }}">
                <i class="app-menu__icon fa fa-etsy"></i>
                <span class="app-menu__label">
                    {{_lang('Ecommerce Dashboard')}}
                </span>
            </a>
        </li>
    @endcan
    
    @can('report.view')
        <li data-placement="bottom" title="Go to Report Dashboard">
            <a class="app-menu__item {{ Request::is('admin/report') ? ' active' : '' }}" href="{{ route('admin.report.index') }}">
                <i class="app-menu__icon fa fa-registered"></i>
                <span class="app-menu__label">
                    {{_lang('Report')}}
                </span>
            </a>
        </li>
    @endcan

@can('client.view')
{{-- Database Backup --}}
<li><a class="app-menu__item {{ Request::is('admin/client*') ? ' active' : '' }}"
        href="{{ route('admin.client.index') }}"><i class="app-menu__icon fa fa-user-o"></i><span
            class="app-menu__label">{{_lang('Client')}}</span></a></li>
@endcan

@can('client.view')
{{-- Database Backup --}}
<li><a class="app-menu__item {{ Request::is('admin/supplier*') ? ' active' : '' }}"
        href="{{ route('admin.get_supplier_index') }}"><i class="app-menu__icon fa fa-user-o"></i><span
            class="app-menu__label">{{_lang('Supplier')}}</span></a></li>
@endcan

@can('sale_pos.view')
<li class="treeview {{ Request::is('admin/sale*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-minus-circle"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Sale Pos')}}</span><i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    {{--<ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/sale/pos/create') ? 'active':''}}"
    href="{{ route('admin.sale.pos.create') }}">
    <i class="icon fa fa-circle-o"></i>
    {{_lang('Pos')}}
    </a>
</li>

<li data-placement="bottom" title="Ecommerce Offer Section">
    <a class="treeview-item {{Request::is('admin/sale/add') ? 'active':''}}" href="{{ route('admin.sale.add') }}">
        <i class="icon fa fa-circle-o"></i>
        {{_lang('Add Sale')}}
    </a>
</li>
<li data-placement="bottom" title="Ecommerce Offer Section">
    <a class="treeview-item {{Request::is('admin/admin/sale/pos') ? 'active':''}}"
        href="{{ route('admin.sale.pos.index') }}">
        <i class="icon fa fa-circle-o"></i>
        {{_lang('All Sale')}}
    </a>
</li>
--}}

<ul class="treeview-menu">

    <li data-placement="bottom" title="Ecommerce Offer Section">
        <a class="treeview-item {{Request::is('admin/sale/pos/create') ? 'active':''}}"
            href="{{ route('admin.sale.pos.create') }}">
            <i class="icon fa fa-circle-o"></i>
            {{_lang('Pos')}}
        </a>
    </li>

    <li data-placement="bottom" title="Ecommerce Offer Section">
        <a class="treeview-item {{Request::is('admin/sale/add') ? 'active':''}}" href="{{ route('admin.sale.add') }}">
            <i class="icon fa fa-circle-o"></i>
            {{_lang('Add Sale')}}
        </a>
    </li>
    <li data-placement="bottom" title="Ecommerce Offer Section">
        <a class="treeview-item {{Request::is('admin/sale/pos') ? 'active':''}}"
            href="{{ route('admin.sale.pos.index') }}">
            <i class="icon fa fa-circle-o"></i>
            {{_lang('All Sale')}}
        </a>
    </li>

    <li data-placement="bottom" title="Ecommerce Offer Section">
        <a class="treeview-item {{Request::is('admin/sale/return/create') ? 'active':''}}"
            href="{{ route('admin.sale.return.create') }}">
            <i class="icon fa fa-circle-o"></i>
            {{_lang('Return Sale')}}
        </a>
    </li>

    <li data-placement="bottom" title="Ecommerce Offer Section">
        <a class="treeview-item {{Request::is('admin/sale/return') ? 'active':''}}"
            href="{{ route('admin.sale.return.index') }}">
            <i class="icon fa fa-circle-o"></i>
            {{_lang('Sale Return List')}}
        </a>
    </li>
</ul>
</li>
@endcan

@can('email_marketing.view')

<li class="treeview {{ Request::is('admin/emailmarketing*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">{{_lang('Email Marketing')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/emailmarketing/template*') ? 'active':''}}"
                href="{{ route('admin.emailmarketing.template.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Email Template')}}</a></li>

        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/emailmarketing/media*') ?'active':''}}"
                href="{{ route('admin.emailmarketing.media.index') }}"><i
                    class="icon fa fa-circle-o"></i>{{_lang('Media')}}</a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/emailmarketing/sendmail/create') ?'active':''}}"
                href="{{ route('admin.emailmarketing.sendmail.create') }}"><i
                    class="icon fa fa-circle-o"></i>{{_lang('Send Mail')}}</a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/emailmarketing/email-history') ?'active':''}}"
                href="{{ route('admin.emailmarketing.email_history') }}"><i
                    class="icon fa fa-circle-o"></i>{{_lang('Email History')}}</a>
        </li>
    </ul>
</li>
@endcan
@can('sms_marketing.view')

<li class="treeview {{ Request::is('admin/smsmerketing*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-commenting"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('SMS Marketing')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/smsmerketing/sendsms*') ? 'active':''}}"
                href="{{ route('admin.smsmerketing.sendsms.create') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Send Sms')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/smsmerketing/sms-history') ? 'active':''}}"
                href="{{ route('admin.smsmerketing.sms_history') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sms History')}}
            </a>
        </li>

    </ul>
</li>
@endcan
@can('employee.view')
{{-- Employee --}}
<li data-placement="bottom" title="Employee all System"
    class="treeview {{ (Request::is('admin/employee*') or Request::is('admin/emp-leave*') or Request::is('admin/attendance*') or Request::is('admin/payroll*') or Request::is('admin/holiday*')) ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user-circle"></i><span
            class="app-menu__label">{{_lang('HRM')}}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">


        @can('employee_list.view')
        {{-- Employee list --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-list*') ? 'active':''}}"
                href="{{ route('admin.employee-list.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee')}}</a></li>
        @endcan




        @can('employee_attendance.view')
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/attendance-employee-attendance*') ? 'active':''}}"
                href="{{ route('admin.attendance-employee-attendance.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Attendance')}}</a></li>
        @endcan

        @can('employee_leave.view')
        {{-- Employee Leave Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-leave') ? 'active':''}}"
                href="{{ route('admin.employee-leave.view') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Leave')}}</a></li>
        @endcan
        {{-- Employee Payroll --}}
        @can('employee_payroll.view')
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{ Request::is('admin/payroll*') ? ' active' : '' }}"
                href="{{ route('admin.payroll.view') }}"><i class="icon fa fa-circle-o"></i>{{_lang('Payroll')}}</a>
        </li>
        @endcan



        @can('employee_id_card.view')
        {{-- Employee Id Card --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-id-card*') ? 'active':''}}"
                href="{{ route('admin.employee-id-card.id_card') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Id Card')}}</a></li>
        @endcan


        {{-- Employee Shift --}}
        @can('employee_shift.view')
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-shift*') ? 'active':''}}"
                href="{{ route('admin.employee-shift.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Shift')}}</a></li>
        @endcan

        {{-- holiday --}}
        @can('holiday.view')
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{ Request::is('admin/holiday*') ? ' active' : '' }}"
                href="{{ route('admin.holiday.index') }}"><i class="icon fa fa-circle-o"></i> {{_lang('Holiday')}}</a>
        </li>
        @endcan


        @can('employee_category.view')
        {{-- Employee Document Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-category*') ? 'active':''}}"
                href="{{ route('admin.employee-category.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Category')}}</a></li>
        @endcan

        @can('employee-designation.view')
        {{-- Designation Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee/designation*') ? 'active':''}}"
                href="{{ route('admin.designation.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Designation')}}</a></li>
        @endcan

        @can('employee_departmeent.view')
        {{-- Employee Department --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee/department*') ? 'active':''}}"
                href="{{ route('admin.employee.department.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Department')}}</a></li>
        @endcan

        @can('employee_document_type.view')
        {{-- Employee Document Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-document-type*') ? 'active':''}}"
                href="{{ route('admin.employee-document-type.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Document Type')}}</a></li>
        @endcan



        @can('employee_leave_type.view')

        {{-- Employee Leave Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/emp-leave*') ? 'active':''}}"
                href="{{ route('admin.employee-leave-type.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Leave Type')}}</a></li>
        @endcan


        @can('employee_attendance_type.view')
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/attendance-attendance-type*') ? 'active':''}}"
                href="{{ route('admin.attendance-attendance-type.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Attendance Type')}}</a></li>
        @endcan

        @can('employee_payhead.view')
        {{-- Employee Payhead Type --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/employee-pay-head*') ? 'active':''}}"
                href="{{ route('admin.employee-pay-head.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Payhead')}}</a></li>
        @endcan


    </ul>
</li>
@endcan

@can('production.view')
{{-- User Section--}}
<li class="treeview {{ Request::is('admin/production*') ? ' is-expanded' : '' }}"><a class="app-menu__item" href="#"
        data-toggle="treeview"><i class="app-menu__icon fa fa-stumbleupon"></i><span
            class="app-menu__label">{{_lang('Production')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
        @can('production_category.view')
        {{-- Category --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-category*') ? 'active':''}}"
                href="{{ route('admin.production-category.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Category')}}</a></li>
        @endcan
        @can('production_brands.view')
        {{-- Brands --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-brands*') ? 'active':''}}"
                href="{{ route('admin.production-brands.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Brand')}}</a></li>
        @endcan
        @can('production_variation.view')
        {{-- Variation Template --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-variation*') ? 'active':''}}"
                href="{{ route('admin.production-variation.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Variation')}}</a></li>
        @endcan
        @can('production_ingredients.view')
        {{-- Ingredients Categor --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a
                class="treeview-item {{Request::is('admin/production-ingredients-category*') ? 'active':''}}"
                href="{{ route('admin.production-ingredients-category.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Ingredients Category')}}</a></li>
        @endcan
        @can('unit.view')
        {{-- Production Unit --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-unit*') ? 'active':''}}"
                href="{{ route('admin.production-unit.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Unit')}}</a></li>
        @endcan

        @can('raw_material.view')
        {{-- Production Raw Materials --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-raw-materials*') ? 'active':''}}"
                href="{{ route('admin.production-raw-materials.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Raw Materials')}}</a></li>
        @endcan

        @can('production_product.view')
        {{-- Production Product --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-product*') ? 'active':''}}"
                href="{{ route('admin.production-product.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Production Product')}}</a></li>
        @endcan
        @can('workorder.view')
        {{-- Production Work Order --}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/production-work-order*') ? 'active':''}}"
                href="{{ route('admin.production-work-order.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Work Order')}}
            </a>
        </li>

        @endcan
        @can('production_wop_materials.view')
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/production-work-order-list') ? 'active':''}}"
                href="{{ route('admin.production-work-order.list') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Work Order Tran.')}}
            </a>
        </li>
        @endcan
        @can('production_wop_materials.view')

        {{-- Production wop Materials --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-wop-materials*') ? 'active':''}}"
                href="{{ route('admin.production-wop-materials.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('WOP Materials')}}</a></li>
        @endcan

        @can('purchase.view')
        {{-- Production Purchase --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/production-purchase*') ? 'active':''}}"
                href="{{ route('admin.production-purchase.index') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Purchase List')}}</a></li>
        @endcan
    </ul>
</li>
@endcan


{{-- Product --}}
@can('production_product.view')
<li data-placement="bottom" title="Product"><a
        class="app-menu__item {{ Request::is('admin/final/product-list*') ? ' active' : '' }}"
        href="{{ route('admin.product_list') }}"><i class="app-menu__icon fa fa-calendar" aria-hidden="true"></i><span
            class="app-menu__label">{{_lang('Product List')}}</span></a></li>
@endcan

@can('production_product.view')
<li data-placement="bottom" title="Stock"><a
        class="app-menu__item {{ Request::is('admin/product_stock*') ? ' active' : '' }}"
        href="{{ route('admin.product_stock.index') }}"><i class="app-menu__icon fa fa-stack-exchange" aria-hidden="true"></i><span
            class="app-menu__label">{{_lang('Product Stock')}}</span></a></li>
@endcan




@can('production_department.view')
{{-- Expense Section--}}
<li class="treeview {{ Request::is('admin/department*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pie-chart"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Department')}}</span><i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">
        @can('production_department.view')
        {{-- Expense Category--}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/department') ? 'active':''}}"
                href="{{ route('admin.department.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Department')}}
            </a>
        </li>
        @endcan

        @can('submit_product_to_department.view')
        {{-- Expense --}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/department/report/create') ? 'active':''}}"
                href="{{ route('admin.report.create') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Product Report')}}
            </a>
        </li>
        @endcan
        @can('submit_material_to_department.view')
        {{-- Expense --}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/department/report/material*') ? 'active':''}}"
                href="{{ route('admin.department.material.report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Material Report')}}
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan

{{-- Job Work --}}
@can('paircosting.view')
<li data-placement="bottom" title="Job Costing"><a
        class="app-menu__item {{ Request::is('admin/paircosting*') ? ' active' : '' }}"
        href="{{ route('admin.paircosting.index') }}"><i class="app-menu__icon fa fa-ils" aria-hidden="true"></i><span
            class="app-menu__label">{{_lang('Job Costing')}}</span></a></li>
@endcan

{{-- Job Work --}}
@can('job_work.view')
<li data-placement="bottom" title="Job Work"><a
        class="app-menu__item {{ Request::is('admin/job-work*') ? ' active' : '' }}"
        href="{{ route('admin.job_work.index') }}"><i class="app-menu__icon fa fa-joomla" aria-hidden="true"></i><span
            class="app-menu__label">{{_lang('Job Work')}}</span></a></li>
@endcan

@can('store_request.view')
<li class="treeview {{ Request::is('admin/request*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-archive"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Store Management')}}</span><i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">
        @can('store_request.view')

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/request') ? 'active':''}}"
                href="{{ route('admin.request.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('All Request')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/request/create') ? 'active':''}}"
                href="{{ route('admin.request.create') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Send Store Request')}}
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan

@can('Ecommerce.view')

@endcan

@can('accounting.view')
{{-- Account Section--}}
<li class="treeview {{ (Request::is('admin/accounting*') or Request::is('admin/expense*')) ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-minus-circle"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Accounting')}}</span><i class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/accounting/investment') ? 'active':''}}"
                href="{{ route('admin.accounting.investment.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('InvestmentAccount')}}
            </a>
        </li>

        {{-- Expense --}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/expense/ex') ? 'active':''}}"
                href="{{ route('admin.expense.ex.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Expense')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/accounting/account*') ? 'active':''}}"
                href="{{ route('admin.accounting.account.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Account List')}}
            </a>
        </li>


        {{-- payment accunt --}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/accounting/payment/account') ? 'active':''}}"
                href="{{ route('admin.accounting.payment_account') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Payment Account')}}
            </a>
        </li>


        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/accounting/cashflow') ? 'active':''}}"
                href="{{ route('admin.accounting.cashflow') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Cashflow')}}
            </a>
        </li>



        {{-- Expense Category--}}
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/expense/category') ? 'active':''}}"
                href="{{ route('admin.expense.category.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Expense Category')}}
            </a>
        </li>


    </ul>
</li>
@endcan

@role('Super Admin')
<li class="treeview {{ Request::is('super-admin*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user-circle"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Super Admin')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/product') ? 'active':''}}"
                href="{{ route('super_admin.product') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Product')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/client') ? 'active':''}}"
                href="{{ route('super_admin.client') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Client')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/sells') ? 'active':''}}"
                href="{{ route('super_admin.sells') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sells')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/sell-return') ? 'active':''}}"
                href="{{ route('super_admin.sell_return') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sell Return')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/purchase') ? 'active':''}}"
                href="{{ route('super_admin.purchase') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Purchase')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/expense') ? 'active':''}}"
                href="{{ route('super_admin.expense') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Expense')}}
            </a>
        </li>


        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('super-admin/account') ? 'active':''}}"
                href="{{ route('super_admin.account') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Account')}}
            </a>
        </li>

    </ul>
</li>
@endrole

@can('user.view')
{{-- User Section--}}
<li class="treeview {{ Request::is('admin/user*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview">
        <i class="app-menu__icon fa fa-address-book"></i><span
            class="app-menu__label">{{_lang('Role & Permission')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
        @can('role.view')
        {{-- Role & Permission --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/user/role*') ? 'active':''}}"
                href="{{ route('admin.user.role') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('role_permission')}}</a></li>
        @endcan

        @can('user.view')
        {{-- User --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a
                class="treeview-item {{(Request::is('admin/user*') And !Request::is('admin/user/role*'))  ?'active':''}}"
                href="{{ route('admin.user.index') }}"><i class="icon fa fa-circle-o"></i>{{_lang('user')}}
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan

@can('setting.view')
{{-- Settings --}}
<li class="treeview {{ Request::is('admin/setting*') ? ' is-expanded' : '' }}"><a class="app-menu__item" href="#"
        data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i><span
            class="app-menu__label">{{_lang('Settings')}}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
        @can('setting.view')
        {{-- General Settings --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/general-setting*') ? 'active':''}}"
                href="{{ route('admin.setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('General Settings')}}</a></li>
        @endcan

        @can('system_configuration.view')
        {{-- System Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/system-setting*') ? 'active':''}}"
                href="{{ route('admin.system.setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('System Configuration ')}}</a></li>
        @endcan

        @can('mail_configuration.view')
        {{-- Mail Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/mail-setting*') ? 'active':''}}"
                href="{{ route('admin.mail.setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Mail Configuration ')}}</a></li>
        @endcan

        @can('sms_configuration.view')
        {{-- SMS Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/sms-setting*') ? 'active':''}}"
                href="{{ route('admin.sms.setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('SMS Configuration ')}}</a></li>
        @endcan

        @can('module_configuration.view')
        {{-- Module Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/module-setting*') ? 'active':''}}"
                href="{{ route('admin.module.setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Module Configuration ')}}</a></li>
        @endcan

        @can('id_card_template.view')
        {{-- Module Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/id-card-template*') ? 'active':''}}"
                href="{{ route('admin.id-card-template') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Id Card Template ')}}</a></li>
        @endcan

        @can('member_setting.view')
        {{-- Member Settings Configuration --}}
        <li data-placement="bottom" title="Ecommerce Offer Section"><a class="treeview-item {{Request::is('admin/setting/member*') ? 'active':''}}"
                href="{{ route('admin.member-setting') }}"><i class="icon fa fa-circle-o"></i>
                {{_lang('Member')}}</a></li>
        @endcan
    </ul>
</li>
@endcan

@can('language.view')
{{-- Language --}}
<li><a class="app-menu__item {{ Request::is('admin/language*') ? ' active' : '' }}"
        href="{{ route('admin.language') }}"><i class="app-menu__icon fa fa-language" aria-hidden="true"></i><span
            class="app-menu__label">{{_lang('language')}}</span></a></li>
@endcan
@can('backup.view')
{{-- Database Backup --}}
<li><a class="app-menu__item {{ Request::is('admin/backup') ? ' active' : '' }}" href="{{ route('admin.backup') }}"><i
            class="app-menu__icon fa fa-database"></i><span class="app-menu__label">{{_lang('backup')}}</span></a></li>
@endcan


@endif

@endif

@if (Request::is('admin/report*'))

<li><a class="app-menu__item {{ Request::is('admin/report') ? ' active' : '' }}"
    href="{{ route('admin.report.index') }}"><i class="app-menu__icon fa fa-registered"></i><span
        class="app-menu__label">{{_lang('Report')}}</span></a>
</li>

@can('report.store_department')
<li class="treeview {{ Request::is('admin/report/depertment*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-sort-amount-desc"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Department Report')}}</span>
        <i class="treeview-indicator fa fa-angle-right"></i>
    </a>

    <ul class="treeview-menu">
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/depertment/product/report') ? 'active':''}}"
                href="{{ route('admin.report.depertment.product_report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Product Report')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/depertment/raw-material/report') ? 'active':''}}"
                href="{{ route('admin.report.depertment.raw_material_report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Material Report')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/depertment/product/report-details') ? 'active':''}}"
                href="{{ route('admin.report.depertment.product_report_details') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Product Report Details')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/depertment/raw-material/report-details') ? 'active':''}}"
                href="{{ route('admin.report.depertment.raw_material_report_details') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Material Report Details')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/depertment/store-material/report') ? 'active':''}}"
                href="{{ route('admin.report.depertment.store_material_report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Store Material Report')}}
            </a>
        </li>
    </ul>
</li>
@endcan

{{-- Employee Report --}}

@can('report.employee')
<li class="treeview {{ Request::is('admin/report/employee*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users" aria-hidden="true"></i> <span class="app-menu__label">{{_lang('Employee Report')}}</span> <i class="treeview-indicator fa fa-angle-right"></i> </a>

    <ul class="treeview-menu">
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/employee-salary-report') ? 'active':''}}"
                href="{{ route('admin.report.employee-salary-report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Salary Report')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/employee-advance-payment-report') ? 'active':''}}"
                href="{{ route('admin.report.employee-advance-payment-report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Advance Payment Report')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/employee-advance-return-report') ? 'active':''}}"
                href="{{ route('admin.report.employee-advance-return-report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Advance Return Details')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/employee-other-payment-report') ? 'active':''}}"
                href="{{ route('admin.report.employee-other-payment-report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Other Payment Report')}}
            </a>
        </li>
        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/employee-report') ? 'active':''}}"
                href="{{ route('admin.report.employee-report') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Employee Report')}}
            </a>
        </li>
    </ul>
</li>
@endcan

{{-- Employee Report End --}}
@can('report.ecommerce')
{{-- Ecommerce Report --}}
<li><a class="app-menu__item {{ Request::is('admin/report/eCommerce-report') ? ' active' : '' }}"
        href="{{ route('admin.report.eCommerce-report.index') }}"><i
            class="app-menu__icon fa fa-shopping-cart"></i><span
            class="app-menu__label">{{_lang('eCommerce Report')}}</span></a>
</li>
@endcan
@can('report.expense')
<li class="treeview {{ Request::is('admin/report/expense*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-certificate"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Expense Report')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/expense') ? 'active':''}}"
                href="{{ route('admin.report.expense.index') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Expense Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/expense/accunt') ? 'active':''}}"
                href="{{ route('admin.report.expense.account') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Expense Account Report')}}
            </a>
        </li>

    </ul>
</li>
@endcan
@can('report.selling')
<li class="treeview {{ Request::is('admin/report/selling*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-dropbox"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Selling Report')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/selling/sales') ? 'active':''}}"
                href="{{ route('admin.report.selling.sales') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sales Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/selling/sales-payment') ? 'active':''}}"
                href="{{ route('admin.report.selling.sales_payment') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sales Payment Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/selling/sales-due') ? 'active':''}}"
                href="{{ route('admin.report.selling.sales_due') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sales Due Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/selling/sale-return') ? 'active':''}}"
                href="{{ route('admin.report.selling.sale_return') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Sales Return Report')}}
            </a>
        </li>

    </ul>
</li>
@endcan
@can('report.purchase')
<li class="treeview {{ Request::is('admin/report/purchasing*') ? ' is-expanded' : '' }}">
    <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-heartbeat"
            aria-hidden="true"></i>
        <span class="app-menu__label">{{_lang('Purchase Report')}}</span><i
            class="treeview-indicator fa fa-angle-right"></i>
    </a>
    <ul class="treeview-menu">

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/purchasing/sales') ? 'active':''}}"
                href="{{ route('admin.report.purchasing.purchase') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Purchase Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/purchasing/purchase-payment') ? 'active':''}}"
                href="{{ route('admin.report.purchasing.purchase_payment') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Purchase Payment Report')}}
            </a>
        </li>

        <li data-placement="bottom" title="Ecommerce Offer Section">
            <a class="treeview-item {{Request::is('admin/report/purchasing/purchase-due') ? 'active':''}}"
                href="{{ route('admin.report.purchasing.purchase_due') }}">
                <i class="icon fa fa-circle-o"></i>
                {{_lang('Purchase Due Report')}}
            </a>
        </li>

    </ul>
</li>
@endcan

@can('report.product')
<li><a class="app-menu__item {{ Request::is('admin/report/product-report') ? ' active' : '' }}"
        href="{{ route('admin.report.product_report') }}"><i class="app-menu__icon fa fa-shopping-cart"></i><span
            class="app-menu__label">{{_lang('Product Report')}}</span></a>
</li>
@endcan
@can('report.purchase_sale')
<li><a class="app-menu__item {{ Request::is('admin/report/purchase-sale') ? ' active' : '' }}"
        href="{{ route('admin.report.purchase_sale') }}"><i class="app-menu__icon fa fa-puzzle-piece"></i><span
            class="app-menu__label">{{_lang('Purchase Sale')}}</span></a>
</li>
@endcan
@can('report.customer')
<li><a class="app-menu__item {{ Request::is('admin/report/customer') ? ' active' : '' }}"
        href="{{ route('admin.report.getCustomerSuppliers') }}"><i class="app-menu__icon fa fa-user-o"></i><span
            class="app-menu__label">{{_lang('Customer Report')}}</span></a>
</li>
@endcan
@can('report.trail_balance')
<li><a class="app-menu__item {{ Request::is('admin/report/trail-balance') ? ' active' : '' }}"
        href="{{ route('admin.report.trail_balance') }}"><i class="app-menu__icon fa fa-user-secret"></i><span
            class="app-menu__label">{{_lang('Trail Balance')}}</span></a>
</li>
@endcan
@can('report.monthly')
<li><a class="app-menu__item {{ Request::is('admin/report/monthly') ? ' active' : '' }}"
        href="{{ route('admin.report.monthly_report') }}"><i class="app-menu__icon fa fa-sun-o"></i><span
            class="app-menu__label">{{_lang('Monthly Report')}}</span></a>
</li>
@endcan
@can('report.yearly')
<li><a class="app-menu__item {{ Request::is('admin/report/yearly') ? ' active' : '' }}"
        href="{{ route('admin.report.yearly_report') }}"><i class="app-menu__icon fa fa-adjust"></i><span
            class="app-menu__label">{{_lang('Yearly Report')}}</span></a>
</li>
@endcan


@endif
