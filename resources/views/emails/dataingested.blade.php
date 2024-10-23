<x-mail::message>
# Data Ingested - Week {{$date['week_number']}}

{!! $summary !!}


<x-mail::caution>
    ## {{$lineChanges['late_lines']['message']}}
</x-mail::caution>

<x-mail::panel>
    {!! $table_percentPastDueSuppliers !!}
</x-mail::panel>

<x-mail::caution>
    ## {{$lineChanges['commits']['message']}}
</x-mail::caution>

<x-mail::panel>
    {!! $table_percentCommitsSuppliers !!}
</x-mail::panel>

Thanks,<br>
Gene
</x-mail::message>
