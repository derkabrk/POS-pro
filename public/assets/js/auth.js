"use strict";

$(".hide-pass").on("click", function () {
    var model = $("#auth").data("model");
    $(this).toggleClass("show-pass");

    // LOGIN
    if (model === "Login") {
        let passwordInput = $(".password");
        if (passwordInput.attr("type") === "password") {
            passwordInput.attr("type", "text");
        } else {
            passwordInput.attr("type", "password");
        }
    }
    // REGISTRATION & RESET PASSWORD
    else {
        let passwordInput = $(this).siblings("input");
        let passwordType = passwordInput.attr("type");
        if (passwordType === "password") {
            passwordInput.attr("type", "text");
        } else {
            passwordInput.attr("type", "password");
        }
    }
});

// Fill email and password fields
function fillup(email, password) {
    $(".email").val(email);
    $(".password").val(password);
}

// OTP countdown------------------->
let countdownInterval;
function startCountdown(timeLeft) {
    const countdownElement = $("#countdown");
    const resendButton = $("#otp-resend");

    // Function to format time as MM:SS
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${String(minutes).padStart(2, "0")}:${String(remainingSeconds).padStart(2, "0")}`;
    }

    // Clear any existing countdown interval
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }

    // Initialize countdown display
    countdownElement.text(formatTime(timeLeft));
    resendButton.addClass("disabled").attr("disabled", true); // Disable the button during countdown

    // Start the new countdown interval
    countdownInterval = setInterval(() => {
        timeLeft--;

        // Update the countdown text
        countdownElement.text(formatTime(timeLeft));

        // Stop the countdown when timeLeft reaches zero
        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            countdownElement.text("00:00");

            // Enable the resend button
            resendButton.removeClass("disabled").removeAttr("disabled");
        }
    }, 1000);
}

// Resend OTP
$('#otp-resend').on('click', function () {
    const resendButton = $(this);

    // Prevent action if the button is disabled
    if (resendButton.hasClass("disabled")) {
        return;
    }

    const route = resendButton.data("route");
    const originalText = resendButton.text();
    const email = $("#dynamicEmail").text();

    // Ensure email is available
    if (!email) {
        Notify("error", "Email is missing. Please try again.");
        return;
    }

    // Temporarily disable the button during the request
    resendButton.text("Sending...").addClass("disabled").attr("disabled", true);

    $.ajax({
        type: "POST",
        url: route,
        data: { email: email },
        dataType: "json",
        success: function (response) {
            resendButton.text(originalText).addClass("disabled").attr("disabled", true);
            startCountdown(response.otp_expiration);
        },
        error: function (e) {
            resendButton.text(originalText).removeClass("disabled").removeAttr("disabled");
        },
    });
});


