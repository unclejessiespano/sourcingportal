<table>
    <thead>
    <tr>
        <th>Status</th>
        <th>Plant</th>
        <th>Supplier_ID</th>
        <th>Supplier</th>
        <th>ID</th>
        <th>PO</th>
        <th>SKU</th>
        <th>Line</th>
        <th>Description</th>
        <th>Document_Date</th>
        <th>Delivery_Date</th>
        <th>Commit_Date</th>
        <th>Stat_Rel_Del_Date</th>
        <th>Order_Unit</th>
        <th>Order_Price_Unit</th>
        <th>Currency</th>
        <th>QTY</th>
        <th>Net_Price</th>
        <th>Value</th>
        <th>Lead_Time_Days</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order){
        @foreach($order->lines as $line)
            <tr>
                <td>@if($line->stat_del_date<$line->delivery_date) 1 @else 0 @endif</td>
                <td>{{$line->order->plant->plant}}</td>
                <td>{{$line->order->supplier->id}}</td>
                <td>{{$line->order->supplier->name}}</td>
                <td>{{ $line->id }}</td>
                <td>{{ $line->po_id }}</td>
                <td>{{ $line->sku_id }}</td>
                <td>{{ $line->line }}</td>
                <td>{{ $line->sku->short_text?? '' }}</td>
                <td>{{ $line->document_date }}</td>
                <td>{{ $line->delivery_date }}</td>
                <td>{{ $line->commit_date }}</td>
                <td>{{ $line->stat_del_date }}</td>
                <td>{{ $line->order_unit }}</td>
                <td>{{ $line->order_price_unit }}</td>
                <td>{{ $line->currency }}</td>
                <td>{{ $line->qty }}</td>
                <td>{{ $line->net_price }}</td>
                <td>{{ $line->qty*$line->net_price }}</td>
                <td>{{ $line->sku->lead_time_days?? '' }}</td>
            </tr>
        @endforeach
    @endforeach
    }

    </tbody>
    </table>
