document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function(form) {
        const promoInput = form.querySelector('input[name="promo_code"]');
        if (!promoInput) return;
        const payableRow = form.querySelector('th:contains("Payable Amount")')?.parentElement;
        const submitBtn = form.querySelector('button[type="submit"]');
        let promoMsg = null;
        let lastCode = '';

        // Insert a message area for promo feedback
        if (payableRow) {
            promoMsg = document.createElement('div');
            promoMsg.className = 'promo-feedback mt-2';
            payableRow.appendChild(promoMsg);
        }

        promoInput.addEventListener('blur', function() {
            const code = promoInput.value.trim();
            if (!code || code === lastCode) return;
            lastCode = code;
            promoMsg.textContent = 'Checking promo code...';
            promoMsg.classList.remove('text-success', 'text-danger');
            fetch('/api/promo/validate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code: code,
                    plan_id: form.action.match(/plan_id=(\d+)/)?.[1] || ''
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.valid) {
                    promoMsg.textContent = `Promo applied! Discount: ${data.discount_display}`;
                    promoMsg.classList.add('text-success');
                    // Optionally update payable amount visually
                    const payableCell = payableRow?.querySelector('td.fw-bold');
                    if (payableCell && data.new_amount_display) {
                        payableCell.textContent = data.new_amount_display;
                    }
                } else {
                    promoMsg.textContent = data.message || 'Invalid promo code.';
                    promoMsg.classList.add('text-danger');
                }
            })
            .catch(() => {
                promoMsg.textContent = 'Error validating promo code.';
                promoMsg.classList.add('text-danger');
            });
        });
    });
});
