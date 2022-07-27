@extends('catalogmodule::layouts.fullLayout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/custom.css?v=4') }}"/>
@endpush


@section('content')
    <div class="container pr-3 pl-3">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="justify-content-center align-items-center p-3">
                    <img src="{{asset('images/contact.png')}}" class="img-fluid w-100" alt="">
                </div>
                <p style="padding-top:10px;color: #888;text-align: center">Reach out to our support at the below channels</p>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
