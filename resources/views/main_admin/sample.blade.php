@extends('layouts.main_admin_master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sample Cascading dropdown</h3>
                     <!-- Department Dropdown -->
                    Department : <select id='sel_depart' name='sel_depart'>
                        <option value='0'>-- Select department --</option>

                        <!-- Read Departments -->
                        @foreach($departments['data'] as $department)
                        <option value='{{ $department->id }}'>{{ $department->name }}</option>
                        @endforeach

                    </select>

                    <br><br>
                    <!-- Department Employees Dropdown -->
                    Employee : <select id='sel_emp' name='sel_emp'>
                    <option value='0'>-- Select Employee --</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Script -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
           url: 'getEmployees/'+id,
           type: 'get',
           dataType: 'json',
           success: function(response){

             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }

             if(len > 0){
                // Read data and create <option >
                for(var i=0; i<len; i++){

                   var id = response['data'][i].id;
                   var name = response['data'][i].name;

                   var option = "<option value='"+id+"'>"+name+"</option>";

                   $("#sel_emp").append(option); 
                }
             }

           }
         });
      });
   });
   </script>
@endsection
