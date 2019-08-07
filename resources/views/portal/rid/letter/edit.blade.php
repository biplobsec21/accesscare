@extends('layouts.portal')
@section('title')
    {{$title}}
@endsection

@section('content')
    <div class="titleBar">
        <h6 class="title small upper m-0">
            @yield('title')
        </h6>
        <h2 class="m-0">
            {{$rid->number}}
        </h2>
    </div><!-- end .titleBar -->
    @include('include.alerts')
    <form action="{{ route('eac.portal.rid.letter.send') }}" method="post">
        @csrf
        <input type="hidden" name="rid" value="{{ $rid->id }}">
        <input type="hidden" name="status" value="{{ $status->id }}">
        <div class="viewData">
            <div class="row">
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">Subject</label>
                    <input type="text" name="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" value="{{ old('subject') ?? $template->subject }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('subject') }}
                    </div>
                </div>
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">Reply-To Address
                        <small>(Optional)</small>
                    </label>
                    <input type="text" name="reply_to" class="form-control{{ $errors->has('reply_to') ? ' is-invalid' : '' }}" value="{{ old('reply_to') ?? $template->reply_to }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('reply_to') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">From Name</label>
                    <input type="text" name="from_name" class="form-control{{ $errors->has('from_name') ? ' is-invalid' : '' }}" value="{{ old('from_name') ?? $template->from_name }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('from_name') }}
                    </div>
                </div>
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">From Address</label>
                    <input type="text" name="from_email" class="form-control{{ $errors->has('from_email') ? ' is-invalid' : '' }}" value="{{ old('from_email') ?? $template->from_email }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('from_email') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">CC
                        <small>(Optional)</small>
                    </label>
                    <input type="text" name="cc" class="form-control{{ $errors->has('cc') ? ' is-invalid' : '' }}" value="{{ old('cc') ?? $template->cc }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('cc') }}
                    </div>
                </div>
                <div class="col-sm mb-3">
                    <label dusk="label-address" class="d-block">BCC
                        <small>(Optional)</small>
                    </label>
                    <input type="text" name="bcc" class="form-control{{ $errors->has('bcc') ? ' is-invalid' : '' }}" value="{{ old('bcc') ?? $template->bcc }}">
                    <div class="invalid-feedback">
                        {{ $errors->first('bcc') }}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label dusk="label-address" class="d-block">HTML Body</label>
                <textarea class="form-control{{ $errors->has('html') ? ' is-invalid' : '' }} editor" rows="10" id="html" name="html" data-field="text">
                    {{ old('html') ?? $template->html }}
                </textarea>
                <div class="invalid-feedback">
                    {{ $errors->first('html') }}
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success w-100">
                    Send Letter
                    <i class="fas fa-envelope"></i>
                </button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection
