@extends('layouts.portal')
<style>
    .label_required:after {
        content: "*";
        color: red;
    }
</style>
@section('title')
    Create Pharmacist
@endsection

@section('content')
    <div class="titleBar">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{route('eac.portal.pharmacist.list.all')}}">All Pharmacist</a>
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
    
    <form method="post" action="{{ route('eac.portal.pharmacist.store') }}">
        {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
        <div class="actionBar">
            <a href="{{ route('eac.portal.pharmacist.list.all') }}" class="btn btn-light">
                Pharmacist List
            </a>
        </div><!-- end .actionBar -->
        
        <div class="viewData">
            <div class="row">
                <div class="col-lg-4 col-xl order-lg-2">
                    <div class="instructions mb-3">
                        Instructions
                    </div>
                </div>
                <div class="col-lg-8 col-xl-7 order-lg-1">
                    <div class="card card-body">
                        <h5 class="text-gold mb-2 mb-xl-4">
                            Pharmacist Details </h5>
                        <div class="mb-3">
                            <label class="d-block label_required">Pharmacist Name</label>
                            <input type="text" name="name" placeholder="Pharmacist Name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required="required">
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="d-block label_required">Pharmacy</label>
                            <select name="pharmacy_id" id="ci" class="form-control {{ $errors->has('pharmacy_id') ? ' is-invalid' : '' }}" required="required">
                                <option disabled hidden selected value="">-- Select --</option>
                                @foreach($pharmacy as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ $errors->first('pharmacy_id') }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
                                <label class="d-block">Email</label>
                                <input type="email" name="email" placeholder="Email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" required="required">
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            </div>
                            <div class="col-sm col-md-4 col-lg-12 col-xl mb-3">
                                <label class="d-block label_required">Phone</label>
                                <input type="text" name="phone" placeholder="Phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" required="required">
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="d-block label_required"> Country Name</label>
                            <select name="country_name" class="form-control select2 {{ $errors->has('country_name') ? ' is-invalid' : '' }}" data-actions-box="true" required="required">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ $errors->first('country_name') }}
                            </div>
                        </div>
                        <div class="row">
                            <!-- <input type="hidden" id="current_country" name="current_country" value=""> -->
                            <div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
                                <button class="btn btn-success btn-block" type="submit">
                                    <i class="far fa-check"></i>
                                    Save Pharmacist
                                </button>
                            </div>
                        </div><!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    
    <script type="text/javascript">
        $('#ci').change(function () {
            var country_id = $("#ci option:selected").text();
            ;
            console.log(country_id);
            if (country_id == 'United States') {
                // $("#current_country").val(1);
                $('#pharmacy_state_province').attr('required', 'required');
            } else {
                // $("#current_country").val(0);
                $('#pharmacy_state_province').removeAttr('required');
            }
            // $("#current_country").val("us");
            // var cc = $('#current_country').val();
            // console.log(cc);

        });
    </script>
@endsection
