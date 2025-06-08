<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered text-center align-middle">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nume</th>
                <th scope="col">Descriere</th>
                <th scope="col">Colaboratori principali</th>
                <th scope="col">Colaboratori secundari</th>
                <th scope="col">Pret</th>
                <th scope="col">Disponibilitate</th>
                <th scope="col">Actiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $index => $service)
                <tr>
                    <td>{{ $services->firstItem() + $index }}</td>
                    <td>{{ $service->name }}</td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            {!! $service->description !!}
                        </div>
                    </td>
                    <td style="max-width: 600px; overflow: hidden; text-overflow: ellipsis">
                        <div style="max-height: 100px; overflow: auto;display: block;">
                            @php
                                $primaryCollaborators = $service->primaryCollaborators;
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
                                $nonPrimaryCollaborators = $service->nonPrimaryCollaborators;
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
                    <td> {{ $service->price }} </td>
                    <td> {{ $service->disabled == 1 ? '🚫' : '✅' }} </td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <form class="m-1" action="{{ route('admin.services.edit', $service->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Edit</button>
                            </form>
                            <form class="m-1" action="{{ route('admin.services.destroy', $service->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this service?');">
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
        {{ $services->links() }}
    </div>

</div>
