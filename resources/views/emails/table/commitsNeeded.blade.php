<?php $i=1; ?>
<table style="width:100%;font-size:80%">
    <tr>
        <th style="text-align:left;">&nbsp;</th>
        <th style="text-align:left; width:25%">PO</th>
        <th style="text-align:center; width:25%">Material</th>
        <th style="text-align:center;width:25%">Due Date</th>
        <th style="text-align:center;width:24%;">Commit Date</th>
    </tr>
    @foreach($data as $d)
        <tr>
            <td style="text-align:left;">{{$i}}.</td>
            <td style="text-align:left;">{{$d->order->PO}}</td>
            <td style="text-align:center">{{$d->sku->sku}}</td>
            <td style="text-align:center">{{$d->delivery_date}}</td>
            <td style="text-align:center"><a href="">Add</a></td>
        </tr>
        <?php $i++ ?>
    @endforeach
</table>

