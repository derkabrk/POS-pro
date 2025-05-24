{{-- Footer Code Start --}}
<footer class="footer-section py-4 bg-dark text-white">
    <div class="container">
        <div class="row mt-5 gy-4">
            <div class="col-md-6 col-lg-5">
                <a href="{{ route('home') }}">
                    <img src="{{ asset($general->value['footer_logo'] ?? '') }}" alt="footer-logo" class="footer-logo mb-3" />
                </a>
                <p class="mb-3 small opacity-75">
                    {{ $page_data['headings']['footer_short_title'] ?? '' }}
                </p>
                @if (!empty($page_data['footer_scanner_image']))
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset($page_data['footer_scanner_image'] ?? '') }}" alt="" class="rounded-2 shadow-sm bg-white p-1" style="width: 48px; height: 48px; object-fit: contain;" />
                    <span class="small opacity-75">{{ $page_data['headings']['footer_scanner_title'] ?? '' }}</span>
                </div>
                @endif
                <div class="d-flex gap-2 mb-3">
                    @if (!empty($page_data['footer_google_app_image']))
                        <a href="{{ $page_data['headings']['footer_google_play_app_link'] ?? '' }}" target="_blank">
                            <img src="{{ asset($page_data['footer_google_app_image']) }}" alt="Google Play App" class="rounded-2 shadow-sm" style="max-width: 100px;" />
                        </a>
                    @endif
                    @if (!empty($page_data['footer_apple_app_image']))
                        <a href="{{ $page_data['headings']['footer_apple_app_link'] ?? '' }}" target="_blank">
                            <img src="{{ asset($page_data['footer_apple_app_image']) }}" alt="Apple App Store" class="rounded-2 shadow-sm" style="max-width: 100px;" />
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <h6 class="mb-4 mt-4 mt-md-0 text-uppercase fw-bold text-white">{{ $page_data['headings']['middle_footer_title'] ?? '' }}</h6>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled mb-0">
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_one'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_one'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_two'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_two'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_three'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_three'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_four'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_four'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_five'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_five'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['right_footer_link_six'] ?? '' }}" target="_blank">{{ $page_data['headings']['right_footer_six'] ?? '' }}</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled mb-0">
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_one'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_one'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_two'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_two'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_three'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_three'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_four'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_four'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_five'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_five'] ?? '' }}</a></li>
                            <li><a class="text-white-50 text-decoration-none" href="{{ $page_data['headings']['middle_footer_link_six'] ?? '' }}" target="_blank">{{ $page_data['headings']['middle_footer_six'] ?? '' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <h6 class="mb-4 text-uppercase fw-bold text-white">{{ $page_data['headings']['right_footer_title'] ?? '' }}</h6>
                <ul class="list-unstyled mb-3">
                    <li><a class="text-white-50 text-decoration-none" href="{{url($page_data['headings']['left_footer_link_one'] ?? '')}}" target="_blank">{{ $page_data['headings']['left_footer_one'] ?? '' }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{url($page_data['headings']['left_footer_link_two'] ?? '')}}" target="_blank">{{ $page_data['headings']['left_footer_two'] ?? '' }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{url($page_data['headings']['left_footer_link_three'] ?? '')}}" target="_blank">{{ $page_data['headings']['left_footer_three'] ?? '' }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{url($page_data['headings']['left_footer_link_four'] ?? '')}}" target="_blank">{{ $page_data['headings']['left_footer_four'] ?? '' }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{url($page_data['headings']['left_footer_link_five'] ?? '')}}" target="_blank">{{ $page_data['headings']['left_footer_five'] ?? '' }}</a></li>
                </ul>
                <ul class="list-inline mb-0">
                    @foreach ($page_data['headings']['footer_socials_links'] ?? [] as $key => $footer_socials_link)
                        <li class="list-inline-item me-2">
                            <a href="{{ url($footer_socials_link) }}" target="_blank" class="d-inline-block bg-white rounded-circle p-1 shadow-sm">
                                <img src="{{ asset($page_data['footer_socials_icons'][$key] ?? 'assets/img/demo-img.png') }}" alt="icon" style="width: 28px; height: 28px; object-fit: contain;" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <hr class="border-light opacity-25 my-4" />
        <div class="text-center">
            <p class="mb-0 small opacity-75">{{ $general->value['copy_right'] ?? '' }}</p>
        </div>
    </div>
</footer>
