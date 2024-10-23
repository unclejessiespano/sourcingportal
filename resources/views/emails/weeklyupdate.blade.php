<x-mail::message>
# Weekly Update - Week {{$date['week_number']}}

Hi Monica,<br />
This is your weekly update for Week {{$date['week_number']}}. Late lines increased by 12% this week. We also saw an increase in the commit participation by 32%.<br /><br />
We are expecting 58 lines to be delivered next week.<br /><br />
There is one supplier that are currently in escalation: Hessel LLC. We are working to address their problematic lines.


<x-mail::caution>
## {{$lineChanges['late_lines']['message']}}
</x-mail::caution>

<x-mail::panel>
    {!! $table_percentPastDueSuppliers !!}
</x-mail::panel>

<x-mail::caution>
    ## {{$lineChanges['commits']['message']}}
</x-mail::caution>

    Thanks,<br>
    Gene
</x-mail::message>
