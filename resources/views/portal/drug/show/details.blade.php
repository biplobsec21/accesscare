@php
  $bColor = '';
  if($drug->status == 'Approved') {
   $bColor = 'success';
  } // endif
  if($drug->status == 'Not Approved') {
   $bColor = 'danger';
  } // endif
  if($drug->status == 'Pending') {
   $bColor = 'warning';
  } // endif
@endphp
<div class="alert-light text-dark pt-3 pr-3 pl-3">
 <div class="row">
  <div class="col-sm col-lg-auto align-items-end mb-3 mb-sm-0">
   <strong>{{$drug->name}}</strong>
   ({{$drug->lab_name}})
   <span class="ml-2 badge badge-{{$bColor}}">
    {{$drug->status}}
   </span>
   <div>
    - <a href="{{route('eac.portal.company.show', $drug->company->id)}}">{{$drug->company->name}}</a>
   </div>
  </div>
  <div class="col-sm-auto ml-auto mb-3">
   <small class="upper d-block">Created On</small>
   <strong>{{$drug->created_at->format(config('eac.date_format'))}}</strong>
  </div>
 </div>
</div>