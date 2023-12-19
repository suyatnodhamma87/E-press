<ul class="action-button-list">
    <li>
        @if ($dataijin->status=="i")
        <a href="/ijintidakmasuk/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataijin->status=="s")
        <a href="/ijinsakit/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataijin->status=="c")
        <a href="/ijincuti/{{ $dataijin->kode_ijin }}/edit" class="btn btn-list text primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @endif
    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-bin-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>

<script>
    $(function() {
        $("#deletebutton").click(function(e) {
            $("#hapuspengajuan").attr('href', '/ijin/' + '{{ $dataijin->kode_ijin }}/delete');
        });
    });
</script>
