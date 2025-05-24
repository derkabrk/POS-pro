<section class="terms-policy-section py-5 bg-light bg-opacity-50">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold custom-clr-dark">{{ $term_condition->value['term_title'] ?? ''}}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                    <div class="mb-3">
                        <p class="text-secondary mb-0">{{ $term_condition->value['description_one'] ?? ''}}</p>
                    </div>
                    <div class="mt-3">
                        <p class="text-secondary mb-0">{{ $term_condition->value['description_two'] ?? ''}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
