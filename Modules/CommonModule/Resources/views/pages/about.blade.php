@extends('commonmodule::layouts.fullLayout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/custom.css?v=4') }}"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

        body, div, h1, h2, h3, h4, h5, p {
            font-family: 'Open Sans', sans-serif !important;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 p-0">
                <img src="{{asset('front/bg/europe-'.app()->getLocale().'.jpg')}}" class="img-fluid w-100" alt="">
            </div>
            <div class="col-md-12">
                <h2 class="mt-2 mb-0" style="font-size: 22px;margin: 22px 0 18px 0;  font-weight: 600;  font-stretch: normal;  font-style: normal;  line-height: normal;  letter-spacing: normal;  text-align: left;  color: #2b2b2b;">About Darbi</h2>
                <p style="  font-size: 15px;  font-weight: normal;  font-stretch: normal;  font-style: normal;  line-height: 1.73;  letter-spacing: normal;  text-align: left;  color: #757575;">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry’s standard dummy text ever since the 1500s, when an unknown
                    printer took a galley of type and scrambled it to make a type specimen book. It has survived not
                    only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                    and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem
                    Ipsum.
                </p>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
