@extends("layouts.public")


@section("styles")
@endsection

@section("content")
 <div class="section">
  <div class="container">
  {{-- Content will be shown as per sequence number of the page --}}
  @if($pagesContent->count() > 0)
   @foreach($pagesContent as $val)
    @section("title")
    {{ $val->title }}
    @endsection
    {!! $val->content !!}
   @endforeach
   @else 
    <div class="alert alert-light">
     <h3>Content not found for <em>{{$menuname}}</em></h3>
     <p>Please create content</p>
    </div>
   @endif
  </div>
 </div>
@endsection

@section("scripts")
@endsection