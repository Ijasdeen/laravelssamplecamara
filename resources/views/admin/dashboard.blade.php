@extends('admin.layouts.app')

<style>
    .component-card_1 .card-title {
        margin-top: 15px;
        margin-bottom: 0px;
    }
</style>

@section('content')
<div class="row"> 

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-user.index') }}">
                <div class="card-body">
                    <h1>{{ $users }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-users"></i> &nbsp;Users
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-category.index') }}">
                <div class="card-body">
                    <h1>{{ $category }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Category
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-banner.index') }}">
                <div class="card-body">
                    <h1>{{ $banner }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Banner
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-services.index') }}">
                <div class="card-body">
                    <h1>{{ $services }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Services
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-app-introduction.index') }}">
                <div class="card-body">
                    <h1>{{ $appintroduction }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;App Introduction
                    </h4>
                </div>
            </a>
        </div>
    </div>

    
    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-static-page.index') }}">
                <div class="card-body">
                    <h1>{{ $staticpage }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Static page
                    </h4>
                </div>
            </a>
        </div>
    </div> 
 
    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-user.index') }}">
                <div class="card-body">
                    <h1>{{ $benefits }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Benefits
                    </h4>
                </div>
            </a>
        </div>
    </div>
 
    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-newsletter.index') }}">
                <div class="card-body">
                    <h1>{{ $newsletter }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Newsletter
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-event.index') }}">
                <div class="card-body">
                    <h1>{{ $event }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Event
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-contact-email.index') }}">
                <div class="card-body">
                    <h1>{{ $contact_email }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Contact Email
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-faq.index') }}">
                <div class="card-body">
                    <h1>{{ $faq }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;FAQ
                    </h4>
                </div>
            </a>
        </div>
    </div>
   
    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-chambers-of-commerce.index') }}">
                <div class="card-body">
                    <h1>{{ $ChambersOfCommerce }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Chambers Of Commerce
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-official-document.index') }}">
                <div class="card-body">
                    <h1>{{ $OfficialDocument }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Official Document
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-business-registration.index') }}">
                <div class="card-body">
                    <h1>{{ $BusinessRegistration }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Business Registration
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-member-directory.index') }}">
                <div class="card-body">
                    <h1>{{ $MemberDirectory }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;MemberDirectory
                    </h4>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mt-3">
        <div class="card component-card_1 text-center h-100">
            <a href="{{ route('manage-career.index') }}">
                <div class="card-body">
                    <h1>{{ $Career }}</h1>
                    <h4 class="card-title">
                        <i class="fa fa-list"></i> &nbsp;Career
                    </h4>
                </div>
            </a>
        </div>
    </div> 
     
</div>

@endsection