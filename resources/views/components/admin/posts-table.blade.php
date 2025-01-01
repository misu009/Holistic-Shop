<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Categories</th>
                <th scope="col">Description</th>
                <th scope="col">Created by</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $index => $post)
                <tr>
                    <td>{{ $posts->firstItem() + $index }}</td>
                    <td>{{ $post->title }}</td>
                    <td style="max-width: 600px; overflow: hidden;text-overflow: ellipsis">
                        @if ($post->categories->count() == 0)
                            <div class="d-flex justify-content-center">
                                <span class="badge badge-warning">No categories yet..</span>
                            </div>
                        @endif
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            @foreach ($post->categories as $category)
                                <ol>{{ $category->name }}</ol>
                            @endforeach
                        </div>
                    </td>
                    <td
                        style="max-width: 600px; /* Set the max width you desire */
    overflow: hidden; /* Prevents overflow of text */
    text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $post->description !!}
                        </div>
                    </td>
                    <td>{{ $post->created_by }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.posts.edit', $post->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this post?');">
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
        {{ $posts->links() }}
    </div>

</div>
