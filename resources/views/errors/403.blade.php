@extends('layouts.portal')

@section('title')
 Dashboard
@endsection

@section('content')
 <div class="alert alert-warning">
  <h4>Access Denied</h4>
  <p>
   If you feel there is an error or if you would like to request access to this area, please <a target="_blank" href="mailto:{{site()->email}}">contact EAC</a>
  </p>
 </div>
@endsection