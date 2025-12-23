<footer class="py-4 mt-auto bg-white border-top shadow-sm">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start">
                    <p class="text-muted mb-0 small">
                        &copy; <?php echo date('Y'); ?> <strong>Connect & Converse</strong> - University Discussion Hub
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted small">Built for Students <i class="fas fa-heart text-danger ms-1"></i></span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Tooltip initialization (if needed)
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>