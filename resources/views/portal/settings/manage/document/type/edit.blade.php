
 @extends('layouts.portal')

@section('title')
 Edit Document Type
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings.document.type') }}">Document Type Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   @yield('title')
  </h2>
 </div><!-- end .titleBar -->

 <form method="post" action="{{ route($page['updateAction']) }}" enctype='multipart/form-data' >

  {{ csrf_field() }}
  <div class="row">
   <div class="col-lg-8 col-xl-6">
    @php
     if(Session::has('alerts')) {
      $alert = Session::get('alerts');
      $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
      echo $alert_dismiss;
     }
    @endphp
    <div class="actionBar">
     <a href="{{ route($page['cancelAction']) }}" class="btn btn-warning" >
      <i class="far fa-times"></i> Cancel
     </a>
     <button type="submit" class="btn btn-info">
      <i class="far fa-check"></i> Apply
     </button>
    </div><!-- end .actionBar -->
   </div>
  </div><!-- /.row -->

  <div class="viewData">
   <div class="row">
    <div class="col-lg-8 col-xl-6">
     <div class="mb-3 mb-xl-4">
      <div class="card card-body mb-0">
       <div class="row">
        <div class="col mb-3">
         <label class="d-block">Document Type Name</label>
         <input name="name" type="text" value="{{$docTypes->name}}"
          class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
         <div class="invalid-feedback">
          {{ $errors->first('name') }}
         </div>
        </div>
        <div class="col-auto mb-3">
         <label class="d-block">Status</label>
         {{-- @if($docTypes->active == 1)
         <input data-size="small" data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" checked />
         @else
         <input data-size="small" data-field="active" type="checkbox" data-toggle="toggle" data-off="Active" data-on="Inactive" data-onstyle="primary" data-offstyle="success" data-width="100" name="active" checked />
         @endif --}}
         <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" name="active" {{ $docTypes->active == '1' ? 'checked'  : '' }} />
         <input type="hidden" name="doc_id" value="{{$docTypes->id}}">

        </div>
       </div>
       <div class="mb-3">
        <label class="d-block">Description</label>
        <textarea name="desc" class="form-control" rows="3">{{$docTypes->desc}}</textarea>
       </div>
       <div class="row">
        <div class="col-sm mb-3">

         <label class="d-block">Template <small class="text-muted">(PDF or Doc)</small></label>
         <div class="input-group">
           <?php if($docTypes->template != '') { 
         $doc = \App\File::where('id',$docTypes->template)->first(); ?>
            <input disabled class="form-control" placeholder="{{$doc->name}}">
                <div class="form-control-append">
                  <a href="{{ route('eac.portal.file.download', $doc->id) }}"
                     class="btn btn-primary">
                    <i class="far fa-download"></i> Download File
                  </a>
                  <a class="btn btn-danger" onclick="removeTemplateDocument3('{{$docTypes->id}}',event)">
                    <i class="far fa-trash"></i> Delete File
                  </a>
                </div>
            <?php } else{ ?>
                
                    <input class="form-control" type="file" name="template_file" />
                
              
            <?php } ?>
         </div>
         <div class="invalid-feedback">
          {{ $errors->first('template_file') }}
         </div>
       
        
        </div>

        
       </div><!-- /.row -->
      </div>
      <div class="card-footer d-flex justify-content-center">
       <button class="btn btn-success" type="submit" >
        <i class="far fa-check"></i> Submit
       </button>
      </div>
     </div>
    </div>
   </div><!-- /.row -->
  </div><!-- /.viewData -->
 </form>


@endsection
@section('scripts')
<!-- <script>
 
$(document).ready(function () { 
 function checkValidation(){
  alert();
  return false;
  if($("#template_id").val()){
    var ext = $("#template_id").val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['pdf', 'docs', 'docx', 'doc']) === -1) { 

     $('.error_hide_show' ).show().addClass('text-danger'); 
     $(this).val('');
     alert('Extension not support');
     return false;
    }

    if (this.files[0].size > 2000000) {

     alert('file size should be less 2MB');
     $(this).val('');
     return false;
    }
  }
 }
 

 $(".alert").delay(2000).slideUp(200, function() {
  $(this).alert('close');
 });
});

</script> -->
<script type="text/javascript">
  
    function removeTemplateDocument3($id, $e) {
      console.log($id);
      

      $.ajax({
        url: "{{route('eac.portal.drug.modal.document.deletefile')}}",
        type: 'POST',
        data: {
          id: $id,
          
        },
        success: function () {
          $e.target.parentNode.parentNode.innerHTML = '<input class="form-control" type="file" name="template_file"/>'
        }
      });
    }
</script>
@endsection
