<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Added by</th>
                <th scope="col">Categories</th>
                <th scope="col">Description</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $products->firstItem() + $index }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->user->name }}</td>
                    <td style="max-width: 600px; overflow: hidden;text-overflow: ellipsis">
                        @if ($product->categories->count() == 0)
                            <div class="d-flex justify-content-center">
                                <span class="badge badge-warning">No categories yet..</span>
                            </div>
                        @endif
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            @foreach ($product->categories as $category)
                                <ol>{{ $category->name }}</ol>
                            @endforeach
                        </div>
                    </td>
                    <td
                        style="max-width: 600px; /* Set the max width you desire */
    overflow: hidden; /* Prevents overflow of text */
    text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $product->description !!}
                        </div>
                    </td>
                    <td>{{ $product->updated_at }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.products.edit', $product->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links() }}
    </div>

</div>
