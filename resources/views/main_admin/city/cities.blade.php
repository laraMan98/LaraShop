@extends('layouts.main_admin_master')
@section('title')
    LS | Cities
@endsection
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<!-- Modal for adding new data -->
   <div class="modal fade col-md-12" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add City</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('add_city') }}" method="POST">
        {{ csrf_field() }}
        <style>
          .form-control {
            color: #333;
          }
        </style>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label>Region Under</label>
                    <select name="region_number" id="sel_depart" class="form-control" style="appearance: none;">
                        <option value="" disabled selected>Select Region Number</option>
                        @foreach($regions as $row_region)
                              <option value="{{ $row_region->id }}">{{ $row_region->region_name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12 pr-1">
                  <div class="form-group">
                    <label>Province Under</label>
                      <select name="province_name" id="sel_emp" class="form-control" style="appearance: none;">
                          <option value="">Select Province</option>
                      </select>
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <label for="city_name" class="col-form-label">City Name</label>
                  <input type="text" class="form-control" id="city_name" name="city_name">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">SAVE</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<!-- Modal For confirm delete -->
  <div class="modal fade" id="deleteModalPop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form id="deleteModalForm" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
        <div class="modal-body">
          <div class="form-group">
            <h5>Are you sure you want to delete this record?</h5>
            <input type="hidden" name="id" class="form-control" id="delete_city_id" disabled>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm Delete</button>
        </div>
        </form>

      </div>
    </div>
  </div>

<!-- Page Heading -->
   <h1 class="h3 mb-2 text-gray-800">Cities</h1>
   <p class="mb-4">Here you can add, view, edit, and delete</p>

   <!-- DataTales Example -->
   <div class="card shadow mb-4">
       <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cities Table </h6>
            <a href="#" class="btn btn-success btn-icon-split float-right" data-toggle="modal" data-target="#exampleModal" >
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add City</span>
            </a>
       </div>
       <div class="card-body">
           <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                       <tr>
                            <th>ID</th>
                            <th>Province ID</th>
                            <th>Region ID</th>
                            <th>City Name</th>
                            <th>Province Name</th>
                            <th>Region Number</th>
                            <th>Partner Branches</th>
                            <th>Edit</th>
                            <th>Delete</th>
                       </tr>
                   </thead>
                   <tfoot>
                       <tr>
                            <th>ID</th>
                            <th>Province ID</th>
                            <th>Region ID</th>
                            <th>City Name</th>
                            <th>Province Name</th>
                            <th>Region Number</th>
                            <th>Partner Branches</th>
                            <th>Edit</th>
                            <th>Delete</th>
                       </tr>
                   </tfoot>
                   <tbody>
                    @foreach($cities as $row)
                       <tr>
                           <td>{{ $row->id }}</td>
                           <td>{{ $row->province_id }}</td>
                           <td>{{ $row->region_id }}</td>
                           <td>{{ $row->city_name }}</td>
                           <td>{{ $row->province_name }}</td>
                           <td>{{ $row->region_number }}</td>
                           <td>{{ count($branches->where("city_id", "==", $row->id)) }}</td>
                           <td><a href="/city_update/{{ $row->id }}" class="btn btn-success">EDIT</a></td>
                           <td><a href="javascript:void(0)" class="btn btn-danger deletbtn">DELETE</a></td>
                       </tr>
                    @endforeach
                   </tbody>
               </table>
           </div>
       </div>
   </div>
@endsection

{{-- this is what the master.blade.php scripts is calling --}}
@section('scripts')
<script src="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script type='text/javascript'>
 $(document).ready(function(){
    // Department Change
    $('#sel_depart').change(function(){
       // Department id
       var id = $(this).val();

       // Empty the dropdown
       $('#sel_emp').find('option').not(':first').remove();

       // AJAX request 
       $.ajax({
         url: 'getProvinces/'+id,
         type: 'get',
         dataType: 'json',
         success: function(response){

           var len = 0;
           if(response['data'] != null){
              len = response['data'].length;
           }

           if(len > 0){
              // Read data and create <option>
              for(var i=0; i<len; i++){

                 var province_name = response['data'][i].province_name;

                 var option = "<option value='"+province_name+"'>"+province_name+"</option>";

                 $("#sel_emp").append(option); 
              }
           }

         }
       });
    });
 });
</script>
<script>
    $(document).ready(function() {
      $('#dataTable').DataTable();
      $('#dataTable').on('click', '.deletbtn', function() {
          $tr = $(this).closest('tr');

          var data = $tr.children("td").map(function() {
            return $(this).text();
          }).get(); 

          // console.log(data);

          $('#delete_city_id').val(data[0]);
          $('#deleteModalForm').attr('action', '/delete_city/'+data[0]);
          $('#deleteModalPop').modal('show');
        });
    });
</script>
@endsection