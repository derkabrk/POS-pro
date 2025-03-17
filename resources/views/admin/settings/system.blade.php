@extends('layouts.master')

@section('title')
    {{__('System Settings') }}
@endsection

@section('main_content')

<div class="erp-table-section system-settings">
    <div class="container-fluid">
        <div class="card ">
            <div class="card-bodys">

        <div class="table-header ">
            <div class="card-bodys">
                <div class="table-header mb-0 border-0 p-16">
                    <h4>{{ __('Note :') }} <span class="custom-warning">{{ __("Don't Use Any Kind Of Space In The Input Fields") }}</span></h4>
                </div>
            </div>
        </div>

        <div class="order-form-section mt-4 p-16">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="add-new-petty" role="tabpanel">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 mb-3">
                            <div class="cards-header shadow">
                                <div class="card-body">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item">
                                            <a href="#app" id="home-tab4" class="add-report-btn active nav-link" data-bs-toggle="tab">{{ __('App') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#Drivers" class="add-report-btn nav-link" data-bs-toggle="tab">{{ __('Drivers') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#storage" class="add-report-btn nav-link" data-bs-toggle="tab">{{ __('Storage Settings') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#mail-configuration" class="add-report-btn nav-link" data-bs-toggle="tab">{{ __('Mail Configuration') }}</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="#other" class="add-report-btn nav-link" data-bs-toggle="tab">{{ __('Others') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8">
                            <div class="cards-header shadow">
                                <div class="card-body">
                                    <form action="{{ route('admin.system-settings.store') }}" method="post" class="ajaxform">
                                        @csrf

                                        <div class="tab-content no-padding">
                                            <div class="tab-pane fade show active" id="app">
                                                <div class="form-group">
                                                    <label>{{ __('APP_NAME') }}</label>
                                                    <input type="text" name="APP_NAME" value="{{ env('APP_NAME') ?? '' }}"  required class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('APP_KEY') }}</label>
                                                    <input type="text" name="APP_KEY" value="{{ env('APP_KEY') ?? '' }}" required  class="form-control" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('APP_DEBUG') }}</label>
                                                    <div class="gpt-up-down-arrow position-relative">
                                                    <select class="form-control" required name="APP_DEBUG">
                                                        <option value="true" @selected(env('APP_DEBUG') == true)>{{ __('true (Developers Only)') }}</option>
                                                        <option value="false" @selected(env('APP_DEBUG') == false)>{{ __('false') }}</option>
                                                    </select>
                                                    <span></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('APP_URL') }}</label>
                                                    <input type="text" name="APP_URL" value="{{ env('APP_URL') ?? '' }}" required class="form-control">
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="button-group text-center mt-4">
                                                            <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="mail-configuration">
                                                <div class="form-group">
                                                    <label for="QUEUE_MAIL" class="required">{{ __('QUEUE_MAIL') }}</label>
                                                    <div class="gpt-up-down-arrow position-relative">
                                                    <select name="QUEUE_MAIL" id="QUEUE_MAIL" class="form-control">
                                                        <option @selected(env('QUEUE_MAIL') == true) value="true">{{ __('true') }}</option>
                                                        <option @selected(env('QUEUE_MAIL') == false) value="false">{{ __('false') }}</option>
                                                    </select>
                                                    <span></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('MAIL_DRIVER_TYPE') }}</label>
                                                    <div class="gpt-up-down-arrow position-relative">
                                                        <select name="MAIL_DRIVER_TYPE" class="form-control" id="mail-driver-type-select">
                                                            <option value="MAIL_MAILER" @selected(env('MAIL_DRIVER_TYPE') == 'MAIL_MAILER' ? 'selected' : '')>{{ __('MAIL MAILER') }}</option>
                                                            <option value="MAIL_DRIVER" @selected(env('MAIL_DRIVER_TYPE') == 'MAIL_DRIVER' ? 'selected' : '')>{{ __('MAIL DRIVER') }}</option>
                                                        </select>
                                                        <span></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label id="mail-driver-label">{{ __('MAIL DRIVER') }}</label>
                                                    <select name="MAIL_DRIVER" class="form-control">
                                                        <option @selected(env('MAIL_DRIVER') == 'sendmail') value="sendmail">{{ __('sendmail') }}</option>
                                                        <option @selected(env('MAIL_DRIVER') == 'smtp') value="smtp">{{ __('smtp') }}</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('MAIL_HOST') }}</label>
                                                    <input type="text"  name="MAIL_HOST" value="{{ env('MAIL_HOST') ?? '' }}" class="form-control" >
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('MAIL_PORT') }}</label>
                                                    <input type="text"  name="MAIL_PORT" value="{{ env('MAIL_PORT') ?? '' }}" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('MAIL_USERNAME') }}</label>
                                                    <input type="text"   name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') ?? '' }}" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('MAIL_PASSWORD') }}</label>
                                                    <input type="text"   name="MAIL_PASSWORD" value="{{ env('DEMO_MODE') ? '....' : env('MAIL_PASSWORD') }}" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('MAIL_ENCRYPTION') }}</label>
                                                    <input type="text"   name="MAIL_ENCRYPTION" value="{{ env('MAIL_ENCRYPTION') ?? '' }}" class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('MAIL_FROM_ADDRESS') }}</label>
                                                    <input type="text"   name="MAIL_FROM_ADDRESS" value="{{ env('MAIL_FROM_ADDRESS') ?? '' }}" class="form-control" >
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('MAIL_FROM_NAME') }}</label>
                                                    <input type="text"   name="MAIL_FROM_NAME" value="{{ env('MAIL_FROM_NAME') ?? '' }}" class="form-control" >
                                                </div>

                                                <span>{{ __('Note :') }} <span class="text-danger">{{ __('If you are using MAIL QUEUE after Changing The Mail Settings You Need To Restart Your Supervisor From Your Server') }}</span></span><br>

                                                <span>{{ __('QUEUE COMMAND Path :') }} <span class="text-danger">{{ __('/home/u186958312/domains/maanai.acnoo.com/public_html/maanai') }}</span></span><br>
                                                <span>{{ __('QUEUE COMMAND :') }} <span class="text-danger">{{ __('php artisan queue:work') }}</span></span>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="button-group text-center mt-4">
                                                            <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="Drivers">
                                                <div class="form-group">
                                                    <label for="CACHE_DRIVER">{{ __('CACHE_DRIVER') }}</label>
                                                    <div class="gpt-up-down-arrow position-relative">
                                                    <select class="form-control" name="CACHE_DRIVER" required>
                                                        <option value="array" {{ old('CACHE_DRIVER', 'file') == 'array' ? 'selected' : '' }}>{{ __('Array (Low Performance)') }}</option>
                                                        <option value="file" {{ old('CACHE_DRIVER', 'file') == 'file' ? 'selected' : '' }}>{{ __('File (Good Performance)') }}</option>
                                                        <option value="memcached" {{ old('CACHE_DRIVER', 'file') == 'memcached' ? 'selected' : '' }}>{{ __("Memcached (Don't Enable If You Don't Have Memcached Extension)") }}</option>
                                                        <option value="redis" {{ old('CACHE_DRIVER', 'file') == 'redis' ? 'selected' : '' }}>{{ __("Redis (Don't Enable If You Don't Have phpredis Extension)") }}</option>
                                                    </select>
                                                    <span></span>
                                                    </div>

                                                    <small class="text-danger">{{ __('Recommended') }} <strong>{{ __('Memcached or Redis') }}</strong>{{ __('Cache Driver For Height Performance Application And Optimize Call Database Query') }} </small>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('QUEUE_CONNECTION') }}</label>
                                                    <input type="text" required="" name="QUEUE_CONNECTION" class="form-control" value="{{ env('QUEUE_CONNECTION') ?? 'database' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('SESSION_DRIVER') }}</label>
                                                    <input type="text" required="" name="SESSION_DRIVER" class="form-control" value="{{ env('SESSION_DRIVER') ?? 'file' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('SESSION_LIFETIME') }}</label>
                                                    <input type="number" required="" name="SESSION_LIFETIME" class="form-control" value="{{ env('SESSION_LIFETIME') ?? 200 }}">
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="button-group text-center mt-4">
                                                            <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="redis_method">
                                                <div class="form-group">
                                                    <label>{{ __('REDIS_PORT') }}</label>
                                                    <input type="text"  name="REDIS_PORT" class="form-control" value="6379">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('REDIS_URL') }}</label>
                                                    <input type="text"  name="REDIS_URL" class="form-control" value="">
                                                </div>

                                                <div class="form-group">
                                                    <label>{{ __('REDIS_PASSWORD') }}</label>
                                                    <input type="text"  name="REDIS_PASSWORD" class="form-control" value="">
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="storage">
                                                <h6>{{ __('Storage Settings') }}</h6>
                                                <div class="form-group">
                                                    <label>{{ __('Storage Method') }}</label>
                                                    <div class="gpt-up-down-arrow position-relative">
                                                    <select class="form-control" name="FILESYSTEM_DISK">
                                                        <option @selected(env('FILESYSTEM_DISK') == 'public') value="public">{{ __('public (uploads folder)') }}</option>
                                                        <option @selected(env('FILESYSTEM_DISK') == 's3') value="s3">{{ __('AWS S3 Storage Bucket') }}</option>
                                                        <option @selected(env('FILESYSTEM_DISK') == 'wasabi') value="wasabi">{{ __('Wasabi Storage Bucket') }}</option>
                                                    </select>
                                                    <span></span>
                                                    </div>
                                                </div>

                                                <hr>
                                                <p class="custom-warning">{{ __('Fill up this credentials if you want to use AWS S3 Storage Bucket') }}</p>
                                                <div class="form-group">
                                                    <label>{{ __('AWS_ACCESS_KEY_ID') }}</label>
                                                    <input type="text"  name="AWS_ACCESS_KEY_ID" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('AWS_SECRET_ACCESS_KEY') }}</label>
                                                    <input type="text"  name="AWS_SECRET_ACCESS_KEY" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('AWS_DEFAULT_REGION') }}</label>
                                                    <input type="text"  name="AWS_DEFAULT_REGION" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('AWS_BUCKET') }}</label>
                                                    <input type="text"  name="AWS_BUCKET" class="form-control" value="">
                                                </div>
                                                <hr>
                                                <p class="custom-warning">{{ __('Fill up this credentials if you want to use Wasabi Storage Bucket') }}</p>
                                                <div class="form-group">
                                                    <label>{{ __('WAS_ACCESS_KEY_ID') }}</label>
                                                    <input type="text"  name="WAS_ACCESS_KEY_ID" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('WAS_SECRET_ACCESS_KEY') }}</label>
                                                    <input type="text"  name="WAS_SECRET_ACCESS_KEY" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('WAS_DEFAULT_REGION') }}</label>
                                                    <input type="text"  name="WAS_DEFAULT_REGION" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('WAS_BUCKET') }}</label>
                                                    <input type="text"  name="WAS_BUCKET" class="form-control" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('WAS_ENDPOINT') }}</label>
                                                    <input type="text"  name="WAS_ENDPOINT" class="form-control" value="">
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="button-group text-center mt-4">
                                                            <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="other">
                                                <div class="">
                                                    <div class="form-group">
                                                        <label>{{ __('CACHE_LIFETIME') }}</label>
                                                        <input type="text"  name="CACHE_LIFETIME" class="form-control" value="{{ env('CACHE_LIFETIME') ?? '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="TIMEZONE">{{ __('TIMEZONE') }}</label>
                                                        <div class="gpt-up-down-arrow position-relative">
                                                            <select class="form-control" name="TIMEZONE" id="TIMEZONE" >
                                                                <option @selected(env('TIMEZONE') == 'Africa/Abidjan') value='Africa/Abidjan'>{{ __('Africa/Abidjan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Accra') value='Africa/Accra'>{{ __('Africa/Accra') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Addis_Ababa') value='Africa/Addis_Ababa'>{{ __('Africa/Addis_Ababa') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Algiers') value='Africa/Algiers'>{{ __('Africa/Algiers') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Asmara') value='Africa/Asmara'>{{ __('Africa/Asmara') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Bamako') value='Africa/Bamako'>{{ __('Africa/Bamako') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Bangui') value='Africa/Bangui'>{{ __('Africa/Bangui') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Banjul') value='Africa/Banjul'>{{ __('Africa/Banjul') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Bissau') value='Africa/Bissau'>{{ __('Africa/Bissau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Blantyre') value='Africa/Blantyre'>{{ __('Africa/Blantyre') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Brazzaville') value='Africa/Brazzaville'>{{ __('Africa/Brazzaville') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Bujumbura') value='Africa/Bujumbura'>{{ __('Africa/Bujumbura') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Cairo') value='Africa/Cairo'>{{ __('Africa/Cairo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Casablanca') value='Africa/Casablanca'>{{ __('Africa/Casablanca') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Ceuta') value='Africa/Ceuta'>{{ __('Africa/Ceuta') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Conakry') value='Africa/Conakry'>{{ __('Africa/Conakry') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Dakar') value='Africa/Dakar'>{{ __('Africa/Dakar') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Dar_es_Salaam') value='Africa/Dar_es_Salaam'>{{ __('Africa/Dar_es_Salaam') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Djibouti') value='Africa/Djibouti'>{{ __('Africa/Djibouti') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Douala') value='Africa/Douala'>{{ __('Africa/Douala') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/El_Aaiun') value='Africa/El_Aaiun'>{{ __('Africa/El_Aaiun') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Freetown') value='Africa/Freetown'>{{ __('Africa/Freetown') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Gaborone') value='Africa/Gaborone'>{{ __('Africa/Gaborone') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Harare') value='Africa/Harare'>{{ __('Africa/Harare') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Johannesburg') value='Africa/Johannesburg'>{{ __('Africa/Johannesburg') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Juba') value='Africa/Juba'>{{ __('Africa/Juba') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Kampala') value='Africa/Kampala'>{{ __('Africa/Kampala') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Khartoum') value='Africa/Khartoum'>{{ __('Africa/Khartoum') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Kigali') value='Africa/Kigali'>{{ __('Africa/Kigali') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Kinshasa') value='Africa/Kinshasa'>{{ __('Africa/Kinshasa') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Lagos') value='Africa/Lagos'>{{ __('Africa/Lagos') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Libreville') value='Africa/Libreville'>{{ __('Africa/Libreville') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Lome') value='Africa/Lome'>{{ __('Africa/Lome') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Luanda') value='Africa/Luanda'>{{ __('Africa/Luanda') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Lubumbashi') value='Africa/Lubumbashi'>{{ __('Africa/Lubumbashi') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Lusaka') value='Africa/Lusaka'>{{ __('Africa/Lusaka') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Malabo') value='Africa/Malabo'>{{ __('Africa/Malabo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Maputo') value='Africa/Maputo'>{{ __('Africa/Maputo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Maseru') value='Africa/Maseru'>{{ __('Africa/Maseru') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Mbabane') value='Africa/Mbabane'>{{ __('Africa/Mbabane') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Mogadishu') value='Africa/Mogadishu'>{{ __('Africa/Mogadishu') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Monrovia') value='Africa/Monrovia'>{{ __('Africa/Monrovia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Nairobi') value='Africa/Nairobi'>{{ __('Africa/Nairobi') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Ndjamena') value='Africa/Ndjamena'>{{ __('Africa/Ndjamena') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Niamey') value='Africa/Niamey'>{{ __('Africa/Niamey') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Nouakchott') value='Africa/Nouakchott'>{{ __('Africa/Nouakchott') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Ouagadougou') value='Africa/Ouagadougou'>{{ __('Africa/Ouagadougou') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Porto-Novo') value='Africa/Porto-Novo'>{{ __('Africa/Porto-Novo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Sao_Tome') value='Africa/Sao_Tome'>{{ __('Africa/Sao_Tome') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Tripoli') value='Africa/Tripoli'>{{ __('Africa/Tripoli') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Tunis') value='Africa/Tunis'>{{ __('Africa/Tunis') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Africa/Windhoek') value='Africa/Windhoek'>{{ __('Africa/Windhoek') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Adak') value='America/Adak'>{{ __('America/Adak') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Anchorage') value='America/Anchorage'>{{ __('America/Anchorage') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Anguilla') value='America/Anguilla'>{{ __('America/Anguilla') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Antigua') value='America/Antigua'>{{ __('America/Antigua') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Araguaina') value='America/Araguaina'>{{ __('America/Araguaina') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Buenos_Aires') value='America/Argentina/Buenos_Aires'>{{ __('America/Argentina/Buenos_Aires') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Catamarca') value='America/Argentina/Catamarca'>{{ __('America/Argentina/Catamarca') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Cordoba') value='America/Argentina/Cordoba'>{{ __('America/Argentina/Cordoba') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Jujuy') value='America/Argentina/Jujuy'>{{ __('America/Argentina/Jujuy') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/La_Rioja') value='America/Argentina/La_Rioja'>{{ __('America/Argentina/La_Rioja') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Mendoza') value='America/Argentina/Mendoza'>{{ __('America/Argentina/Mendoza') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Rio_Gallegos') value='America/Argentina/Rio_Gallegos'>{{ __('America/Argentina/Rio_Gallegos') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Salta') value='America/Argentina/Salta'>{{ __('America/Argentina/Salta') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/San_Juan') value='America/Argentina/San_Juan'>{{ __('America/Argentina/San_Juan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/San_Luis') value='America/Argentina/San_Luis'>{{ __('America/Argentina/San_Luis') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Tucuman') value='America/Argentina/Tucuman'>{{ __('America/Argentina/Tucuman') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Argentina/Ushuaia') value='America/Argentina/Ushuaia'>{{ __('America/Argentina/Ushuaia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Aruba') value='America/Aruba'>{{ __('America/Aruba') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Asuncion') value='America/Asuncion'>{{ __('America/Asuncion') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Atikokan') value='America/Atikokan'>{{ __('America/Atikokan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Bahia') value='America/Bahia'>{{ __('America/Bahia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Bahia_Banderas') value='America/Bahia_Banderas'>{{ __('America/Bahia_Banderas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Barbados') value='America/Barbados'>{{ __('America/Barbados') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Belem') value='America/Belem'>{{ __('America/Belem') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Belize') value='America/Belize'>{{ __('America/Belize') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Blanc-Sablon') value='America/Blanc-Sablon'>{{ __('America/Blanc-Sablon') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Boa_Vista') value='America/Boa_Vista'>{{ __('America/Boa_Vista') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Bogota') value='America/Bogota'>{{ __('America/Bogota') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Boise') value='America/Boise'>{{ __('America/Boise') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Cambridge_Bay') value='America/Cambridge_Bay'>{{ __('America/Cambridge_Bay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Campo_Grande') value='America/Campo_Grande'>{{ __('America/Campo_Grande') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Cancun') value='America/Cancun'>{{ __('America/Cancun') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Caracas') value='America/Caracas'>{{ __('America/Caracas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Cayenne') value='America/Cayenne'>{{ __('America/Cayenne') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Cayman') value='America/Cayman'>{{ __('America/Cayman') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Chicago') value='America/Chicago'>{{ __('America/Chicago') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Chihuahua') value='America/Chihuahua'>{{ __('America/Chihuahua') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Costa_Rica') value='America/Costa_Rica'>{{ __('America/Costa_Rica') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Creston') value='America/Creston'>{{ __('America/Creston') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Cuiaba') value='America/Cuiaba'>{{ __('America/Cuiaba') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Curacao') value='America/Curacao'>{{ __('America/Curacao') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Danmarkshavn') value='America/Danmarkshavn'>{{ __('America/Danmarkshavn') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Dawson') value='America/Dawson'>{{ __('America/Dawson') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Dawson_Creek') value='America/Dawson_Creek'>{{ __('America/Dawson_Creek') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Denver') value='America/Denver'>{{ __('America/Denver') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Detroit') value='America/Detroit'>{{ __('America/Detroit') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Dominica') value='America/Dominica'>{{ __('America/Dominica') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Edmonton') value='America/Edmonton'>{{ __('America/Edmonton') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Eirunepe') value='America/Eirunepe'>{{ __('America/Eirunepe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/El_Salvador') value='America/El_Salvador'>{{ __('America/El_Salvador') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Fort_Nelson') value='America/Fort_Nelson'>{{ __('America/Fort_Nelson') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Fortaleza') value='America/Fortaleza'>{{ __('America/Fortaleza') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Glace_Bay') value='America/Glace_Bay'>{{ __('America/Glace_Bay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Godthab') value='America/Godthab'>{{ __('America/Godthab') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Goose_Bay') value='America/Goose_Bay'>{{ __('America/Goose_Bay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Grand_Turk') value='America/Grand_Turk'>{{ __('America/Grand_Turk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Grenada') value='America/Grenada'>{{ __('America/Grenada') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Guadeloupe') value='America/Guadeloupe'>{{ __('America/Guadeloupe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Guatemala') value='America/Guatemala'>{{ __('America/Guatemala') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Guayaquil') value='America/Guayaquil'>{{ __('America/Guayaquil') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Guyana') value='America/Guyana'>{{ __('America/Guyana') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Halifax') value='America/Halifax'>{{ __('America/Halifax') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Havana') value='America/Havana'>{{ __('America/Havana') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Hermosillo') value='America/Hermosillo'>{{ __('America/Hermosillo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Indianapolis') value='America/Indiana/Indianapolis'>{{ __('America/Indiana/Indianapolis') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Knox') value='America/Indiana/Knox'>{{ __('America/Indiana/Knox') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Marengo') value='America/Indiana/Marengo'>{{ __('America/Indiana/Marengo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Petersburg') value='America/Indiana/Petersburg'>{{ __('America/Indiana/Petersburg') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Tell_City') value='America/Indiana/Tell_City'>{{ __('America/Indiana/Tell_City') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Vevay') value='America/Indiana/Vevay'>{{ __('America/Indiana/Vevay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Vincennes') value='America/Indiana/Vincennes'>{{ __('America/Indiana/Vincennes') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Indiana/Winamac') value='America/Indiana/Winamac'>{{ __('America/Indiana/Winamac') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Inuvik') value='America/Inuvik'>{{ __('America/Inuvik') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Iqaluit') value='America/Iqaluit'>{{ __('America/Iqaluit') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Jamaica') value='America/Jamaica'>{{ __('America/Jamaica') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Juneau') value='America/Juneau'>{{ __('America/Juneau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Kentucky/Louisville') value='America/Kentucky/Louisville'>{{ __('America/Kentucky/Louisville') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Kentucky/Monticello') value='America/Kentucky/Monticello'>{{ __('America/Kentucky/Monticello') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Kralendijk') value='America/Kralendijk'>{{ __('America/Kralendijk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/La_Paz') value='America/La_Paz'>{{ __('America/La_Paz') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Lima') value='America/Lima'>{{ __('America/Lima') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Los_Angeles') value='America/Los_Angeles'>{{ __('America/Los_Angeles') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Lower_Princes') value='America/Lower_Princes'>{{ __('America/Lower_Princes') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Maceio') value='America/Maceio'>{{ __('America/Maceio') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Managua') value='America/Managua'>{{ __('America/Managua') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Manaus') value='America/Manaus'>{{ __('America/Manaus') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Marigot') value='America/Marigot'>{{ __('America/Marigot') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Martinique') value='America/Martinique'>{{ __('America/Martinique') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Matamoros') value='America/Matamoros'>{{ __('America/Matamoros') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Mazatlan') value='America/Mazatlan'>{{ __('America/Mazatlan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Menominee') value='America/Menominee'>{{ __('America/Menominee') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Merida') value='America/Merida'>{{ __('America/Merida') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Metlakatla') value='America/Metlakatla'>{{ __('America/Metlakatla') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Mexico_City') value='America/Mexico_City'>{{ __('America/Mexico_City') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Miquelon') value='America/Miquelon'>{{ __('America/Miquelon') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Moncton') value='America/Moncton'>{{ __('America/Moncton') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Monterrey') value='America/Monterrey'>{{ __('America/Monterrey') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Montevideo') value='America/Montevideo'>{{ __('America/Montevideo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Montserrat') value='America/Montserrat'>{{ __('America/Montserrat') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Nassau') value='America/Nassau'>{{ __('America/Nassau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/New_York') value='America/New_York'>{{ __('America/New_York') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Nipigon') value='America/Nipigon'>{{ __('America/Nipigon') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Nome') value='America/Nome'>{{ __('America/Nome') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Noronha') value='America/Noronha'>{{ __('America/Noronha') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/North_Dakota/Beulah') value='America/North_Dakota/Beulah'>{{ __('America/North_Dakota/Beulah') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/North_Dakota/Center') value='America/North_Dakota/Center'>{{ __('America/North_Dakota/Center') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/North_Dakota/New_Salem') value='America/North_Dakota/New_Salem'>{{ __('America/North_Dakota/New_Salem') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Ojinaga') value='America/Ojinaga'>{{ __('America/Ojinaga') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Panama') value='America/Panama'>{{ __('America/Panama') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Pangnirtung') value='America/Pangnirtung'>{{ __('America/Pangnirtung') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Paramaribo') value='America/Paramaribo'>{{ __('America/Paramaribo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Phoenix') value='America/Phoenix'>{{ __('America/Phoenix') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Port-au-Prince') value='America/Port-au-Prince'>{{ __('America/Port-au-Prince') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Port_of_Spain') value='America/Port_of_Spain'>{{ __('America/Port_of_Spain') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Porto_Velho') value='America/Porto_Velho'>{{ __('America/Porto_Velho') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Puerto_Rico') value='America/Puerto_Rico'>{{ __('America/Puerto_Rico') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Punta_Arenas') value='America/Punta_Arenas'>{{ __('America/Punta_Arenas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Rainy_River') value='America/Rainy_River'>{{ __('America/Rainy_River') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Rankin_Inlet') value='America/Rankin_Inlet'>{{ __('America/Rankin_Inlet') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Recife') value='America/Recife'>{{ __('America/Recife') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Regina') value='America/Regina'>{{ __('America/Regina') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Resolute') value='America/Resolute'>{{ __('America/Resolute') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Rio_Branco') value='America/Rio_Branco'>{{ __('America/Rio_Branco') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Santarem') value='America/Santarem'>{{ __('America/Santarem') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Santiago') value='America/Santiago'>{{ __('America/Santiago') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Santo_Domingo') value='America/Santo_Domingo'>{{ __('America/Santo_Domingo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Sao_Paulo') value='America/Sao_Paulo'>{{ __('America/Sao_Paulo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Scoresbysund') value='America/Scoresbysund'>{{ __('America/Scoresbysund') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Sitka') value='America/Sitka'>{{ __('America/Sitka') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Barthelemy') value='America/St_Barthelemy'>{{ __('America/St_Barthelemy') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Johns') value='America/St_Johns'>{{ __('America/St_Johns') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Kitts') value='America/St_Kitts'>{{ __('America/St_Kitts') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Lucia') value='America/St_Lucia'>{{ __('America/St_Lucia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Thomas') value='America/St_Thomas'>{{ __('America/St_Thomas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/St_Vincent') value='America/St_Vincent'>{{ __('America/St_Vincent') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Swift_Current') value='America/Swift_Current'>{{ __('America/Swift_Current') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Tegucigalpa') value='America/Tegucigalpa'>{{ __('America/Tegucigalpa') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Thule') value='America/Thule'>{{ __('America/Thule') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Thunder_Bay') value='America/Thunder_Bay'>{{ __('America/Thunder_Bay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Tijuana') value='America/Tijuana'>{{ __('America/Tijuana') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Toronto') value='America/Toronto'>{{ __('America/Toronto') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Tortola') value='America/Tortola'>{{ __('America/Tortola') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Vancouver') value='America/Vancouver'>{{ __('America/Vancouver') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Whitehorse') value='America/Whitehorse'>{{ __('America/Whitehorse') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Winnipeg') value='America/Winnipeg'>{{ __('America/Winnipeg') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Yakutat') value='America/Yakutat'>{{ __('America/Yakutat') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'America/Yellowknife') value='America/Yellowknife'>{{ __('America/Yellowknife') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Casey') value='Antarctica/Casey'>{{ __('Antarctica/Casey') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Davis') value='Antarctica/Davis'>{{ __('Antarctica/Davis') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/DumontDUrville') value='Antarctica/DumontDUrville'>{{ __('Antarctica/DumontDUrville') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Macquarie') value='Antarctica/Macquarie'>{{ __('Antarctica/Macquarie') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Mawson') value='Antarctica/Mawson'>{{ __('Antarctica/Mawson') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/McMurdo') value='Antarctica/McMurdo'>{{ __('Antarctica/McMurdo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Palmer') value='Antarctica/Palmer'>{{ __('Antarctica/Palmer') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Rothera') value='Antarctica/Rothera'>{{ __('Antarctica/Rothera') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Syowa') value='Antarctica/Syowa'>{{ __('Antarctica/Syowa') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Troll') value='Antarctica/Troll'>{{ __('Antarctica/Troll') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Antarctica/Vostok') value='Antarctica/Vostok'>{{ __('Antarctica/Vostok') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Arctic/Longyearbyen') value='Arctic/Longyearbyen'>{{ __('Arctic/Longyearbyen') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Aden') value='Asia/Aden'>{{ __('Asia/Aden') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Almaty') value='Asia/Almaty'>{{ __('Asia/Almaty') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Amman') value='Asia/Amman'>{{ __('Asia/Amman') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Anadyr') value='Asia/Anadyr'>{{ __('Asia/Anadyr') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Aqtau') value='Asia/Aqtau'>{{ __('Asia/Aqtau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Aqtobe') value='Asia/Aqtobe'>{{ __('Asia/Aqtobe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Ashgabat') value='Asia/Ashgabat'>{{ __('Asia/Ashgabat') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Atyrau') value='Asia/Atyrau'>{{ __('Asia/Atyrau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Baghdad') value='Asia/Baghdad'>{{ __('Asia/Baghdad') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Bahrain') value='Asia/Bahrain'>{{ __('Asia/Bahrain') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Baku') value='Asia/Baku'>{{ __('Asia/Baku') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Bangkok') value='Asia/Bangkok'>{{ __('Asia/Bangkok') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Barnaul') value='Asia/Barnaul'>{{ __('Asia/Barnaul') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Beirut') value='Asia/Beirut'>{{ __('Asia/Beirut') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Bishkek') value='Asia/Bishkek'>{{ __('Asia/Bishkek') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Brunei') value='Asia/Brunei'>{{ __('Asia/Brunei') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Chita') value='Asia/Chita'>{{ __('Asia/Chita') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Choibalsan') value='Asia/Choibalsan'>{{ __('Asia/Choibalsan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Colombo') value='Asia/Colombo'>{{ __('Asia/Colombo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Damascus') value='Asia/Damascus'>{{ __('Asia/Damascus') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Dhaka') value='Asia/Dhaka'>{{ __('Asia/Dhaka') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Dili') value='Asia/Dili'>{{ __('Asia/Dili') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Dubai') value='Asia/Dubai'>{{ __('Asia/Dubai') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Dushanbe') value='Asia/Dushanbe'>{{ __('Asia/Dushanbe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Famagusta') value='Asia/Famagusta'>{{ __('Asia/Famagusta') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Gaza') value='Asia/Gaza'>{{ __('Asia/Gaza') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Hebron') value='Asia/Hebron'>{{ __('Asia/Hebron') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Ho_Chi_Minh') value='Asia/Ho_Chi_Minh'>{{ __('Asia/Ho_Chi_Minh') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Hong_Kong') value='Asia/Hong_Kong'>{{ __('Asia/Hong_Kong') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Hovd') value='Asia/Hovd'>{{ __('Asia/Hovd') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Irkutsk') value='Asia/Irkutsk'>{{ __('Asia/Irkutsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Jakarta') value='Asia/Jakarta'>{{ __('Asia/Jakarta') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Jayapura') value='Asia/Jayapura'>{{ __('Asia/Jayapura') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Jerusalem') value='Asia/Jerusalem'>{{ __('Asia/Jerusalem') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kabul') value='Asia/Kabul'>{{ __('Asia/Kabul') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kamchatka') value='Asia/Kamchatka'>{{ __('Asia/Kamchatka') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Karachi') value='Asia/Karachi'>{{ __('Asia/Karachi') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kathmandu') value='Asia/Kathmandu'>{{ __('Asia/Kathmandu') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Khandyga') value='Asia/Khandyga'>{{ __('Asia/Khandyga') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kolkata') value='Asia/Kolkata'>{{ __('Asia/Kolkata') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Krasnoyarsk') value='Asia/Krasnoyarsk'>{{ __('Asia/Krasnoyarsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kuala_Lumpur') value='Asia/Kuala_Lumpur'>{{ __('Asia/Kuala_Lumpur') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kuching') value='Asia/Kuching'>{{ __('Asia/Kuching') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Kuwait') value='Asia/Kuwait'>{{ __('Asia/Kuwait') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Macau') value='Asia/Macau'>{{ __('Asia/Macau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Magadan') value='Asia/Magadan'>{{ __('Asia/Magadan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Makassar') value='Asia/Makassar'>{{ __('Asia/Makassar') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Manila') value='Asia/Manila'>{{ __('Asia/Manila') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Muscat') value='Asia/Muscat'>{{ __('Asia/Muscat') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Nicosia') value='Asia/Nicosia'>{{ __('Asia/Nicosia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Novokuznetsk') value='Asia/Novokuznetsk'>{{ __('Asia/Novokuznetsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Novosibirsk') value='Asia/Novosibirsk'>{{ __('Asia/Novosibirsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Omsk') value='Asia/Omsk'>{{ __('Asia/Omsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Oral') value='Asia/Oral'>{{ __('Asia/Oral') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Phnom_Penh') value='Asia/Phnom_Penh'>{{ __('Asia/Phnom_Penh') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Pontianak') value='Asia/Pontianak'>{{ __('Asia/Pontianak') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Pyongyang') value='Asia/Pyongyang'>{{ __('Asia/Pyongyang') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Qatar') value='Asia/Qatar'>{{ __('Asia/Qatar') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Qostanay') value='Asia/Qostanay'>{{ __('Asia/Qostanay') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Qyzylorda') value='Asia/Qyzylorda'>{{ __('Asia/Qyzylorda') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Riyadh') value='Asia/Riyadh'>{{ __('Asia/Riyadh') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Sakhalin') value='Asia/Sakhalin'>{{ __('Asia/Sakhalin') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Samarkand') value='Asia/Samarkand'>{{ __('Asia/Samarkand') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Seoul') value='Asia/Seoul'>{{ __('Asia/Seoul') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Shanghai') value='Asia/Shanghai'>{{ __('Asia/Shanghai') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Singapore') value='Asia/Singapore'>{{ __('Asia/Singapore') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Srednekolymsk') value='Asia/Srednekolymsk'>{{ __('Asia/Srednekolymsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Taipei') value='Asia/Taipei'>{{ __('Asia/Taipei') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Tashkent') value='Asia/Tashkent'>{{ __('Asia/Tashkent') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Tbilisi') value='Asia/Tbilisi'>{{ __('Asia/Tbilisi') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Tehran') value='Asia/Tehran'>{{ __('Asia/Tehran') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Thimphu') value='Asia/Thimphu'>{{ __('Asia/Thimphu') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Tokyo') value='Asia/Tokyo'>{{ __('Asia/Tokyo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Tomsk') value='Asia/Tomsk'>{{ __('Asia/Tomsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Ulaanbaatar') value='Asia/Ulaanbaatar'>{{ __('Asia/Ulaanbaatar') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Urumqi') value='Asia/Urumqi'>{{ __('Asia/Urumqi') }}</option> @selected('Asia/Ust-Nera')
                                                                <option @selected(env('TIMEZONE') == 'Asia/Ust-Nera') value='Asia/Ust-Nera'>{{ __('Asia/Ust-Nera') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Vientiane') value='Asia/Vientiane'>{{ __('Asia/Vientiane') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Vladivostok') value='Asia/Vladivostok'>{{ __('Asia/Vladivostok') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Yakutsk') value='Asia/Yakutsk'>{{ __('Asia/Yakutsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Yangon') value='Asia/Yangon'>{{ __('Asia/Yangon') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Yekaterinburg') value='Asia/Yekaterinburg'>{{ __('Asia/Yekaterinburg') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Asia/Yerevan') value='Asia/Yerevan'>{{ __('Asia/Yerevan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Azores') value='Atlantic/Azores'>{{ __('Atlantic/Azores') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Bermuda') value='Atlantic/Bermuda'>{{ __('Atlantic/Bermuda') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Canary') value='Atlantic/Canary'>{{ __('Atlantic/Canary') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Cape_Verde') value='Atlantic/Cape_Verde'>{{ __('Atlantic/Cape_Verde') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Faroe') value='Atlantic/Faroe'>{{ __('Atlantic/Faroe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Madeira') value='Atlantic/Madeira'>{{ __('Atlantic/Madeira') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Reykjavik') value='Atlantic/Reykjavik'>{{ __('Atlantic/Reykjavik') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/South_Georgia') value='Atlantic/South_Georgia'>{{ __('Atlantic/South_Georgia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/St_Helena') value='Atlantic/St_Helena'>{{ __('Atlantic/St_Helena') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Atlantic/Stanley') value='Atlantic/Stanley'>{{ __('Atlantic/Stanley') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Adelaide') value='Australia/Adelaide'>{{ __('Australia/Adelaide') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Brisbane') value='Australia/Brisbane'>{{ __('Australia/Brisbane') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Broken_Hill') value='Australia/Broken_Hill'>{{ __('Australia/Broken_Hill') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Currie') value='Australia/Currie'>{{ __('Australia/Currie') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Darwin') value='Australia/Darwin'>{{ __('Australia/Darwin') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Eucla') value='Australia/Eucla'>{{ __('Australia/Eucla') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Hobart') value='Australia/Hobart'>{{ __('Australia/Hobart') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Lindeman') value='Australia/Lindeman'>{{ __('Australia/Lindeman') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Lord_Howe') value='Australia/Lord_Howe'>{{ __('Australia/Lord_Howe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Melbourne') value='Australia/Melbourne'>{{ __('Australia/Melbourne') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Perth') value='Australia/Perth'>{{ __('Australia/Perth') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Australia/Sydney') value='Australia/Sydney'>{{ __('Australia/Sydney') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Amsterdam') value='Europe/Amsterdam'>{{ __('Europe/Amsterdam') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Andorra') value='Europe/Andorra'>{{ __('Europe/Andorra') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Astrakhan') value='Europe/Astrakhan'>{{ __('Europe/Astrakhan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Athens') value='Europe/Athens'>{{ __('Europe/Athens') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Belgrade') value='Europe/Belgrade'>{{ __('Europe/Belgrade') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Berlin') value='Europe/Berlin'>{{ __('Europe/Berlin') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Bratislava') value='Europe/Bratislava'>{{ __('Europe/Bratislava') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Brussels') value='Europe/Brussels'>{{ __('Europe/Brussels') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Bucharest') value='Europe/Bucharest'>{{ __('Europe/Bucharest') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Budapest') value='Europe/Budapest'>{{ __('Europe/Budapest') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Busingen') value='Europe/Busingen'>{{ __('Europe/Busingen') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Chisinau') value='Europe/Chisinau'>{{ __('Europe/Chisinau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Copenhagen') value='Europe/Copenhagen'>{{ __('Europe/Copenhagen') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Dublin') value='Europe/Dublin'>{{ __('Europe/Dublin') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Gibraltar') value='Europe/Gibraltar'>{{ __('Europe/Gibraltar') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Guernsey') value='Europe/Guernsey'>{{ __('Europe/Guernsey') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Helsinki') value='Europe/Helsinki'>{{ __('Europe/Helsinki') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Isle_of_Man') value='Europe/Isle_of_Man'>{{ __('Europe/Isle_of_Man') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Istanbul') value='Europe/Istanbul'>{{ __('Europe/Istanbul') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Jersey') value='Europe/Jersey'>{{ __('Europe/Jersey') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Kaliningrad') value='Europe/Kaliningrad'>{{ __('Europe/Kaliningrad') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Kiev') value='Europe/Kiev'>{{ __('Europe/Kiev') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Kirov') value='Europe/Kirov'>{{ __('Europe/Kirov') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Lisbon') value='Europe/Lisbon'>{{ __('Europe/Lisbon') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Ljubljana') value='Europe/Ljubljana'>{{ __('Europe/Ljubljana') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/London') value='Europe/London'>{{ __('Europe/London') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Luxembourg') value='Europe/Luxembourg'>{{ __('Europe/Luxembourg') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Madrid') value='Europe/Madrid'>{{ __('Europe/Madrid') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Malta') value='Europe/Malta'>{{ __('Europe/Malta') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Mariehamn') value='Europe/Mariehamn'>{{ __('Europe/Mariehamn') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Minsk') value='Europe/Minsk'>{{ __('Europe/Minsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Monaco') value='Europe/Monaco'>{{ __('Europe/Monaco') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Moscow') value='Europe/Moscow'>{{ __('Europe/Moscow') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Oslo') value='Europe/Oslo'>{{ __('Europe/Oslo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Paris') value='Europe/Paris'>{{ __('Europe/Paris') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Podgorica') value='Europe/Podgorica'>{{ __('Europe/Podgorica') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Prague') value='Europe/Prague'>{{ __('Europe/Prague') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Riga') value='Europe/Riga'>{{ __('Europe/Riga') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Rome') value='Europe/Rome'>{{ __('Europe/Rome') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Samara') value='Europe/Samara'>{{ __('Europe/Samara') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/San_Marino') value='Europe/San_Marino'>{{ __('Europe/San_Marino') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Sarajevo') value='Europe/Sarajevo'>{{ __('Europe/Sarajevo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Saratov') value='Europe/Saratov'>{{ __('Europe/Saratov') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Simferopol') value='Europe/Simferopol'>{{ __('Europe/Simferopol') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Skopje') value='Europe/Skopje'>{{ __('Europe/Skopje') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Sofia') value='Europe/Sofia'>{{ __('Europe/Sofia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Stockholm') value='Europe/Stockholm'>{{ __('Europe/Stockholm') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Tallinn') value='Europe/Tallinn'>{{ __('Europe/Tallinn') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Tirane') value='Europe/Tirane'>{{ __('Europe/Tirane') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Ulyanovsk') value='Europe/Ulyanovsk'>{{ __('Europe/Ulyanovsk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Uzhgorod') value='Europe/Uzhgorod'>{{ __('Europe/Uzhgorod') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Vaduz') value='Europe/Vaduz'>{{ __('Europe/Vaduz') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Vatican') value='Europe/Vatican'>{{ __('Europe/Vatican') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Vienna') value='Europe/Vienna'>{{ __('Europe/Vienna') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Vilnius') value='Europe/Vilnius'>{{ __('Europe/Vilnius') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Volgograd') value='Europe/Volgograd'>{{ __('Europe/Volgograd') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Warsaw') value='Europe/Warsaw'>{{ __('Europe/Warsaw') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Zagreb') value='Europe/Zagreb'>{{ __('Europe/Zagreb') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Zaporozhye') value='Europe/Zaporozhye'>{{ __('Europe/Zaporozhye') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Europe/Zurich') value='Europe/Zurich'>{{ __('Europe/Zurich') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Antananarivo') value='Indian/Antananarivo'>{{ __('Indian/Antananarivo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Chagos') value='Indian/Chagos'>{{ __('Indian/Chagos') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Christmas') value='Indian/Christmas'>{{ __('Indian/Christmas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Cocos') value='Indian/Cocos'>{{ __('Indian/Cocos') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Comoro') value='Indian/Comoro'>{{ __('Indian/Comoro') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Kerguelen') value='Indian/Kerguelen'>{{ __('Indian/Kerguelen') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Mahe') value='Indian/Mahe'>{{ __('Indian/Mahe') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Maldives') value='Indian/Maldives'>{{ __('Indian/Maldives') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Mauritius') value='Indian/Mauritius'>{{ __('Indian/Mauritius') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Mayotte') value='Indian/Mayotte'>{{ __('Indian/Mayotte') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Indian/Reunion') value='Indian/Reunion'>{{ __('Indian/Reunion') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Apia') value='Pacific/Apia'>{{ __('Pacific/Apia') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Auckland') value='Pacific/Auckland'>{{ __('Pacific/Auckland') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Bougainville') value='Pacific/Bougainville'>{{ __('Pacific/Bougainville') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Chatham') value='Pacific/Chatham'>{{ __('Pacific/Chatham') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Chuuk') value='Pacific/Chuuk'>{{ __('Pacific/Chuuk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Easter') value='Pacific/Easter'>{{ __('Pacific/Easter') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Efate') value='Pacific/Efate'>{{ __('Pacific/Efate') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Enderbury') value='Pacific/Enderbury'>{{ __('Pacific/Enderbury') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Fakaofo') value='Pacific/Fakaofo'>{{ __('Pacific/Fakaofo') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Fiji') value='Pacific/Fiji'>{{ __('Pacific/Fiji') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Funafuti') value='Pacific/Funafuti'>{{ __('Pacific/Funafuti') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Galapagos') value='Pacific/Galapagos'>{{ __('Pacific/Galapagos') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Gambier') value='Pacific/Gambier'>{{ __('Pacific/Gambier') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Guadalcanal') value='Pacific/Guadalcanal'>{{ __('Pacific/Guadalcanal') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Guam') value='Pacific/Guam'>{{ __('Pacific/Guam') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Honolulu') value='Pacific/Honolulu'>{{ __('Pacific/Honolulu') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Kiritimati') value='Pacific/Kiritimati'>{{ __('Pacific/Kiritimati') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Kosrae') value='Pacific/Kosrae'>{{ __('Pacific/Kosrae') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Kwajalein') value='Pacific/Kwajalein'>{{ __('Pacific/Kwajalein') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Majuro') value='Pacific/Majuro'>{{ __('Pacific/Majuro') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Marquesas') value='Pacific/Marquesas'>{{ __('Pacific/Marquesas') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Midway') value='Pacific/Midway'>{{ __('Pacific/Midway') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Nauru') value='Pacific/Nauru'>{{ __('Pacific/Nauru') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Niue') value='Pacific/Niue'>{{ __('Pacific/Niue') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Norfolk') value='Pacific/Norfolk'>{{ __('Pacific/Norfolk') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Noumea') value='Pacific/Noumea'>{{ __('Pacific/Noumea') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Pago_Pago') value='Pacific/Pago_Pago'>{{ __('Pacific/Pago_Pago') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Palau') value='Pacific/Palau'>{{ __('Pacific/Palau') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Pitcairn') value='Pacific/Pitcairn'>{{ __('Pacific/Pitcairn') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Pohnpei') value='Pacific/Pohnpei'>{{ __('Pacific/Pohnpei') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Port_Moresby') value='Pacific/Port_Moresby'>{{ __('Pacific/Port_Moresby') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Rarotonga') value='Pacific/Rarotonga'>{{ __('Pacific/Rarotonga') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Saipan') value='Pacific/Saipan'>{{ __('Pacific/Saipan') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Tahiti') value='Pacific/Tahiti'>{{ __('Pacific/Tahiti') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Tarawa') value='Pacific/Tarawa'>{{ __('Pacific/Tarawa') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Tongatapu') value='Pacific/Tongatapu'>{{ __('Pacific/Tongatapu') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Wake') value='Pacific/Wake'>{{ __('Pacific/Wake') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'Pacific/Wallis') value='Pacific/Wallis'>{{ __('Pacific/Wallis') }}</option>
                                                                <option @selected(env('TIMEZONE') == 'UTC') value='UTC'>{{ __('UTC') }}</option>
                                                            </select>
                                                        <span></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="button-group text-center mt-4">
                                                                <button class="theme-btn m-2 submit-btn">{{ __('Update') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            </div>
            </div>
        </div>
    </div>
</div>
@endsection
