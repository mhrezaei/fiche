@section('head')
    {!! Html::style('assets/libs/bootstrap-select/bootstrap-select.min.css') !!}
@append

@section('endOfBody')
    <script>
        var bootstrapTooltip = $.fn.tooltip.noConflict(); // return $.fn.tooltip to previously assigned value
    </script>

    {!! Html::script ('assets/libs/bootstrap-select/bootstrap-select.min.js') !!}
    {!! Html::script ('assets/libs/jquery.form.min.js') !!}
    {!! Html::script ('assets/js/forms.js') !!}
    {!! Html::script ('assets/libs/jquery-ui/jquery-ui.min.js') !!}
    @include('front.frame.datepicker_assets')

    <script>
        $.fn.tooltip = bootstrapTooltip; // give $().bootstrapTooltip the Bootstrap functionality
        function getReadyForStepOne() {
            // Changing the flag for discovering step of registration
            $('#step-number').val(1);

            // Disabling additional input
            $('#additional-fields').find(':input').attr('disabled', 'disabled');
        }
        function getReadyForStepTwo() {
            // Make the "code_melli" field readonly
            $('#code_melli').attr('readonly', 'readonly');

            // Changing the flag for discovering step of registration
            $('#step-number').val(2);

            // Enabling additional input
            $('#additional-fields').find(':input').removeAttr('disabled');

            // Show the additional fields for step 2 to the form
            $('#additional-fields').slideDown();

            // Refreshing view of buttonsets
            $(".form-buttonset").each(function () {
                // var options = $(this).dataStartsWith(juiDataPrefix.buttonset);
                $(this).buttonset().buttonset('refresh');
            });
        }

        $(document).ready(function () {
            getReadyForStepOne();
        });
    </script>
@append

<div class="row article">
    <div class="container">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    @if(!user()->exists)
                        {!! Form::open([
                                    'url'	=> 'register/card' ,
                                    'method'=> 'post',
                                    'class' => 'clearfix ehda-card-form js',
                                    'name' => 'register_form',
                                    'id' => 'register_form',
                                ]) !!}

                        @include('forms.hidden', [
                            'id' => 'step-number',
                            'name' => 'step',
                            'value' => 1,
                        ])

                        <div class="row border-2 border-blue pt15 pb15">

                            {{ null, $cardImage = setting()->ask('organ_donation_card_image_front')->gain() }}
                            @if($cardImage)
                                <div class="col-xs-8 col-xs-offset-2">
                                    <img src="{{ url($cardImage) }}"
                                         class="img-responsive shadow-m rounded-corners-20 mb20"/>
                                </div>
                            @endif

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <div>{{ trans('front.personal_information') }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'name_first',
                                        'class' => 'form-persian form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.name_first'),
                                            'minlength' => 2,
                                        ]
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'name_last',
                                        'class' => 'form-persian form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.name_last'),
                                            'minlength' => 2,
                                        ]
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'code_melli',
                                        'class' => 'form-national form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.code_melli'),
                                            'minlength' => 10,
                                            'maxlength' => 10,
                                        ]
                                    ])
                                </div>
                            </div>
                            <div id="additional-fields" style="display: none">
                                <div class="col-xs-12">
                                    @include('forms._select-gender', [
                                        'class' => 'form-select form-required',
                                        'required' => 1,
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'name_father',
                                        'class' => 'form-persian form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.name_father'),
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'code_id',
                                        'class' => 'form-number form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.code_id'),
                                            'minlength' => 1,
                                            'maxlength' => 10,
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('forms._birthdate-datepicker', [
                                        'class' => 'form-datepicker form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.birth_date'),
                                        ]
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms._states-selectpicker', [
                                        'name' => 'birth_city' ,
                                        'required' => 1,
                                        'class' => 'form-required',
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.select-picker', [
                                        'name' => 'edu_level',
                                        'class' => 'form-select form-required',
                                        'blank_value' => '0' ,
                                        'required' => 1,
                                        'options' =>
                                            collect(\Illuminate\Support\Facades\Lang::get('people.edu_level_full'))
                                            ->map(function ($item, $key) {
                                                return ['id' => $key, 'title' => $item];
                                            }),
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'job',
                                        'class' => 'form-persian form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.job'),
                                            'minlength' => 2,
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <h5 class="form-heading">{{ trans('front.contact_info') }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'mobile',
                                        'class' => 'form-mobile form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.mobile'),
                                            'minlength' => 11,
                                            'maxlength' => 11,
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'home_tel',
                                        'class' => 'form-phone form-required',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.home_tel'),
                                            'minlength' => 11,
                                            'maxlength' => 11,
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms._states-selectpicker', [
                                        'name' => 'home_city' ,
                                        'required' => 1,
                                        'class' => 'form-required',
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'email',
                                        'class' => 'form-email',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.email'),
                                        ]
                                    ])
                                </div>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <h5 class="form-heading">{{ trans('front.login_info') }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'password',
                                        'class' => 'form-password form-required',
                                        'type' => 'password',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.password'),
                                            'minlength' => 8,
                                            'maxlength' => 64,
                                        ]
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('front.forms.input', [
                                        'name' => 'password2',
                                        'class' => 'form-required',
                                        'type' => 'password',
                                        'dataAttributes' => [
                                            'toggle' => 'tooltip',
                                            'placement' => 'top',
                                        ],
                                        'otherAttributes' => [
                                            'title' => trans('validation.attributes_example.password2'),
                                            'minlength' => 8,
                                            'maxlength' => 64,
                                        ]
                                    ])
                                </div>

                            </div>
                            {{--<div class="col-xs-12">--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="security">{{ $captcha['question'] }} <span--}}
                            {{--class="text-danger">*</span></label>--}}
                            {{--<input type="text" class="form-control form-number form-required" id="security"--}}
                            {{--name="security" data-toggle="tooltip" data-placement="top"--}}
                            {{--placeholder="{{ trans('validation.attributes_placeholder.security') }}"--}}
                            {{--title="{{ trans('validation.attributes_example.security') }}" minlength="1"--}}
                            {{--error-value="{{ trans('validation.javascript_validation.security') }}">--}}
                            {{--<input type="hidden" name="key" value="{{$captcha['key']}}">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-xs-12 pt15">
                                @include('forms.feed')
                            </div>
                            <div class="col-xs-12 text-center">
                                @include('forms.button', [
                                    'shape' => 'success',
                                    'label' => trans('forms.button.send'),
                                    'type' => 'submit',
                                ])
                            </div>
                        </div>
                        {!! Form::close() !!}

                    @endif
                </div>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 text-justify">
                            {!! $post->text !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>