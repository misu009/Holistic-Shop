<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $modalId }}Label">{{ $title }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalId = @json(old('modalId'));
            const myModalElement = document.getElementById(modalId);
            if (myModalElement && window.bootstrap) {
                const myModal = new bootstrap.Modal(myModalElement);
                myModal.show();
            } else {
                console.error("Modal element not found or Bootstrap not loaded:", modalId);
            }
        });
    </script>
@endif
