<footer class="business-footer container-fluid d-flex align-items-center justify-content-center justify-content-sm-between flex-wrap py-3 ms-0 bg-white d-print-none">
    <p class="mb-0 me-3"> {{ get_option('general')['copy_right'] ?? '' }}</p>
    <p class="mb-0">{{ get_option('general')['admin_footer_text'] ?? '' }}: ❤️ <a class="footer-acn" href="{{ get_option('general')['admin_footer_link'] ?? '' }}" target="_blank">{{ get_option('general')['admin_footer_link_text'] ?? '' }}</a></p>
</footer>
