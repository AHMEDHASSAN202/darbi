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
    <div class="container pr-3 pl-3">
        <div class="row">
            <div class="col-md-12 pt-4 mb-4">
                <div class="justify-content-center align-items-center text-center p-4">
                    <img src="{{asset('images/contact.png')}}" class="img-fluid w-50" alt="">
                </div>
                <p style="font-size: 14px;  font-weight: normal;  font-stretch: normal;  font-style: normal;  line-height: normal;  letter-spacing: normal;  text-align: center;  color: #757575;">Reach out to our support at the below channels</p>
            </div>
            <div class="col-md-12">
                <a href="tel:{{getOption('darbi_phone', '9668003041666')}}">
                    <div class="card"
                         style="border-radius: 12px;box-shadow: 0 10px 15px 0 rgba(43, 43, 43, 0.05);border: solid 1px #eaeaea;margin-bottom: 15px">
                        <div class="card-body" style="padding: 15px 26px;">
                            <div class="row" style="direction: ltr">
                                <div style="width: 65px">
                                    <img src="{{asset('images/phone.png')}}" style="width: 50px;height: 50px" alt="">
                                </div>
                                <div  style="display: flex;flex-direction: column;justify-content: center;width: calc(100% - 65px)">
                                    <h4 style="margin:0;font-weight: 600;font-stretch: normal;font-style: normal;line-height: normal;letter-spacing: normal;text-align: left;color: #2b2b2b;text-transform: capitalize">
                                        {{__('phone')}}</h4>
                                    <p style="margin:0;font-size: 15px;font-weight: normal;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;text-align:left;color:#757575;">
                                        {{getOption('darbi_phone', '9668003041666')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12">
                <a href="https://wa.me/{{getOption('darbi_whatsapp_phone', '9668003041666')}}">
                    <div class="card"
                         style="border-radius: 12px;box-shadow: 0 10px 15px 0 rgba(43, 43, 43, 0.05);border: solid 1px #eaeaea;margin-bottom: 15px">
                        <div class="card-body" style="padding: 15px 26px;">
                            <div class="row" style="direction: ltr">
                                <div style="width: 65px">
                                    <img src="{{asset('images/whatsapp.png')}}" style="width: 50px;height: 50px" alt="">
                                </div>
                                <div   style="display: flex;flex-direction: column;justify-content: center;width: calc(100% - 65px)">
                                    <h4 style="margin:0;font-weight: 600;font-stretch: normal;font-style: normal;line-height: normal;letter-spacing: normal;text-align: left;color: #2b2b2b;text-transform: capitalize">
                                        {{__('whatsapp')}}</h4>
                                    <p style="margin:0;font-size: 15px;font-weight: normal;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;text-align:left;color:#757575;">
                                        {{getOption('darbi_whatsapp_phone', '9668003041666')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12">
                <?php $darbiTwitter = getTwitterUsernameFromUrl(getOption('darbi_twitter', 'godarbi')) ?>
                <a href="{{ 'https://twitter.com/' . $darbiTwitter }}">
                    <div class="card"
                         style="border-radius: 12px;box-shadow: 0 10px 15px 0 rgba(43, 43, 43, 0.05);border: solid 1px #eaeaea;margin-bottom: 15px">
                        <div class="card-body" style="padding: 15px 26px;">
                            <div class="row" style="direction: ltr">
                                <div style="width: 65px">
                                    <img src="{{asset('images/twitter.png')}}" style="width: 50px;height: 50px" alt="">
                                </div>
                                <div style="display: flex;flex-direction: column;justify-content: center;width: calc(100% - 65px)">
                                    <h4 style="margin:0;font-weight: 600;font-stretch: normal;font-style: normal;line-height: normal;letter-spacing: normal;text-align: left;color: #2b2b2b;text-transform: capitalize">
                                        {{__('twitter')}}</h4>
                                    <p style="margin:0;font-size: 15px;font-weight: normal;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;text-align:left;color:#757575;">
                                        {{'@'.$darbiTwitter}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-12">
                <a href="mailto:{{getOption('darbi_email', 'apps@godarbi.com')}}">
                    <div class="card"
                         style="border-radius: 12px;box-shadow: 0 10px 15px 0 rgba(43, 43, 43, 0.05);border: solid 1px #eaeaea;margin-bottom: 15px">
                        <div class="card-body" style="padding: 15px 26px;">
                            <div class="row" style="direction: ltr">
                                <div  style="width: 65px">
                                    <img src="{{asset('images/email.png')}}" style="width: 50px;height: 50px" alt="">
                                </div>
                                <div  style="display: flex;flex-direction: column;justify-content: center;width: calc(100% - 65px)">
                                    <h4 style="margin:0;font-weight: 600;font-stretch: normal;font-style: normal;line-height: normal;letter-spacing: normal;text-align: left;color: #2b2b2b;text-transform: capitalize">
                                        {{__('email')}}</h4>
                                    <p style="margin:0;font-size: 15px;font-weight: normal;font-stretch:normal;font-style:normal;line-height:normal;letter-spacing:normal;text-align:left;color:#757575;">
                                        {{getOption('darbi_email', 'apps@godarbi.com')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
