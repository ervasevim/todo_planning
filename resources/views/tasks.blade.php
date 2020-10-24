<!DOCTYPE html>
<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<body>

    <div class="ml-5 mt-4">
        <h5 style="color: darkslategray;">Tüm Görevlerin Toplam {{count($weeks)}} Haftada Bitmesi Planlanmıştır.</h5>
    </div>
    @foreach($weeks as $ind => $week)
        <div class=" ml-5 mt-5">
            <h2 style="color: midnightblue;">{{$ind+1}}. Hafta</h2>
        </div>
        <div class="p-5">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Ad</th>
                    <th scope="col">Toplam Süre</th>
                    <th scope="col">Görevler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($week as $ind => $dev)
                    <tr>
                        <th scope="row">{{$ind}}</th>
                        <td>{{round($dev['time'],2)}}</td>

                        <td>
                        @foreach($dev['tasks'] as $task)

                            <li>{{$task}}</li>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</body>
</html>

