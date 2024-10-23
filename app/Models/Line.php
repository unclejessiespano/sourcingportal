<?php

namespace App\Models;

use App\Events\CommitReceived;
use App\Events\LineDelivered;
use App\Events\LineDeliveryDateChanged;
use App\Events\LineLate;
use App\Events\LineNetPriceChanged;
use App\Events\LineQuantityChanged;
use App\Events\LeadTimeChanged;
use App\Events\CommentChanged;
use App\Models\Column_Map;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Models\Meeting;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
class Line extends Model
{
    use HasFactory;
    protected $fillable = ['ingestion_id', 'plant_id', 'active', 'plant','identifier', 'supplier_id', 'po_id', 'sku_id', 'line', 'line_activity_id', 'document_date', 'delivery_date', 'commit_date', 'stat_del_date', 'qty', 'order_unit', 'order_price_unit', 'net_price', 'currency'];

    public function order(){
        return $this->hasOne('App\Models\Order', 'id', 'po_id');
    }
    public function sku(){
        return $this->hasOne('App\Models\Sku', 'id', 'sku_id');
    }
    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
}
    public function activity(){
        return $this->hasMany('App\Models\Activity', 'identifier', 'identifier');
    }
    public function lineactivity(){
        return $this->hasOne('App\Models\LineActivity', 'id', 'line_activity_id');
    }
    public function escalation(){
        return $this->hasOne('App\Models\Escalation', 'identifier', 'identifier');
    }
    public function shipments(){
        return $this->hasMany('App\Models\Shipment', 'identifier', 'identifier');
    }

    public static function addComment($supplier_id, $identifier, $po_id, $sku_id, $line_id, $line, $comment){
        //get the touchpoint
        $touchpoint = Touchpoint::getByCode('comlin');

        //add the score
        $supplierscore = Supplierscore::addScore($supplier_id, $touchpoint);

        //add the activity
        $activity = Activity::addActivity($identifier, auth()->user()->id, $supplier_id, $po_id, $sku_id, $line, $touchpoint->id, $supplierscore->id);

        //add the comment
        $comment = Comment::addComment($activity->id, $line_id, $po_id, $sku_id, $line, $identifier, nl2br($comment));

        //add the comment id back to the activity
        Activity::addCommentToActivity($comment->id, $activity);

        return false;
    }
    public static function awardPointsClosedLine($row){
        $purchasing_document = Column_Map::getColumnByColumnID('purchasing_document');
        $material = Column_Map::getColumnByColumnID('material');
        $line = Column_Map::getColumnByColumnID('line');
        $identifiers = [];
        $identifier = "";
        if(!empty($purchasing_document)){
            $identifier .= $row[$purchasing_document];
        }
        if(!empty($material)){
            $identifier .= "-".$row[$material];
        }
        if(!empty($line)){
            $identifier .= "-".$row[$line];
        }


        //get all the identifiers in an array
        $lines = Line::all();
        foreach($lines as $line){

            if($line->identifier==$identifiers){
                //the current identifier isn't in the identifiers array, assume it was delivered
                LineDelivered::dispatch($line);
            }
        }


        //return true;
    }

    public static function awardPointsClosedLines($rows, $supplier_id=""){

        $purchasing_document = Column_Map::getColumnByColumnID('purchasing_document');
        $material = Column_Map::getColumnByColumnID('material');
        $line = Column_Map::getColumnByColumnID('line');
        $identifiers = [];
        foreach($rows as $item){
            $row = json_decode($item->row_data, true);
            $identifier = "";
            if(!empty($purchasing_document)){
                $identifier .= $row[$purchasing_document];
            }
            if(!empty($material)){
                $identifier .= "-".$row[$material];
            }
            if(!empty($line)){
                $identifier .= "-".$row[$line];
            }
            $identifiers[] = $identifier;
        }

        //get all the identifiers in an array
        $lines = Line::all();
        foreach($lines as $line){

            if(!in_array($line->identifier, $identifiers)){
                //the current identifier isn't in the identifiers array, assume it was delivered
                LineDelivered::dispatch($line);
            }
        }


        return true;
    }

    public static function deactivateAllLines(){
        $lines = Line::all();
        foreach($lines as $line){
            $model = Line::find($line->id)->update(['active'=>'n']);
        }
        return true;
    }
    public static function exists($po, $sku, $line){
        $identifier = "";
        if(!empty($po)){
            $identifier .= $po;
        }
        if(!empty($sku)){
            $identifier .= "-".$sku;
        }
        if(!empty($line) and ($line !="item")){
            $identifier .= "-".$line;
        }
        $model = Line::where('identifier', $identifier)->first();
        return (!empty($model)) ? $model : false;
    }
    public static function date_extract_format( $d, $null = '' ) {
        // check Day -> (0[1-9]|[1-2][0-9]|3[0-1])
        // check Month -> (0[1-9]|1[0-2])
        // check Year -> [0-9]{4} or \d{4}
        $patterns = array(
            '/\b\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.\d{3,8}Z\b/' => 'Y-m-d\TH:i:s.u\Z', // format DATE ISO 8601
            '/\b\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\b/' => 'Y-m-d',
            '/\b\d{4}-(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])\b/' => 'Y-d-m',
            '/\b(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-\d{4}\b/' => 'd-m-Y',
            '/\b(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])-\d{4}\b/' => 'm-d-Y',

            '/\b\d{4}\/(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\b/' => 'Y/d/m',
            '/\b\d{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\b/' => 'Y/m/d',
            '/\b(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}\b/' => 'd/m/Y',
            '/\b(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/\d{4}\b/' => 'm/d/Y',

            '/\b\d{4}\.(0[1-9]|1[0-2])\.(0[1-9]|[1-2][0-9]|3[0-1])\b/' => 'Y.m.d',
            '/\b\d{4}\.(0[1-9]|[1-2][0-9]|3[0-1])\.(0[1-9]|1[0-2])\b/' => 'Y.d.m',
            '/\b(0[1-9]|[1-2][0-9]|3[0-1])\.(0[1-9]|1[0-2])\.\d{4}\b/' => 'd.m.Y',
            '/\b(0[1-9]|1[0-2])\.(0[1-9]|[1-2][0-9]|3[0-1])\.\d{4}\b/' => 'm.d.Y',

            // for 24-hour | hours seconds
            '/\b(?:2[0-3]|[01][0-9]):[0-5][0-9](:[0-5][0-9])\.\d{3,6}\b/' => 'H:i:s.u',
            '/\b(?:2[0-3]|[01][0-9]):[0-5][0-9](:[0-5][0-9])\b/' => 'H:i:s',
            '/\b(?:2[0-3]|[01][0-9]):[0-5][0-9]\b/' => 'H:i',

            // for 12-hour | hours seconds
            '/\b(?:1[012]|0[0-9]):[0-5][0-9](:[0-5][0-9])\.\d{3,6}\b/' => 'h:i:s.u',
            '/\b(?:1[012]|0[0-9]):[0-5][0-9](:[0-5][0-9])\b/' => 'h:i:s',
            '/\b(?:1[012]|0[0-9]):[0-5][0-9]\b/' => 'h:i',

            '/\.\d{3}\b/' => '.v'
        );
        //$d = preg_replace('/\b\d{2}:\d{2}\b/', 'H:i',$d);
        $d = preg_replace( array_keys( $patterns ), array_values( $patterns ), $d );

        return preg_match( '/\d/', $d ) ? $null : $d;
    }


    public static function date_formating( $date, $format = 'Y-m-d', $in_format = false, $f = '' ) {
        $isformat = Line::date_extract_format( $date );
        $d = DateTime::createFromFormat( $isformat, $date );
        $format = $in_format ? $isformat : $format;
        if ( $format ) {
            if ( in_array( $format, [ 'Y-m-d\TH:i:s.u\Z', 'DATE_ISO8601', 'ISO8601' ] ) ) {
                $f = $d ? $d->format( 'Y-m-d\TH:i:s.' ) . substr( $d->format( 'u' ), 0, 3 ) . 'Z': '';
            } else {
                $f = $d ? $d->format( $format ) : '';
            }
        }
        return $f;
    } // end function
    public static function deleteLinesFromIngestion($ingestion_id, $next_ingestion_id){
        $lines = Line::where('ingestion_id', $ingestion_id)->get();
        foreach($lines as $line){
            $line->delete();
        }

        $lines_to_activate = Line::where('ingestion_id', $next_ingestion_id)->get();
        foreach($lines_to_activate as $line_to_activate){
            $line_to_activate->active='y';
            if(!$line_to_activate->save()){
                Log::error("Can not activate line ".$line_to_activate->id);
            }
        }
        return false;
    }
    public static function formatExcelDate($excel_date){
        $x = Line::date_formating($excel_date, 'Y-m-d');
        if(empty($x)){
            $unix_document_date = ($excel_date - 25569) * 86400;
            $value = gmdate("Y-m-d", $unix_document_date);
        }
        else{
            $value = $x;
        }

        return $value;
    }
    public static function fromIngestion($ingestion_id){
        $count = Line::where('ingestion_id', $ingestion_id)->count();
        return ($count>=1) ? true : false;
    }
    public static function getLinesByOrders($orders){
        $lines = [];
        foreach($orders as $order){
            foreach($order->lines as $line){
                $lines[] = $line;
            }
        }
        return $lines;
    }
    public static function getLine($po, $sku, $line){
        $model = Line::with('order.supplier')->where('po_id', $po)->where('sku_id', $sku)->where('line', $line)->first();
        return $model;
    }
    public static function getCommitsNeededFromSupplier($supplier){
        $lines = [];
        foreach($supplier->lines_ as $line){
            if(empty($line->commit_date)){
                $lines[] = $line;
            }
        }

        return collect($lines);
    }
    public static function getLinesDueThisWeek($supplier){
        $start = date("Y-m-d", strtotime("this Saturday - 6 days"));
        $end = date("Y-m-d", strtotime("this Saturday"));
        $lines = [];
        foreach($supplier->lines_ as $line){
            if(($line->delivery_date >= $start) && ($line->delivery_date < $end)){
                $lines[] = $line;
            }
        }

        return collect($lines);
    }
    public static function getLineChangeStats($number_of_ingestions){
        $ingestion_ids = [];
        $stats = [];
        $ingestions = Ingestion::select('id')->take($number_of_ingestions)->orderBy('created_at', 'desc')->get();
        foreach($ingestions as $ingestion){
            //are there lines from the ingestion?
            if(Line::fromIngestion($ingestion->id)){
                $ingestion_ids[] = $ingestion->id;
            }

        }

        $lines = Line::whereIn('ingestion_id', $ingestion_ids)->get();

        $ingestion_lines = [];
        foreach($lines as $line){
            $ingestion_items[$line->ingestion_id][] = $line;
        }

        if(count($ingestion_items) ==2){
            foreach($ingestion_items as $ingestion_id=>$lines){
                foreach($lines as $line){
                    if($line->delivery_date < date('Y-m-d')){
                        $late_lines[] = $line->delivery_date;
                    }
                    if($line->commit_date !=""){
                        $commit_lines[] = $line->commit_date;
                    }
                }
                $change[] = round((count($late_lines)/count($lines)),2)*100;
                $change_commit[] = round((count($commit_lines)/count($lines)),2)*100;
                $a=1;
            }

            $late_line_percent_lastweek = $late_lines;
            $verb_latelines = ($change[1]>$change[0]) ? "increased" : "decreased";
            $icon_latelines = ($change[1]>$change[0]) ? "⚠️" : "✅";
            $latelines_difference =$change[1]-$change[0];
            $verb_commits = ($change_commit[1]>$change_commit[0]) ? "increased" : "decreased";
            $icon_commits = ($change[1]>$change[0]) ? "✅" : "⚠️";
            $commits_difference = $change_commit[1]-$change_commit[0];

            $stats = [
                "late_lines"=>array(
                    "prev"=>$change[0],
                    "current"=>$change[1],
                    "difference"=>$latelines_difference,
                    "verb"=>$verb_latelines,
                    "message"=>$icon_latelines." Late Lines ".$verb_latelines." by ".$latelines_difference."%",
                ),
                "commits"=>array(
                    "prev"=>$change_commit[0],
                    "current"=>$change_commit[1],
                    "difference"=>$commits_difference,
                    "verb"=>$verb_commits,
                    "message"=>$icon_commits." Commits ".$verb_commits." by ".$commits_difference."%",
                )
            ];
        }
        else{
            foreach($ingestion_items as $ingestion_id=>$lines){
                foreach($lines as $line){
                    if($line->delivery_date < date('Y-m-d')){
                        $late_lines[] = $line->delivery_date;
                    }
                    if($line->commit_date !=""){
                        $commit_lines[] = $line->commit_date;
                    }
                }
                $change[] = round((count($late_lines)/count($lines)),2)*100;
                $change_commit[] = round((count($commit_lines)/count($lines)),2)*100;
                $a=1;
            }

            $late_line_percent_lastweek = $late_lines;
            $verb_latelines = "increased";
            $icon_latelines = "🆕";
            $latelines_difference =$change[0];
            $verb_commits = "increased";
            $icon_commits = "🆕";
            $commits_difference = $change_commit[0];

            $stats = [
                "late_lines"=>array(
                    "prev"=>0,
                    "current"=>$change[0],
                    "difference"=>$latelines_difference,
                    "verb"=>$verb_latelines,
                    "message"=>$icon_latelines." Late Lines ".$verb_latelines." by ".$latelines_difference."%",
                ),
                "commits"=>array(
                    "prev"=>0,
                    "current"=>$change_commit[0],
                    "difference"=>$commits_difference,
                    "verb"=>$verb_commits,
                    "message"=>$icon_commits." Commits ".$verb_commits." by ".$commits_difference."%",
                )
            ];
        }
        return $stats;
    }
    public static function getLinesByIdentifier($identifier){
        $model = Line::where('identifier', $identifier)->get();
        return $model;
    }
    public static function getLinesCommitsForDashbord($user_id){
        $user = User::with('team')->find($user_id);

        //get the users from the team
        $team_user_ids = [];
        foreach($user->team as $teammember){
            $team_user = User::with('suppliers.supplier.lines_')->find($teammember->id);

            $team_user_lines_count = [];
            $teammember->count_suppliers = count($team_user->suppliers);
            foreach($team_user->suppliers as $user_supplier){
                $team_user_lines_count[] = count($user_supplier->supplier->lines_);
                $commit_dates = [];
                foreach($user_supplier->supplier->lines_ as $line){
                    if(!empty($line->commit_date) && $line->active=='y'){
                        $commit_dates[] = $line->commit_date;
                    }

                }

                $teammember->count_commits = count($commit_dates);
            }
            $teammember->count_lines = array_sum($team_user_lines_count);
        }


        return $user;
    }
    public static function getLinesDueInWeek($num_weeks="1"){
        $x = $num_weeks*7;
        $start_day = $x-1;
        $end_day = $x;
        $start = date("Y-m-d", strtotime("this Saturday - ".$start_day." days"));
        $end = ($num_weeks==1) ? date("Y-m-d", strtotime("this Saturday")) : date("Y-m-d", strtotime("this Saturday + ".$end_day." days"));

        $lines = Line::where('delivery_date', '>=', $start)->where('delivery_date', '<=', $end)->get();
        return $lines;
    }
    public static function getOpenLines(){
        $model = Line::with('order.plant', 'order.supplier', 'sku')->get();
        return $model;
    }
    public static function getGoogleChartData_PercentPastDueSuppliers(){

        $suppliers = [];
        $late_lines = [];
        $lines = [];
        $lines = Line::with('supplier')->where('active','y')->get();

        foreach($lines as $line){
            $suppliers[$line->supplier->name]['lines'][] = $line->delivery_date;
            if($line->delivery_date < date('Y-m-d')){
                $suppliers[$line->supplier->name]['late_lines'][] = $line->delivery_date;
            }
        }

        foreach($suppliers as $key=>$supplier){
            $lines = count($supplier['lines']);
            $late_lines = (!empty($supplier['late_lines'])) ? count($supplier['late_lines']) : 0;
            $data[] = array($key, round($late_lines/$lines,2)*100);
        }
        asort($data);
        array_unshift($data, ["Suppler", "% Past Due"]);
        return $data;
    }
    public static function getEmailData_PercentCommitSuppliers(){

        $ingestions = [];
        $suppliers = [];
        $late_lines = [];
        $lines = [];
        $lines = Line::with('supplier')->get();

        foreach($lines as $line){
            $suppliers[$line->supplier->name][$line->ingestion_id]['lines'][] = $line->delivery_date;
            if($line->commit_date !=""){

                $suppliers[$line->supplier->name][$line->ingestion_id]['commits'][] = $line->commit_date;
            }
        }

        foreach($suppliers as $supplier=>$ingestions){
            if(count($ingestions)==1){
                //there's only one ingestion

                $x = [];
                $x[] = 0;
                foreach($ingestions as $ingestion){
                    $lines = count($ingestion['lines']);
                    $commits = (!empty($ingestion['commits'])) ? count($ingestion['commits']) : 0;
                    $x[] = round($commits/$lines,2)*100;
                }

                $y = [$supplier];
                $data[] = array_merge($y, $x);
            }
            else{
                //rsort($ingestions);
                $ingestions_ = array_slice($ingestions, 0, 2);
                $x = [];
                foreach($ingestions_ as $ingestion){
                    $lines = count($ingestion['lines']);
                    $commits = (!empty($ingestion['commits'])) ? count($ingestion['commits']) : 0;
                    $x[] = round($commits/$lines,2)*100;
                }

                $y = [$supplier];
                $data[] = array_merge($y, $x);
            }

        }
        asort($data);
        //array_unshift($data, ["Supplier", "Last Week", "This Week"]);
        return $data;
    }
    public static function getEmailData_PercentPastDueSuppliers(){

        $ingestions = [];
        $suppliers = [];
        $late_lines = [];
        $lines = [];
        $lines = Line::with('supplier')->get();

        foreach($lines as $line){
            $suppliers[$line->supplier->name][$line->ingestion_id]['lines'][] = $line->delivery_date;
            if($line->delivery_date < date('Y-m-d')){

                $suppliers[$line->supplier->name][$line->ingestion_id]['late_lines'][] = $line->delivery_date;
            }
        }

        foreach($suppliers as $supplier=>$ingestions){
            if(count($ingestions)==1){
                //there's only one ingestion

                $x = [];
                $x[] = 0;
                foreach($ingestions as $ingestion){
                    $lines = count($ingestion['lines']);
                    $late_lines = (!empty($ingestion['late_lines'])) ? count($ingestion['late_lines']) : 0;
                    $x[] = round($late_lines/$lines,2)*100;
                }

                $y = [$supplier];
                $data[] = array_merge($y, $x);
            }
            else{
                rsort($ingestions);
                $ingestions_ = array_slice($ingestions, 0, 2);
                $x = [];
                foreach($ingestions_ as $ingestion){
                    $lines = count($ingestion['lines']);
                    $late_lines = (!empty($ingestion['late_lines'])) ? count($ingestion['late_lines']) : 0;
                    $x[] = round($late_lines/$lines,2)*100;
                }

                $y = [$supplier];
                $data[] = array_merge($y, $x);
            }

        }
        asort($data);
        //array_unshift($data, ["Supplier", "Last Week", "This Week"]);
        return $data;
    }
    public static function getLinesBySupplierId($id){
        $lines = Line::with(['escalation', 'order.supplier','sku','activity','lineactivity'])->where('active','y')->where('supplier_id', $id)->get();

        return $lines;
    }
    public static function getSankey(){
    $data = [];
    $data[] = ['From', 'To', 'Weight'];

    $lines = Line::with('sku', 'supplier')->get();
    foreach($lines as $line){
        $x = $supplier->name;

        if($supplier->parent_id==0){
            $data[] = [ucfirst(tenant('id')), trim($supplier->name), $supplier->lines_->count()];
        }
        else{
            $data[] = [trim($supplier->parent->name), trim($supplier->name), $supplier->lines_->count()];
        }

        foreach($supplier->network as $subtiersupplier){
            $data[] = [trim($supplier->name), $subtiersupplier->name, 1];
        }


    }

    return $data;
    }
    public static function getStats($supplier_id=""){
        $stats = [];
        if(!$supplier_id){
            $lines = Line::where('active','y')->get();
        }
        else{
            $lines = Line::where('active', 'y')->where('supplier_id', $supplier_id)->get();
        }

        //commit percentage
        $commits = [];
        $late_lines = [];
        foreach($lines as $line){
            if(!empty($line->commit_date)){
                $commits[] = $line->commit_date;
            }
            if($line->delivery_date < date('Y-m-d')){
                $late_lines[] = $line->delivery_date;
            }
        }
        $stats['commit_percentage'] = array(
            array("Label", "Value"),
            array("Commit %", (!empty($commits)) ? round((count($commits)/$lines->count())*100,2) : 0)
        );
        $stats['late_percentage'] = array(
            array("Label", "Value"),
            array("Late %", (!empty($late_lines)) ? round((count($late_lines)/$lines->count())*100,2) : 0)
        );
        return $stats;

    }
    public static function getTeamStats($team){
        $lines = [];

        foreach($team as $user){
            $supplier_lines_total = [];
            $total_lines = [];
            $total_commits = [];
            $total_commits_missed = [];
            $total_late_lines = [];
            $total_span_due_date = [];
            $model = User_Supplier::with('supplier.lines_', 'supplier.scores')->where('user_id', $user->id)->get();

            foreach($model as $item){


                foreach($item->supplier->lines_ as $line){
                    if($line->active=='y'){
                        $total_lines[] = $line;
                        $lines[$user->name]['info'][$item->supplier->name][] = $item->supplier;
                        $lines[$user->name]['data'][$item->supplier->name][] = $line;

                        if(!empty($line->commit_date)){
                            $supplier_lines_total[] = $line->commit_date;
                            $total_commits[] = $line->commit_date;

                            if($line->commit_date < date('Y-m-d')){
                                $total_commits_missed[] = $line->commit_date;
                            }

                            $delivery_date = date_create($line->delivery_date);
                            $commit_date = date_create($line->commit_date);
                            $date_diff = date_diff($delivery_date, $commit_date);
                            $total_span_due_date[] = $date_diff->days;
                        }

                        if($line->delivery_date < date('Y-m-d')){
                            $total_late_lines[] = $line->delivery_date;
                        }
                    }

                }

                $data[$user->name]['totals'] = array(

                    "count"=>count($total_lines),
                    "commit_dates"=>count($total_commits),
                    "late_commits"=>count($total_commits_missed),
                    "late_lines"=>count($total_late_lines),
                    "percent_commit"=>(!empty($total_commits)) ? round((count($total_commits)/count($total_lines)*100),2) : 0,
                    "percent_late"=>(!empty($total_late_lines)) ? round((count($total_late_lines)/count($total_lines)*100),2) : 0,
                    "percent_latecommit"=>(!empty($total_commits_missed)) ? round((count($total_commits_missed)/count($total_commits)*100),2) : 0,
                    "due_commit_span"=>(!empty($total_span_due_date)) ? round(array_sum($total_span_due_date)/count($total_span_due_date),2) : 0
                );
            }


            foreach($lines as $name=>$suppliers){

                foreach($suppliers['data'] as $supplier=>$supplier_lines){
                    //totals


                    $late_commits = [];
                    $commit_dates = [];
                    $late_lines = [];
                    $span_dueDates = []; //mrd - commit

                    foreach($supplier_lines as $supplier_line){

                        if(!empty($supplier_line->commit_date)){
                            $supplier_commits_total[] = $supplier_line->commit_date;
                            $delivery_date = date_create($supplier_line->delivery_date);
                            $commit_date = date_create($supplier_line->commit_date);
                            if($supplier_line->commit_date < date('Y-m-d')){
                                $late_commits[] = $supplier_line->id;
                            }
                            $commit_dates[] = $supplier_line->id;

                            $date_diff = date_diff($delivery_date, $commit_date);
                            $span_dueDates[] = $date_diff->days;
                        }
                        if($supplier_line->delivery_date < date('Y-m-d')){
                            $late_lines[] = $supplier_line->id;
                        }
                        $a=1;
                    }


                    $score = Supplier::calculateSupplierScore($suppliers['info'][$supplier][0]->scores);
                    $data[$name]['data'][$supplier] = array(
                        "supplier_id"=>$suppliers['info'][$supplier][0]['id'],
                        "supplier_slug"=>$suppliers['info'][$supplier][0]['slug'],
                        "supplier_score"=>$score,
                        "count"=>count($supplier_lines),
                        "commit_dates"=>count($commit_dates),
                        "late_commits"=>count($late_commits),
                        "late_lines"=>count($late_lines),
                        "percent_commit"=>round((count($commit_dates)/count($supplier_lines))*100,2),
                        "percent_late"=>round((count($late_lines)/count($supplier_lines))*100,2),
                        "percent_latecommit"=>(!empty($commit_dates)) ? round((count($late_commits)/count($supplier_lines))*100,2) : null,
                        "due_commit_span"=>(!empty($span_dueDates)) ? round(array_sum($span_dueDates)/count($span_dueDates),2) : null
                    );
                    $a=1;
                }


            }


        }
        return $data;
    }
    public static function makeIdentifier($row, $purchasing_document, $material, $line){
        $identifier = "";
        if(!empty($purchasing_document)){
            $identifier .= $row[$purchasing_document];
        }
        if(!empty($material)){
            $identifier .= "-".$row[$material];
        }
        if(!empty($line)){
            $identifier .= "-".$row[$line];
        }

        return $identifier;
    }
    public static function import($ingestion_id, $plant_id, $supplier_id, $po_id, $sku_id, $row, $meetings){
        //I was previously differentiating between existing lines and new lines.
        //I'm now taking all lines, regardless if they're in the database or not
        //**This is going to affect the scoring

        $purchasing_document = Column_Map::getColumnByColumnID('purchasing_document');
        $material = Column_Map::getColumnByColumnID('material');
        $line = Column_Map::getColumnByColumnID('line');

        $identifier = Line::makeIdentifier($row, $purchasing_document, $material, $line);

        $lines_without_commits = [];
        $lines_late = [];

        //create an agenda item for the commits needed
        $agenda_item = Agendaitem::create($meetings[$supplier_id], $identifier, "Commit Needed");

        $order_date = Column_Map::getColumnByColumnID('order_date');
        $due_date = Column_Map::getColumnByColumnID('due_date');
        $commit_date_map = Column_Map::getColumnByColumnID('commit_date');
        $statistical_delivery_date = Column_Map::getColumnByColumnID('statistical_delivery_date');
        $lead_time = Column_Map::getColumnByColumnID('lead_time');
        $qty_scheduled = Column_Map::getColumnByColumnID('qty_scheduled');
        $order_unit = Column_Map::getColumnByColumnID('order_unit');
        $comment = Column_Map::getColumnByColumnID('comment');

        $order_unit_value = (!empty($order_unit) and ($order_unit !="null")) ? $row[$order_unit] : "each";
        $order_price_unit = Column_Map::getColumnByColumnID('order_price');
        $order_price_unit_value = (!empty($order_price_unit)) ? $row[$order_price_unit] : "each";
        $net_price = Column_Map::getColumnByColumnID('net_price');
        $net_price_value = (!empty($net_price) and ($net_price !="null")) ? $row[$net_price] : "0.00";
        $currency = Column_Map::getColumnByColumnID('currency');
        $currency_value = (!empty($currency)) ? $row[$currency] : "USD";
        $line_value = (!empty($line)) ? $row[$line] : 0;

        $document_date_formatted = Line::formatExcelDate($row[$order_date]);
        $delivery_date_formatted = Line::formatExcelDate($row[$due_date]);
        $commit_date_formatted = Line::formatExcelDate($row[$commit_date_map]);

        $document_date = ($document_date_formatted != "1899-12-30") ? $document_date_formatted : null;
        $delivery_date = ($delivery_date_formatted != "1899-12-30") ? $delivery_date_formatted : null;
        $commit_date_date = ($commit_date_formatted != "1899-12-30") ? $commit_date_formatted : null;
        $commit_date = ($commit_date_date > date('Y-m-d')) ? $commit_date_date : null;
        if(empty($row[$statistical_delivery_date])){
            $stat_del_date = date('Y-m-d', strtotime(Line::formatExcelDate($row[$order_date]).' + '.$row[$lead_time].' days'));
        }
        else{
            $stat_del_date = Line::formatExcelDate($row[$statistical_delivery_date]);
        }



        $model = Line::create([
            "ingestion_id"=>$ingestion_id,
            "plant_id"=>$plant_id,
            "active"=>"y",
            "supplier_id"=>$supplier_id,
            "identifier"=>$identifier,
            "po_id"=>$po_id,
            "sku_id"=>$sku_id,
            "line"=>$line_value,
            "line_activity_id"=>0,
            "document_date"=>$document_date,
            "delivery_date"=>$delivery_date,
            "commit_date"=>$commit_date,
            "stat_del_date"=>$stat_del_date,
            "qty"=>$row[$qty_scheduled],
            "order_unit"=>$order_unit_value,
            "order_price_unit"=>$order_price_unit_value,
            "net_price"=>$net_price_value,
            "currency"=>$currency_value
        ]);

        //is there a comment?
        if(!empty($row[$comment])){
            $comment = Line::addComment($supplier_id, $identifier, $po_id, $sku_id, $model->id, $line, $row[$comment]);
        }
        //is the line late? If so, we need to dock it points
        if($delivery_date < date('Y-m-d')){

            LineLate::dispatch($ingestion_id, $model, $supplier_id, 0);
        }

        return $model->id;
    }
    public static function saveLineActivity($line, $lineActivity){
        $line->line_activity_id = $lineActivity->id;
        if(!$line->save()){
            Log::error("Could not update the line_activity_id for ".$line->id);
            return false;
        }
        return $line;
    }
    public static function searchLines($request){
        if(!empty($request->order) or !empty($request->sku) or !empty($request->line)){
            $po = Order::where('PO', $request->order)->first();
            $sku = Sku::where('sku', $request->sku)->first();

            $model = Line::with('order.supplier', 'sku', 'supplier');

            $model->when($request->order, function($q) use ($po){
                return $q->where('po_id', $po->id);
            });
            $model->when($request->sku, function($q) use ($sku){
                return $q->where('sku_id', $sku->id);
            });
            $model->when($request->line, function($q) use ($request){
                return $q->where('line', $request->line);
            });

            $lines = $model->where('active','y')->get();
            return $lines;
        }
        return false;
    }
    public static function setCommitForLine($commit_date, $po_id, $sku_id, $line){
        $commitdate = date('Y-m-d', strtotime($commit_date));

        $model = Line::getLine($po_id, $sku_id, $line);
        $model->commit_date = $commitdate;
        if(!$model->save()){
            Log::error("Unable to set commit date for line. PO ID: ".$po_id." SKU ID: ".$sku_id." Line: ".$line);
            return false;
        }

        CommitReceived::dispatch($model);

        return true;
    }
    public static function updateLine($existing_line, $row){
        $order_date_map = Column_Map::getColumnByColumnID('document_date');
        $due_date_map = Column_Map::getColumnByColumnID('delivery_date');
        $commit_date_map = Column_Map::getColumnByColumnID('commit_date');
        $statistical_delivery_date_map = Column_Map::getColumnByColumnID('statistical_delivery_date');
        $qty_map = Column_Map::getColumnByColumnID('qty');
        $net_price_map = Column_Map::getColumnByColumnID('net_price');

        if(!empty($row[$order_date_map])){
            $document_date = Line::formatExcelDate($row[$order_date_map]);
        }
        if(!empty($row[$due_date_map])){
            $delivery_date = Line::formatExcelDate($row[$due_date_map]);
        }
        if(!empty($row[$statistical_delivery_date_map])){
            $stat_del_date = Line::formatExcelDate($row[$statistical_delivery_date_map]);
        }
        if(!empty($row[$commit_date_map])){
            $commit_date = Line::formatExcelDate($row[$commit_date_map]);
        }
        if(!empty($row[$qty_map])){
            $qty = $row[$qty_map];
        }


        $column_mappings = array(
            "order_date_map"=>"document_date",
            "due_date_map"=>"delivery_date",
            "commit_date_map"=>"commit_date",
            "statistical_delivery_date_map"=>"stat_del_date",
            "qty_map"=>"qty",
            "net_price_map"=>"net_price"
        );

        $columns_to_update = [];
        $columns_to_update['active'] = "y";
        foreach($column_mappings as $column_id=>$column){
            if(!empty($row[${$column_id}])){
                $columns_to_update[$column] = ${$column};
            }
        }



        $model = Line::find($existing_line->id)->update($columns_to_update);

        return $model;
    }
}
