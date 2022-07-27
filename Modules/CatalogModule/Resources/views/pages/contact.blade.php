@extends('catalogmodule::layouts.fullLayout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/custom.css?v=4') }}"/>
@endpush


@section('content')
    <div class="container pr-3 pl-3">
        <div class="row">
            <div class="col-md-12 pt-4 mb-4">
                <div class="justify-content-center align-items-center text-center p-4">
                    <img src="{{asset('images/contact.png')}}" class="img-fluid w-50" alt="">
                </div>
                <p style="padding-top:10px;color: #888;text-align: center;font-size: 15px">Reach out to our support at
                    the below channels</p>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="direction: ltr">
                            <div class="col-3" style="padding: 5px">
                                <img src="{{asset('images/phone.png')}}" class="img-fluid" alt="">
                            </div>
                            <div class="col-9">
                                <h4 style="font-weight: bold">Phone</h4>
                                <p style="color: #888">1534 5405 333</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
