<img id="{{ $imagePreviewId }}" src="{{ $path }}" alt="Click to select an image" height="200px" width="200px">
<input type="file" id="{{ $imageInputId }}" name="{{ $imageInputName }}" class="hidden-file-input" accept="image/*">
<button type="button" class="btn btn-warning"
    onclick="uploadImageCanvas('{{ $imageInputId }}', '{{ $imagePreviewId }}')">
    {{ $buttonText }}
</button>
