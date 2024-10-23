<table style="width:100%;font-size:80%">
    <tr>
        <th style="text-align:left; width:40%">Supplier</th>
        <th style="text-align:center; width:20%">Last Week</th>
        <th style="text-align:center;width:20%">This Week</th>
        <th style="text-align:center;">Change</th>
    </tr>
    @foreach($data as $d)
        <tr>
            <td style="text-align:left;">{{$d[0]}}</td>
            <td style="text-align:center">{{$d[1]}}%</td>
            <td style="text-align:center">{{$d[2]}}%</td>
            <td style="text-align:center">{{$d[2]-$d[1]}}%</td>
        </tr>
    @endforeach
</table>
