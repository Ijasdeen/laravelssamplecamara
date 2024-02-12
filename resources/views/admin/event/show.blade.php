@extends('admin.layouts.app')


@section('content')
    <div class="layout-px-spacing">
        <div class="layout-top-spacing">
            <div class="layout-px-spacing" style="padding:0px !important">

                <div class="row layout-spacing">
                    <!-- Content -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                        <div class="bio layout-spacing">
                            <h3 class="text-Dark">Event details</h3>
                            <input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">

                            <div class="row">
                                <div class="col-md-5 col-12 m-auto">
                                    <div class="contacts-block list-unstyled border rounded p-4 custom-box-shadow "
                                        style=" background:#fff!important; border-color:#fff!important; border-radius: 10px !important;">

                                        <div class="text-right avatar avatar-xl">
                                            <a href="{{ $event->imageurl }}" class="image-link">
                                                <img class="w-100 rounded"
                                                    style="height: 200px; border-radius: 0.75rem !important;  box-shadow: 0 4px 6px 0 rgb(85 85 85 / 9%), 0 1px 20px 0 rgb(0 0 0 / 8%), 0px 1px 11px 0px rgb(0 0 0 / 6%);"
                                                    src="{{ $event->imageurl }}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7 col-12 mt-md-0 mt-5">
                                    <div class="contacts-block list-unstyled border rounded p-4 custom-box-shadow "
                                        style=" background:#fff!important; border-color:#fff!important; border-radius: 10px !important;">

                                        <p class="row text-start text-dark custom-font-bolder">
                                            <label class="col-3 text-black custom-font-bolder">Category</label>
                                            <span class="col-1 p-0">:-</span>
                                            <span class="col-8">
                                                {{ $event->category }}
                                            </span>
                                        </p>

                                        <p class="row text-start text-dark custom-font-bolder">
                                            <label class="col-3 text-black custom-font-bolder m-0">Title</label>
                                            <span class="col-1 p-0">:-</span>
                                            <span class="col-8">
                                                {{ $event->title }}
                                            </span>
                                        </p>

                                        <p class="row text-start text-dark custom-font-bolder">
                                            <label class="col-3 text-black custom-font-bolder">Address</label>
                                            <span class="col-1 p-0">:-</span>
                                            <span class="col-8">
                                                {{ $event->address }}
                                            </span>
                                        </p>



                                        <p class="row text-start text-dark custom-font-bolder">
                                            <label class="col-3 text-black custom-font-bolder"> Date </label>
                                            <span class="col-1 p-0">:-</span>
                                            <span class="col-8">
                                                {{ $event->event_date }}
                                            </span>
                                        </p>

                                        <p class="row text-start text-dark custom-font-bolder">
                                            <label class="col-3 text-black custom-font-bolder">Total attended user</label>
                                            <span class="col-1 p-0">:-</span>
                                            <span class="col-8">
                                            <button type="button" class="badge custom-badge">
                                            {{$attended_user_counter}}</button>
                                            </span>
                                        </p>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-12 layout-top-spacing p-0">
                    <div class="education layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Description</h3>
                            <div>
                                @php echo strip_tags($event->description) @endphp
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12 col-12 layout-top-spacing p-0 overflow-auto" style="max-height: 200px;">
                    <div class="education layout-spacing ">
                        <div class="widget-content widget-content-area">
                            <h3 class="">Attended user</h3>
                            <div>
                            @php
                            if(isset($attended_user))
                            {
                                foreach ($attended_user as $value) {
                                        $user_link = route('manage-user.show', $value->user_id);
                                     echo '<a href="' . $user_link . '" class="username_label"><span class="badge badge-info">' . $value->name . '</span></a>';
                                }
                            }
                            @endphp
                               
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
