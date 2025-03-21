<section class="terms-policy-section">
    <div class="container">
      <h2>{{ $term_condition->value['term_title'] ?? ''}}</h2>
      <div>
        <div>
            <p>{{ $term_condition->value['description_one'] ?? ''}}</p>
        </div>
        <div class="mt-3">
           <p>{{ $term_condition->value['description_two'] ?? ''}}</p>
        </div>
      </div>
    </div>
</section>
