 <!--  BEGIN SIDEBAR  -->
 <div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
            <ul class="list-unstyled menu-categories" id="accordionExample">
               
                <li class="menu">
                    <a href="{{ route('admin.dashboard') }}"
                        data-active="{{ Request::path() == 'admin/dashboard' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li> 
                
                <li class="menu">
                    <a href="{{ route('manage-user.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-user' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-users"></i>
                            <span> Users</span>
                        </div>
                    </a>
                </li>

                <li class="menu">
                    <a href="{{ route('manage-category.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-category' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span> Category</span>
                        </div>
                    </a>
                </li>

                <li class="menu">
                    <a href="{{ route('manage-banner.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-banner' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span> Banner</span>
                        </div>
                    </a>
                </li>
 
                <li class="menu">
                    <a href="{{ route('manage-services.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-services' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Services</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-app-introduction.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-app-introduction' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>App Introduction</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-static-page.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-static-page' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Static page</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-benefits.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-benefits' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Benefits</span>
                        </div>
                    </a>
                </li> 
 
                <li class="menu">
                    <a href="{{ route('manage-newsletter.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-newsletter' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Newsletter</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-event.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-event' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Event</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-contact-email.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-contact-email' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Contact Email</span>
                        </div>
                    </a>
                </li> 
                <li class="menu">
                    <a href="{{ route('manage-faq.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-faq' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Faq</span>
                        </div>
                    </a>
                </li> 
                <li class="menu">
                    <a href="{{ route('manage-official-document.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-official-document' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Official Document</span>
                        </div>
                    </a>
                </li> 
                <li class="menu">
                    <a href="{{ route('manage-chambers-of-commerce.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-chambers-of-commerce' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Chambers Of Commerce</span>
                        </div>
                    </a>
                </li> 
                <li class="menu">
                    <a href="{{ route('manage-business-registration.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-business-registration' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Business Registration</span>
                        </div>
                    </a>
                </li> 
                <li class="menu">
                    <a href="{{ route('manage-member-directory.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-member-directory' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Member Directory</span>
                        </div>
                    </a>
                </li> 

                <li class="menu">
                    <a href="{{ route('manage-career.index') }}"
                        data-active="{{ Request::path() == 'admin/manage-career' ? 'true' : '' }}" class="dropdown-toggle">
                        <div class="">
                            <i class="fa fa-list"></i>
                            <span>Career</span>
                        </div>
                    </a>
                </li> 
            </ul>
         <!-- <div class="shadow-bottom"></div> -->
    </nav>
 </div>
 <!--  END SIDEBAR  -->