@extends('layouts.auth.app')

@section('title', __('Login'))

@section('main_content')
<div style="display: flex; height: 100vh; font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #1d366f, #17316b); overflow: hidden;">
    <!-- Onboarding Left Side -->
    <div style="flex: 1; background: #f5f7fb; padding: 40px; display: flex; flex-direction: column; justify-content: space-between; border-radius: 20px 0 0 20px; position: relative;">
        <!-- Logo -->
        <div>
            <img src="{{ asset(get_option('general')['login_page_logo'] ?? '') }}" alt="Logo" style="height: 40px;">
        </div>

        <!-- Slides -->
        <div id="onboarding-wrapper" style="flex-grow: 1; display: flex; align-items: center; justify-content: center;">
            <div class="onboarding-slide active" style="text-align: center;">
                <img src="{{ asset('assets/images/onboarding/step1.png') }}" style="max-height: 220px;" alt="Step 1">
                <blockquote style="font-style: italic; color: #555; margin-top: 20px;">
                    “Cách tốt nhất để dự đoán tương lai là tạo ra nó.”
                </blockquote>
                <div style="font-weight: bold; color: #333;">Peter Drucker</div>
            </div>
            <div class="onboarding-slide" style="text-align: center; display: none;">
                <img src="{{ asset('assets/images/onboarding/step2.png') }}" style="max-height: 220px;" alt="Step 2">
                <blockquote style="font-style: italic; color: #555; margin-top: 20px;">
                    “Thành công không phải là điểm đến, mà là hành trình.”
                </blockquote>
                <div style="font-weight: bold; color: #333;">Zig Ziglar</div>
            </div>
            <div class="onboarding-slide" style="text-align: center; display: none;">
                <img src="{{ asset('assets/images/onboarding/step3.png') }}" style="max-height: 220px;" alt="Step 3">
                <blockquote style="font-style: italic; color: #555; margin-top: 20px;">
                    “Khách hàng là trung tâm của mọi quyết định.”
                </blockquote>
                <div style="font-weight: bold; color: #333;">Jeff Bezos</div>
            </div>
        </div>

        <!-- Navigation Dots -->
        <div style="text-align: center; margin-top: 10px;">
            <span class="onboarding-dot active" style="height: 6px; width: 6px; margin: 3px; background: #555; border-radius: 50%; display: inline-block;"></span>
            <span class="onboarding-dot" style="height: 6px; width: 6px; margin: 3px; background: #ccc; border-radius: 50%; display: inline-block;"></span>
            <span class="onboarding-dot" style="height: 6px; width: 6px; margin: 3px; background: #ccc; border-radius: 50%; display: inline-block;"></span>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 12px; color: #777;">
            © {{ date('Y') }} Getfly CRM JSC. All rights reserved. <br>
            Hệ thống hoạt động tốt nhất trên trình duyệt Firefox và Chrome.
        </div>
    </div>

    <!-- Login Form Right Side -->
    <div style="flex: 1; background: white; padding: 50px 40px; display: flex; align-items: center; justify-content: center; border-radius: 0 20px 20px 0; position: relative;">
        <div style="width: 100%; max-width: 400px;">
            <div style="position: absolute; top: 20px; right: 30px;">
                <img src="{{ asset('assets/images/flags/vn.png') }}" alt="Language" style="width: 24px; height: 24px;">
            </div>
            <h3 style="font-weight: bold; color: #153e90;">{{ __('Getfly xin chào') }}</h3>
            <p style="margin-bottom: 25px;">Truy cập bằng tài khoản được cung cấp</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <input type="email" name="email" class="form-control" placeholder="Tên đăng nhập" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <label>
                        <input type="checkbox" name="remember"> Nhớ mật khẩu
                    </label>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="background: #f26522; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    ĐĂNG NHẬP
                </button>
                <div style="margin-top: 15px; text-align: center;">
                    <a href="{{ route('password.request') }}" style="color: #888;">Quên mật khẩu?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.onboarding-slide');
    const dots = document.querySelectorAll('.onboarding-dot');
    let current = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
            dots[i].style.background = i === index ? '#555' : '#ccc';
            dots[i].classList.toggle('active', i === index);
        });
    }

    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 4000);

    showSlide(current);
});
</script>
@endpush

@push('js')
<script src="{{ asset('assets/js/auth.js') }}"></script>
<script>
document.querySelector('.login_form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.otp_required) {
                // Trigger the OTP modal
                const otpModal = new bootstrap.Modal(document.getElementById('verifymodal'));
                otpModal.show();

                // Update the email in the modal
                document.getElementById('dynamicEmail').textContent = formData.get('email');

                // Start the countdown timer
                startCountdown();
            } else if (data.redirect) {
                // Redirect if no OTP is required
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});

// Countdown Timer for OTP Resend
let countdownElement = document.getElementById('countdown');
let countdownTime = 60; // 60 seconds

function startCountdown() {
    countdownTime = 60; // Reset countdown time
    const interval = setInterval(() => {
        if (countdownTime <= 0) {
            clearInterval(interval);
            countdownElement.textContent = '';
            document.getElementById('otp-resend').classList.remove('disabled');
        } else {
            countdownElement.textContent = `${countdownTime--}s`;
            document.getElementById('otp-resend').classList.add('disabled');
        }
    }, 1000);
}

// Resend OTP Logic
document.getElementById('otp-resend').addEventListener('click', function () {
    const route = this.getAttribute('data-route');

    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            email: document.getElementById('dynamicEmail').textContent,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            startCountdown(); // Restart the countdown timer
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});

// OTP Verification Logic
document.querySelector('.verify_form').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.redirect) {
                // Dismiss the OTP modal
                const otpModal = bootstrap.Modal.getInstance(document.getElementById('verifymodal'));
                otpModal.hide();

                // Redirect to the dashboard
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
        });
});

(function() {
    const slides = document.querySelectorAll('.onboarding-slide');
    const dots = document.querySelectorAll('.onboarding-dot');
    let current = 0;
    function showSlide(idx) {
        slides.forEach((slide, i) => {
            slide.style.display = i === idx ? 'flex' : 'none';
            if (i === idx) slide.classList.add('active');
            else slide.classList.remove('active');
        });
        dots.forEach((dot, i) => {
            dot.style.backgroundColor = i === idx ? '#007bff' : '#ccc';
            if (i === idx) dot.classList.add('active');
            else dot.classList.remove('active');
        });
    }
    document.getElementById('onboarding-prev').onclick = function() {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    };
    document.getElementById('onboarding-next').onclick = function() {
        current = (current + 1) % slides.length;
        showSlide(current);
    };
    dots.forEach((dot, i) => {
        dot.onclick = function() {
            current = i;
            showSlide(current);
        };
    });
    showSlide(current);
})();
</script>
@endpush



