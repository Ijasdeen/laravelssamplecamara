@extends('admin.layouts.app')
 

@section('content')
    
    <div class="layout-px-spacing">

        <div class="row layout-spacing">

            <!-- Content -->
            <div class="col-xl-12 col-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">

                        <div class="d-flex justify-content-between">
                            <h3 class="">Profile</h3>
                        </div>

                        <div class="row"> 
                            <div class="col-xl-12 m-auto">
                            <div class="p-4  ">
                                @if($user_details->name)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Name</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                        
                                    {{($user_details->name)? $user_details->name:''}}
                                    </span>
                                </p>
                                @endif

                                @if($user_details->email)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder m-0">Email</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->email}}
                                    </span>
                                </p>
                                @endif

                                @if($user_details->phoneno)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Phoneno</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->phoneno}}
                                    </span>
                                </p>
                                @endif
                                
                                @if($user_details->occupation)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder"> Occupation </label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->occupation}}
                                    </span>
                                </p>
                                @endif

                                @if($user_details->age)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Age</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->age}}
                                    </span>
                                </p> 
                                @endif


                                

                                @if($user_details->company_name)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Company Name</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->company_name}}
                                    </span>
                                </p> 
                                @endif

                                @if($user_details->membership)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Membership</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->membership}}
                                    </span>
                                </p> 
                                @endif



                                @if($user_details->membership_no)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Membership No</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->membership_no}}
                                    </span>
                                </p> 
                                @endif


                                @if($user_details->validity)
                                <p class="row text-start text-dark custom-font-bolder">
                                    <label class="col-3 text-black custom-font-bolder">Validity</label>
                                    <span class="col-1 p-0">:-</span>
                                    <span class="col-8">
                                    {{$user_details->validity}}
                                    </span>
                                </p> 
                                @endif
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
 
           
            {{-- User To Attend Event --}}
            <div class="col-xl-12 col-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">User Attend Event</h3>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-12 layout-top-spacing">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable" id="event_attended_user_table">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Event Titile</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($event_attended_user))
                                             @foreach ($event_attended_user as $value)
                                                <tr>
                                                    <td> {{ $value['id'] }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('manage-event.show', $value['id']) }}">
                                                            {{ $value['title'] }}
                                                        </a>
                                                    </td> 
                                                </tr>
                                               
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>


                    </div>
                </div>
            </div>

           

        </div>
    </div>
@endsection 


@section('script')
<script>
    $(document).ready(function() {

     var table = $('#event_attended_user_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'asc']
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});
</script>
@endsection
