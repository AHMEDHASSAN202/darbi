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
                    Darbi is the smartest way to find the perfect yacht or plane for your next business trip. Darbi has been designed to save time and money when trying to book private jets or yachts, making it simple and affordable for everyone.
                    Darbi brings together all exotics and yachts for a given location in one place, so that you can spend more time with your loved ones exploring exotic destinations and less time browsing through different websites.All you need to do is enter some basic information on our website: how many people traveling, destination, arrival and departure dates, budget and we do the rest, finding the perfect luxury experience.
                    Darbi has reinvented private aviation by simplifying operations, while providing an unforgettable experience where customer service is our top priority.It all started with a simple idea: making travel easier for everyone.
                    No matter what your travel plans are—whether you're traveling for business or pleasure—Darbi can get you from A to B in style!
                </p>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
