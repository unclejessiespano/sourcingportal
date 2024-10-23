<?php

namespace App\Listeners;

use App\Events\CommentChanged;
use App\Models\Column_Map;
use App\Models\Line;
use App\Models\Supplierscore;
use DateTime;
use App\Models\Touchpoint;
use App\Models\Activity;
use Auth;

class CommentChangedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CommentChanged $event): void
    {
        //get the mapped column
        $column_map = Column_Map::getColumnByColumnID('comment');

        //add the comment
        $comment = Line::addComment($event->supplier_id, $event->line->identifier, $event->line->po_id, $event->line->sku_id, $event->line->id, null, $event->row[$column_map]);

        $a=1;
    }
}
