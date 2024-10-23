<x-mail::message>

Hi {{$supplier->contacts[0]->fname}},<br /><br />
There are 3 lines due this week. You've previously committed to two of those lines. Do you have a commit for the third?
<br /><br />
I just ingested the latest data and it looks like I need {{count($commitsNeeded)}} commit dates. Can you help? You can simply add a commit date by clicking the "add" link in the table below.
<br /><br />

<x-mail::caution>
    ## {{count($dueThisWeek)}} lines due this week
</x-mail::caution>

<x-mail::panel>
    {!! $table_dueThisWeek !!}
</x-mail::panel>

<x-mail::caution>
    ## {{count($commitsNeeded)}} commits needed
</x-mail::caution>

<x-mail::panel>
    {!! $table_commitsNeeded !!}
</x-mail::panel>



<x-mail::caution>
    ## {{$lineChanges['commits']['message']}}
</x-mail::caution>

Thanks,<br>
Gene
</x-mail::message>
