<div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="category-search-modal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bolder" id="offcanvasRightLabel">{{ __('Category List') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="p-3 category-brand-scroll">
        <form action="" method="post" data-route="{{ route('business.purchases.category-filter') }}">
            @csrf
            <div class="position-relative">
                <input class="form-control mr-sm-2 p-2 category-search" type="text" name="search" placeholder="{{ __('Search') }}" aria-label="Search">
                <i class="fas fa-search search-icon"></i>
            </div>
        </form>

        <div class="category-container" id="category-data">
            @include('business::purchases.category-list')
        </div>
    </div>
</div>
