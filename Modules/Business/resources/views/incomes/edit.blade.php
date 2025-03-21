<div class="modal fade" id="incomes-edit-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">{{ __('Edit Income') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="personal-info">
                    <form action="" method="post" enctype="multipart/form-data"
                        class="ajaxform_instant_reload incomeUpdateForm">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Amount') }}</label>
                                <input type="number" name="amount" id="inc_price" required class="form-control" placeholder="{{ __('Enter amount') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="custom-top-label">{{ __('Category') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select class="form-control form-selected" id="income_categoryId" name="income_category_id" required>
                                        <option value="">{{ __('Select A Category') }}</option>
                                        @foreach ($income_categories as $income_category)
                                        <option value="{{ $income_category->id }}">{{ $income_category->categoryName }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Income For') }}</label>
                                <input type="text" name="incomeFor" id="inc_for" class="form-control" placeholder="{{ __('Enter income for') }}">
                            </div>
                            <div class="col-lg-6">
                                <label class="custom-top-label">{{ __('Payment Type') }}</label>
                                <div class="gpt-up-down-arrow position-relative">
                                    <select class="form-control form-selected" id="inc_paymentType" name="payment_type_id" required>
                                        <option value="">{{ __('Select a payment type') }}</option>
                                        @foreach($payment_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Reference Number') }}</label>
                                <input type="text" name="referenceNo" id="incomeReferenceNo" class="form-control" placeholder="{{ __('Enter reference number') }}">
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Income Date') }}</label>
                                <input type="date" name="incomeDate" id="inc_date_update" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label>{{__('Note')}}</label>
                                <textarea name="note" id="inc_note" class="form-control" placeholder="{{ __('Enter note') }}"></textarea>
                            </div>
                         </div>

                        <div class="col-lg-12">
                            <div class="button-group text-center mt-5">
                                <a href="{{ route('business.incomes.index') }}" class="theme-btn border-btn m-2">{{ __('Cancel') }}</a>
                                <button class="theme-btn m-2 submit-btn">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
