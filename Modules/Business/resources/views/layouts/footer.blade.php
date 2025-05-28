<footer class="container-fluid d-flex flex-column flex-sm-row align-items-center justify-content-center flex-wrap py-4 px-3 bg-light border-top shadow-sm sticky-footer">
    <div class="d-flex align-items-center justify-content-center mb-2 mb-sm-0 w-100 w-sm-auto">
        <img src="{{ url($footer_logo ?? 'assets/images/logo/backend_logo.png') }}" alt="Logo" height="28" class="me-2 rounded-circle bg-white border">
        <span class="text-muted small">&copy; {{ date('Y') }} {{ get_option('general')['copy_right'] ?? '' }}</span>
    </div>
    <div class="d-flex align-items-center justify-content-center w-100 w-sm-auto mt-2 mt-sm-0">
        <span class="text-muted small me-2">{{ get_option('general')['admin_footer_text'] ?? '' }}</span>
        <span class="mx-1">|</span>
        <a class="footer-acn text-decoration-none fw-semibold" href="{{ get_option('general')['admin_footer_link'] ?? '' }}" target="_blank">
            <i class="ri-external-link-line align-middle"></i> {{ get_option('general')['admin_footer_link_text'] ?? '' }}
        </a>
        <span class="mx-2">|</span>
        <span class="text-danger small">&#10084;&#65039;</span>
    </div>
</footer>
<style>
.sticky-footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  z-index: 1030;
}
body { padding-bottom: 80px; }
</style>
