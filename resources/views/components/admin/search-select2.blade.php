<form action="{{ route($route) }}" method="GET">
    <div class="d-flex">
        @if ($searchFilter)
            <select required id="search-option" name="search-option">
                @foreach ($searchFilter as $filter)
                    <option value="{{ $filter['value'] }}" @if (isset($searchOption) && $searchOption == $filter['value']) selected @endif>
                        {{ $filter['option'] }}</option>
                @endforeach
            </select>
        @endif
        <select class="form-control select2" name="id-class" id="id-class" required>
            <option value=""></option>
            @foreach ($searchItems as $item)
                <option value="{{ $item->id . ' ' . $item->class }}" @if (isset($searchRecord) && $searchRecord == $item->id . ' ' . $item->class) selected @endif>
                    {{ $item->name }}</option>
            @endforeach
        </select>
        <button type="submit" class=""
            style="background-color: #0d6efd; color: white; border-color: #0d6efd; border-style: solid; border-radius: 20%;">Search</button>
    </div>
</form>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        $('#search-option').change(function() {
            const ajaxRoute = @json($ajaxRoute);
            const searchItems = $(this).val();
            $.ajax({
                url: ajaxRoute,
                method: 'POST',
                data: {
                    'search-option': searchItems,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#id-class').empty();
                    $('#id-class').append('<option value=""></option>');
                    $.each(response.searchItems, function(index, item) {
                        $('#id-class').append('<option value="' + item.id + ' ' +
                            item.class + '">' +
                            item.name + '</option>');
                    });
                },
                error: function() {
                    alert('Error fetching items');
                }
            });
        });
    });
</script>
