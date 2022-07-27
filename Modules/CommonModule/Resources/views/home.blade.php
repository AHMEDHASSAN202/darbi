@extends('commonmodule::layouts.master')


@push('styles')
    <link rel="stylesheet" href="{{ asset('front/custom.css?v=4') }}"/>
@endpush


@section('content')
    <div data-bg="{{asset('front/bg/europe-'.app()->getLocale().'.jpg')}}" class="search-panel-wrap mb-0 pb-0" style="min-height: 90vh">
        <div class="container pt-1">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="card card-gradient-white">
                        <div class="card-header">
                            <h4 style="font-size: 20px" class="text-center"><strong>{{__('reservation.title')}}</strong></h4>
                        </div>
                        <div class="card-body">

                            @if(session()->has('success'))
                                <div class="alert alert-success text-left">
                                    {{session()->get('success') ?? ''}}
                                </div>
                            @endif
                            <form action="{{ route('reservation.store') }}" method="post">
                                {{csrf_field()}}

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h4 class="text-primary" style="font-size: 20px">
                                            <strong>{{__('reservation.personal_info')}}</strong>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control customInput" name="name"
                                                   value="{{old('name')}}" autocomplete="off"
                                                   placeholder="{{__('reservation.name')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('name') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control customInput" name="age"
                                                   value="{{old('age')}}" autocomplete="off"
                                                   placeholder="{{__('reservation.age')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('age') ?? ''}}</span>
                                    </div>

                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group mobile">
                                            <input type="text" class="form-control customInput" name="mobile" id="mobile" inputmode="numeric"
                                                   value="{{old('mobile')}}" autocomplete="off"
                                                   placeholder="{{__('reservation.mobile')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                            <input type="hidden" id="mobileCode" name="mobile_code" >
                                            <input type="hidden" id="countryCode" name="country_code" >
                                        </div>
                                        <span class="text-danger">{{$errors->first('mobile') ?? ''}}</span>
                                    </div>

                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control customInput" name="country"
                                                   value="{{old('country')}}" autocomplete="off"
                                                   placeholder="{{__('reservation.country')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('country') ?? ''}}</span>
                                    </div>

                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control customInput" name="email"
                                                   value="{{old('email')}}" autocomplete="off"
                                                   placeholder="{{__('reservation.email')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                {{--                                                <span class="input-group-text bg-transparent border-0 text-danger">*</span>--}}
                                            </div>
                                        </div>
                                        <span class="text-danger">{{$errors->first('email') ?? ''}}</span>
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h4 class="text-primary" style="font-size: 20px">
                                            <strong>{{__('reservation.travel_info')}}</strong>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control customInput"
                                                   name="annual_travels_count" value="{{old('annual_travels_count')}}"
                                                   autocomplete="off"
                                                   placeholder="{{__('reservation.annual_travels_count')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span
                                            class="text-danger">{{$errors->first('annual_travels_count') ?? ''}}</span>
                                    </div>

                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="travel_reasons">
                                            <option hidden value="">{{__('reservation.travel_reasons')}}</option>
                                            <option value="work" {{ (old('travel_reasons') == 'work') ? 'selected' : '' }}>{{ __('reservation.work') }}</option>
                                            <option value="tourism" {{ (old('travel_reasons') == 'tourism') ? 'selected' : '' }}>{{ __('reservation.tourism') }}</option>
                                            <option value="treatment" {{ (old('travel_reasons') == 'treatment') ? 'selected' : '' }}>{{ __('reservation.treatment') }}</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('travel_reasons') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-12 text-left mt-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control customInput"
                                                   name="destination" value="{{old('destination')}}"
                                                   autocomplete="off"
                                                   placeholder="{{__('reservation.destination')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span
                                            class="text-danger">{{$errors->first('destination') ?? ''}}</span>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <h4 class="text-primary" style="font-size: 20px">
                                            <strong>{{__('reservation.transport_info')}}</strong>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="preferred_car_brand">
                                            <option hidden value="">{{__('reservation.preferred_car_model')}}</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand['id'] }}" {{ (old('preferred_car_brand') == $brand['id']) ? 'selected' : '' }}>{{ $brand['name'] }}</option>
                                            @endforeach
                                        </select>
                                        <span
                                            class="text-danger">{{$errors->first('preferred_car_brand') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="preferred_method">
                                            <option hidden value="">{{__('reservation.preferred_method')}}</option>
                                            <option value="rental" {{ (old('preferred_method') == 'rental') ? 'selected' : '' }}>{{__('reservation.rental')}}</option>
                                            <option value="taxi" {{ (old('preferred_method') == 'taxi') ? 'selected' : '' }}>{{__('reservation.taxi')}}</option>
                                            <option value="public_transport">{{__('reservation.public_transport')}}</option>
                                        </select>
                                        <span
                                            class="text-danger">{{$errors->first('preferred_method') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control customInput"
                                                   name="payment_rate" value="{{old('payment_rate')}}"
                                                   autocomplete="off"
                                                   placeholder="{{__('reservation.payment_rate')}}">
                                            <div class="input-group-append position-absolute leftInput-0">
                                                <span
                                                    class="input-group-text bg-transparent border-0 text-danger">*</span>
                                            </div>
                                        </div>
                                        <span
                                            class="text-danger">{{$errors->first('payment_rate') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="with_driver">
                                            <option hidden value="">{{__('reservation.with_driver')}}</option>
                                            <option value="1" {{ (old('with_driver') == '1') ? 'selected' : '' }}>{{__('reservation.yes')}}</option>
                                            <option value="0" {{ (old('with_driver') == '0') ? 'selected' : '' }}>{{__('reservation.no')}}</option>
                                        </select>
                                        <span
                                            class="text-danger">{{$errors->first('with_driver') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="preferred_pickup_place">
                                            <option hidden value="">{{__('reservation.preferred_pickup_place')}}</option>
                                            <option value="airport" {{ (old('preferred_pickup_place') == 'airport') ? 'selected' : '' }}>{{__('reservation.airport')}}</option>
                                            <option value="hotel" {{ (old('preferred_pickup_place') == 'hotel') ? 'selected' : '' }}>{{__('reservation.hotel')}}</option>
                                        </select>
                                        <span
                                            class="text-danger">{{$errors->first('preferred_pickup_place') ?? ''}}</span>
                                    </div>
                                    <div class="col-md-6 text-left mt-2">
                                        <select class="form-control" name="preferred_delivery_place">
                                            <option hidden value="">{{__('reservation.preferred_delivery_place')}}</option>
                                            <option value="airport" {{ (old('preferred_delivery_place') == 'airport') ? 'selected' : '' }}>{{__('reservation.airport')}}</option>
                                            <option value="hotel" {{ (old('preferred_delivery_place') == 'hotel') ? 'selected' : '' }}>{{__('reservation.hotel')}}</option>
                                        </select>
                                        <span
                                            class="text-danger">{{$errors->first('preferred_delivery_place') ?? ''}}</span>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit"
                                                class="btn btn-primary" style="width: 200px">{{__('reservation.submit')}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        $(function () {
            var mobileInput = $('#mobile');
            var countryCode = $('#countryCode');
            var mobileCode = $('#mobileCode');
            var iti = intlTelInput(mobileInput.get(0), {
                separateDialCode: true,
                initialCountry:"{{old('country_code', 'sa')}}",
                onlyCountries: ["sa", "ae"],
                excludeCountries: ["il"]
            });

            mobileInput.on('countrychange', function(e) {
                mobileCode.val(iti.getSelectedCountryData().dialCode);
                countryCode.val(iti.getSelectedCountryData().iso2);
            });

            mobileInput.trigger('countrychange')
        });
    </script>
@endpush
