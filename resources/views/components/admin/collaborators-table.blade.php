<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">nume</th>
                <th scope="col">Scurta Descriere</th>
                <th scope="col">Email</th>
                <th scope="col">Telefon</th>
                <th scope="col">Actualizat la</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collaborators as $index => $collaborator)
                <tr>
                    <td>{{ $collaborators->firstItem() + $index }}</td>
                    <td>{{ $collaborator->name }}</td>
                    <td
                        style="max-width: 600px; /* Set the max width you desire */
    overflow: hidden; /* Prevents overflow of text */
    text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $collaborator->short_description !!}
                        </div>
                    </td>
                    <td>{{ isset($collaborator->email) ? $collaborator->email : 'No email set..' }}</td>
                    <td>{{ isset($collaborator->phone_number) ? $collaborator->phone_number : 'No phone number set..' }}
                    </td>
                    <td>{{ $collaborator->updated_at }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.collaborators.edit', $collaborator->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.collaborators.destroy', $collaborator->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this collaborator?');">
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
        {{ $collaborators->links() }}
    </div>

</div>
