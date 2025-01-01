<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Description</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Image</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $categories->firstItem() + $index }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $category->description !!}
                        </div>
                    </td>
                    <td>{{ $category->updated_at }}</td>
                    <td> <img src="{{ Storage::url($category->picture) }}" alt="No img.." height="100px" width="100px">
                    </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.blog-categories.edit', $category->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.blog-categories.destroy', $category->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this category?');">
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
        {{ $categories->links() }}
    </div>

</div>
