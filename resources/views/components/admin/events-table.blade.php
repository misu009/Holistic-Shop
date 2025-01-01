<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Available between</th>
                <th scope="col">Primary Collaboratos</th>
                <th scope="col">Collaboratos</th>
                <th scope="col">Price</th>
                <th scope="col">Availabilty</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $index => $event)
                <tr>
                    <td>{{ $events->firstItem() + $index }}</td>
                    <td>{{ $event->name }}</td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $event->description !!}
                        </div>
                    </td>
                    <td>{{ 'Incepe la: ' . $event->starts_at . 'Se termina la: ' . $event->ends_at }}</td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            @php
                                $primaryCollaborators = $event->primaryCollaborators;
                                $count = $primaryCollaborators->count();
                            @endphp
                            @foreach ($primaryCollaborators as $index => $collaborator)
                                {!! $collaborator->name . ($index != $count - 1 ? ', <br>' : '') !!}
                            @endforeach
                        </div>
                    </td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto; ">
                            @php
                                $nonPrimaryCollaborators = $event->nonPrimaryCollaborators;
                                $count = $nonPrimaryCollaborators->count();
                            @endphp
                            @if ($count == 0)
                                <strong>no non-primary collaborators:</strong>
                            @endif
                            @foreach ($nonPrimaryCollaborators as $index => $collaborator)
                                {!! $collaborator->name . ($index != $count - 1 ? ', <br>' : '') !!}
                            @endforeach
                        </div>
                    </td>
                    <td> {{ $event->price }} </td>
                    <td> {{ $event->disabled == 1 ? '🚫' : '✅' }} </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.events.edit', $event->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this event?');">
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
        {{ $events->links() }}
    </div>

</div>
