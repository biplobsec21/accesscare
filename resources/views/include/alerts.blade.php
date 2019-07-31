@if($alert = Session::get('alert'))
    {!! view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]) !!}
@endif
@if(Session::has('alerts'))
    @foreach(Session::get('alerts') as $alert)
        {!! view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]) !!}
    @endforeach
@endif
