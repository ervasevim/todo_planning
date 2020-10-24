<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm">
                <h2>Tüm Veriler </h2>
            </div>
            <div class="col-sm d-flex justify-content-end">
                <button onclick="window.location='{{ route('create-planning') }}'" type="button" class="btn btn-info">Görev Listesini Oluştur</button>
            </div>

        </div>
    </div>

    <div class="p-5">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Görev Adı</th>
                <th scope="col">Süre</th>
                <th scope="col">Zorluk</th>
            </tr>
            </thead>
            <tbody>

            @foreach($tasks as $task)
                <tr>
                    <th scope="row">{{$task->id}}</th>
                    <td>{{$task->task_id}}</td>
                    <td>{{$task->duration}}</td>
                    <td>{{$task->level}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

</body>
</html>

