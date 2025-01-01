<div>
    <p>Edit current media</p>
    @if ($media->isEmpty())
        <p class="text-warning"><i>No media uploaded yet..</i></p>
    @endif
    <div class="row">
        @foreach ($media as $item)
            <div class="col-2 mb-3 mr-1 ">
                <div>
                    @php
                        // Get the file extension or mime type
                        $fileExtension = pathinfo($item->path, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isVideo = in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'wmv']);
                    @endphp

                    @if ($isImage)
                        <img src="{{ Storage::url($item->path) }}" alt="image not found" class="img-thumbnail"
                            style="height: 100px; width: 100%;">
                    @elseif ($isVideo)
                        <video controls class="img-thumbnail" style="height: 100px; width: 100%;">
                            <source src="{{ Storage::url($item->path) }}" type="video/{{ $fileExtension }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <p>Unsupported media type: {{ $fileExtension }}</p>
                    @endif


                </div>
                <form action="{{ route($route . 'update', [$objectName => $objectId, 'imageId' => $item->id]) }}"
                    method="POST" class="mt-1">
                    @csrf
                    @method('PUT')
                    <input class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" type="number"
                        min="1" max="10000" id="order" name="order"
                        value="{{ old('order', $item->order) }}">
                    <button type="submit" class="btn btn-warning w-100">Change order</button>
                </form>
                <form action="{{ route($route . 'destroy', [$objectName => $objectId, 'imageId' => $item->id]) }}"
                    method="POST" class="mt-0" onclick="return confirm('Are you sure you delete this image?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete Image</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
