@extends('catalogmodule::layouts.fullLayout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/custom.css?v=4') }}"/>
@endpush


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{asset('front/bg/europe-'.app()->getLocale().'.jpg')}}" class="img-fluid w-100" alt="">
            </div>
            <div class="col-md-12">
                <h4>About Darbi</h4>
                <p>
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
