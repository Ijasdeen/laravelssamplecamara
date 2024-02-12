@extends('admin.layouts.app')


@section('content')
<style>
     a.btn.btn-primary.btn-sm {
        margin-right: 8px;
    }
</style>
    <div>
        <div class="row mt-3 mb-3">
            <div class="col-lg-12"> 
                <div class="card" style="border-radius: 6px;">
                    <div class="card-body"> 
                        <div class="table-responsive">
                            <table class="table table-bordered datatable w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Users name</th> 
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($OfficialDocumentUpload as $value)
                                    @php   $user_link = route('manage-user.show', $value->user_id); @endphp
                                        <tr>
                                            <td>{{$value->id}}</td>
                                        
                                            <td><a href="{{$user_link}}" target="_blank">{{$value->name}}</a></td>
                                        
                                            <td>
                                            <a href="{{url($value->document)}}"  target="_blank" class="btn btn-primary  document-link" >
                <i class="fas fa-file-pdf"></i></a>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
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
        $('.datatable').DataTable({});
    }); 
  </script>
@endsection