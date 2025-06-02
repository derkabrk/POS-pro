<!-- start plan -->
<section class="section bg-light" id="plans">
    <div class="bg-overlay bg-overlay-pattern"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h3 class="mb-3 fw-semibold">{{ $page_data['headings']['pricing_title'] ?? '' }}</h3>
                    <p class="text-muted mb-4 ff-secondary">{{ $page_data['headings']['pricing_description'] ?? '' }}</p>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row gy-4 justify-content-center">
            @foreach ($plans as $index => $plan)
                <div class="col-lg-4">
                    <div class="card plan-box mb-0 {{ $index == 1 ? 'ribbon-box right' : '' }}">
                        <div class="card-body p-4 m-2">
                            @if($index == 1)
                                <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                            @endif
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold">{{ $plan['subscriptionName'] ?? 'Plan Name' }}</h5>
                                    <p class="text-muted mb-0">{{ $plan['duration'] . ' Days' ?? 'Plan Duration' }}</p>
                                </div>
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light rounded-circle text-primary">
                                        @if($index == 0)
                                            <i class="ri-book-mark-line fs-20"></i>
                                        @elseif($index == 1)
                                            <i class="ri-medal-fill fs-20"></i>
                                        @else
                                            <i class="ri-stack-fill fs-20"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 text-center">
                                <h1>
                                    @if (($plan['offerPrice'] && $plan['subscriptionPrice'] !== null) || $plan['offerPrice'] || $plan['subscriptionPrice'])
                                        @if ($plan['offerPrice'])
                                            <span class="ff-secondary fw-bold fs-1">{{ currency_format($plan['offerPrice']) }}</span>
                                        @else
                                            <span class="ff-secondary fw-bold fs-1">{{ currency_format($plan['subscriptionPrice']) }}</span>
                                        @endif
                                    @else
                                        @if ($plan['offerPrice'] || $plan['subscriptionPrice'])
                                            <span class="ff-secondary fw-bold fs-1">{{ currency_format($plan['offerPrice'] ?? $plan['subscriptionPrice']) }}</span>
                                        @else
                                            <span class="ff-secondary fw-bold fs-1">{{ __('Free') }}</span>
                                        @endif
                                    @endif
                                    <span class="fs-13 text-muted">/{{ $plan['duration'] . ' Days' }}</span>
                                </h1>
                            </div>

                            <div>
                                <p class="fw-semibold mb-3 text-center">{{ __('Features Of Plan') }}</p>
                                <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                    @foreach ($plan['features'] ?? [] as $key => $item)
                                        <li>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-1">
                                                    @if(isset($item[1]))
                                                        <i class="ri-checkbox-circle-fill fs-15 align-middle text-success"></i>
                                                    @else
                                                        <i class="ri-close-circle-fill fs-15 align-middle text-danger"></i>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $item[0] ?? '' }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-4">
                                    <a href="javascript:void(0);" 
                                       class="btn btn-soft-primary w-100 subscribe-plan" 
                                       data-bs-target="#registration-modal" 
                                       data-bs-toggle="modal">
                                        {{ __("Buy Now") }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            @endforeach
        </div>
        <!--end row-->
    </div>
    <!-- end container -->
</section>
<!-- end plan -->

<input type="hidden" value="{{ route('get-business-categories') }}" id="get-business-categories">