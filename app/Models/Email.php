<?php

namespace App\Models;

use App\Mail\DataIngested;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class Email extends Model
{
    use HasFactory;

    public static function getDateForWeeklyUpdate(){
        $date = [];
        $today = date('Y-m-d');
        $date['from'] = date("Y-m-d", strtotime("this Saturday - 6 days"));
        $date['to'] = date("Y-m-d", strtotime("this Saturday"));
        $date['week_number'] = date("W", strtotime("now"));

        return $date;
    }
    public static function getIngestionSummary($date, $lineChanges, $tablePastDue, $tableCommits, $linesDueInWeeks,$escalations){
        $string = "Data for Week WEEK_NUMBER has been ingested.<br />";
        $string .= "Late lines LATE_LINES_VERB by LATE_LINE_PERCENT_CHANGE% this week. We also saw an COMMIT_LINES_VERB in the commit participation by COMMIT_LINES_PERCENT_CHANGE%.<br /><br />";
        $string .= "We are expecting 58 lines to be delivered next week.<br /><br />";

        if(count($escalations) >1){
            $suppliers = "";
            $count = 0;
            foreach($escalations as $supplier=>$escalation){
                $suppliers .= $supplier;
                $suppliers .= ($count < count($escalations)-1) ? ", " : "";

                $count++;
            }
            $string .= "There are ".count($escalations)." suppliers that are currently in escalation: ".$suppliers.". We are working to address their problematic lines.";
        }
        elseif(count($escalations)==1){
            foreach($escalations as $supplier=>$escalation){
                $string .= "There is one supplier that are currently in escalation: ".$supplier.". We are working to address their problematic lines.";
            }

        }


        $patterns = ['/WEEK_NUMBER/', '/LATE_LINES_VERB/', '/LATE_LINE_PERCENT_CHANGE/', '/COMMIT_LINES_VERB/', '/COMMIT_LINES_PERCENT_CHANGE/', '/58/'];
        $replacements = [$date['week_number'], $lineChanges['late_lines']['verb'], $lineChanges['late_lines']['difference'], $lineChanges['commits']['verb'], $lineChanges['commits']['difference'], count($linesDueInWeeks)];
        $x = preg_replace($patterns, $replacements, $string);
        return $x;
    }
    public static function sendDataIngestedEmail(){
        $date = Email::getDateForWeeklyUpdate();
        $lineChanges = Line::getLineChangeStats(2);
        $linesDueInWeeks = Line::getLinesDueInWeek();
        $escalations = Escalation::getEscalationsForEmail();
        $tablePastDue = Line::getEmailData_PercentPastDueSuppliers();
        $tableCommits = Line::getEmailData_PercentCommitSuppliers();
        $summary = Email::getIngestionSummary($date, $lineChanges, $tablePastDue, $tableCommits, $linesDueInWeeks, $escalations);
        $markdown_table_percentPastDueSuppliers = View::make('emails.table.percentPastDueSuppliers', ['data'=>$tablePastDue])->render();
        $markdown_table_percentCommitsSuppliers = View::make('emails.table.percentCommitsSuppliers', ['data'=>$tableCommits])->render();
        Mail::to('kruiz@corbus.com')->send(new DataIngested(
            $date,
            $markdown_table_percentPastDueSuppliers,
            $markdown_table_percentCommitsSuppliers,
            $lineChanges,
            $summary
        ));
    }
}
