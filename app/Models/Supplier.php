<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Events\SupplierAdded;
use DateTime;
use Orhanerday\OpenAi\OpenAi;
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'slug','parent_id', 'name'];

    public function orders(){
        return $this->hasMany('App\Models\Order', 'supplier_id', 'id');
    }
    public function lines_(){
        return $this->hasMany('App\Models\Line', 'supplier_id', 'id');
    }
    public function network(){
        return $this->hasMany('App\Models\Supplier', 'parent_id', 'id');
    }
    public function parent(){
        return $this->belongsTo('App\Models\Supplier', 'parent_id', 'id');
    }
    public function scores(){
        return $this->hasMany('App\Models\Supplierscore', 'supplier_id', 'id');
    }
    public function activity(){
        return $this->hasMany('App\Models\Activity', 'supplier_id', 'id');
    }
    public function escalation(){
        return $this->hasOne('App\Models\Escalation', 'supplier_id', 'id');
    }
    public function user(){
        return $this->hasOne('App\Models\User_Supplier', 'supplier_id', 'id');
    }
    public function users(){
        return $this->hasOneThrough('App\Models\User', 'App\Models\User_Supplier', 'supplier_id', 'id');
    }
    public function shippinglocation(){
        return $this->hasOne('App\Models\Shippinglocation', 'supplier_id', 'id');
    }
    public function contacts(){
        return $this->hasMany('App\Models\Contact', 'supplier_id', 'id');
    }
    public static function exists($supplier){
        $model = Supplier::where('name', $supplier)->first();
        return (!empty($model)) ? $model->id : false;
    }
    public static function getAISummary($supplier){
        $tenant = tenant();
        $open_ai_key = env('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $messages = [];
        array_push($messages, ["role"=>"system", "content"=>"You are a helpful assistant."]);
        //array_push($messages, ["role"=>"user", "content"=>$supplier->name." is a supplier to ".$tenant->id]);
        //array_push($messages, ["role"=>"user", "content"=>"Please tell me more about ".$supplier->name.". I'd like to know what type of work they do, who they source material from and who their main customers are."]);
        array_push($messages, ["role"=>"user", "content"=>"What does ".$supplier->name." do?"]);
        array_push($messages, ["role"=>"user", "content"=>"Where is ".$supplier->name." headquartered out of? What other office locations do they have?"]);
        $chat = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        return $chat;
    }
    public static function getAverageDaysPastDue($supplier_id){
        $dayslate = [];
        if(!empty($supplier_id)){
            $models = Line::where('active','y')->where('supplier_id', $supplier_id)->get();
        }
        else{
            $models = Line::where('active','y')->get();
        }

        foreach($models as $model){
            $due_date = new DateTime(date('Y-m-d', strtotime($model->delivery_date)));
            $days_late = $due_date->diff(new DateTime(date('Y-m-d')))->days;
            $dayslate[] = $days_late;
        }

        $average_days_late = (!empty($dayslate)) ? round(array_sum($dayslate)/count($dayslate),2) : 0;
        return $average_days_late;

    }
    public static function getSankeySupplyChain(){
        $data = [];
        $data[] = ['From', 'To', 'Weight'];

        $suppliers = Supplier::with('network', 'lines_', 'parent')->get();
        foreach($suppliers as $supplier){
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
    public static function getSankeyLineStats($supplier_id=""){
        $late_lines = [];
        $late_lines_commits =[];
        $late_lines_commits_valid = [];
        $late_lines_commits_valid_dates = [];
        $late_lines_commits_invalid = [];
        $late_lines_nocommits = [];
        $ontime_lines = [];
        $ontime_lines_commits =[];
        $ontime_lines_commits_valid = [];
        $ontime_lines_commits_valid_dates = [];
        $ontime_lines_commits_invalid = [];
        $ontime_lines_nocommits = [];
        $data = [];
        $data[] = ['From', 'To', 'Weight'];

        if(!empty($supplier_id)){
            $lines = Line::with('supplier')->where('active', 'y')->where('supplier_id', $supplier_id)->get();
        }
        else{
            $lines = Line::with('supplier')->where('active', 'y')->get();
        }
        foreach($lines as $line){
            if($line->delivery_date >= date('Y-m-d')){
                $ontime_lines[] = $line->delivery_date;

                if(!empty($line->commit_date)){
                    $ontime_lines_commits[] = $line->id;

                    if($line->commit_date >= date('Y-m-d')){
                        $ontime_lines_commits_valid[] = $line->commit_date;

                        //what commit dates were given?
                        $ontime_lines_commits_valid_dates[$line->commit_date][] = $line->commit_date;
                    }
                    else{
                        $ontime_lines_commits_invalid[] = $line->commit_date;
                    }
                }
                else{
                    $ontime_lines_nocommits[] = $line->id;
                }
            }
            else{
                $late_lines[] = $line->delivery_date;

                if(!empty($line->commit_date)){
                    $late_lines_commits[] = $line->id;

                    if($line->commit_date >= date('Y-m-d')){
                        $late_lines_commits_valid[] = $line->commit_date;

                        //what commit dates were given?
                        $late_lines_commits_valid_dates[$line->commit_date][] = $line->commit_date;
                    }
                    else{
                        $late_lines_commits_invalid[] = $line->commit_date;
                    }
                }
                else{
                    $late_lines_nocommits[] = $line->id;
                }
            }
        }
        $data[] = ["Lines", "On-Time", count($ontime_lines)];
        $data[] = ["Lines", "Late", count($late_lines)];

        $data[] = ["On-Time", "Commit Given - Ontime Lines", count($ontime_lines_commits)];
        $data[] = ["Late", "Commit Given - Late Lines", count($late_lines_commits)];
        $data[] = ["On-Time", "No Commit Given - Ontime Lines", count($ontime_lines_nocommits)];
        $data[] = ["Late", "No Commit Given - Late Lines", count($late_lines_nocommits)];
        $data[] = ["No Commit Given - Late Lines", "No Commit Given - Late Lines - Commit Invalid", 0];

        $data[] = ["Commit Given - Ontime Lines", "Commit Given - Ontime Lines - Commit Valid", count($ontime_lines_commits_valid)];
        $data[] = ["Commit Given - Late Lines", "Commit Given - Late Lines - Commit Valid", count($late_lines_commits_valid)];
        $data[] = ["Commit Given - Ontime Lines", "Commit Given - Ontime Lines - Commit Invalid", count($ontime_lines_commits_invalid)];
        $data[] = ["Commit Given - Late Lines", "Commit Given - Late Lines - Commit Invalid", count($late_lines_commits_invalid)];


        $data[] = ["No Commit Given - Ontime Lines", "No Commit Given - Ontime Lines - Commit Invalid", count($ontime_lines_commits_invalid)];
        $data[] = ["No Commit Given - Late Lines", "No Commit Given - Late Lines - Commit Invalid", 0];

                        if(!empty($ontime_lines_commits_valid_dates)){
                            foreach($ontime_lines_commits_valid_dates as $key=>$ontime_lines_commits_valid_date){
                                $data[] = ["Commit Given - Ontime Lines - Commit Valid", $key, count($ontime_lines_commits_valid_date)];
                            }
                        }
                        if(!empty($late_lines_commits_valid_dates)){
                            foreach($late_lines_commits_valid_dates as $key=>$late_lines_commits_valid_date){
                                $data[] = ["Commit Given - Late Lines - Commit Valid", $key, count($late_lines_commits_valid_date)];
                            }
                        }
        /*
        */
        return $data;
    }
    public static function getStats($supplier_id){
        $late_lines = [];

        //average days late
        $dayslate = [];
        if(!empty($supplier_id)){
            $models = Line::where('active','y')->where('supplier_id', $supplier_id)->get();
        }
        else{
            $models = Line::where('active','y')->get();
        }

        foreach($models as $model){
            $due_date = new DateTime(date('Y-m-d', strtotime($model->delivery_date)));
            $days_diff = $due_date->diff(new DateTime(date('Y-m-d')))->days;

            if($days_diff >0){
                $dayslate[] = $days_diff;
            }


            if(date('Y-m-d') > date('Y-m-d', strtotime($model->delivery_date))){
                $late_lines[] = $model->id;
            }
        }

        $average_days_late = (!empty($dayslate)) ? round(array_sum($dayslate)/count($dayslate),2) : 0;
        $percentPastDue = (!empty($late_lines)) ? round((count($late_lines) / $models->count())*100, 0) : 0;

        return array("averageDaysLate"=>$average_days_late, "lineCount"=>$models->count(), "percentPastDue"=>$percentPastDue);

    }
    public static function getSupplyChainTree(){
        $data = array(
            "id"=>1,
            "name"=>ucfirst(tenant('id')),
            "options"=>array(
                "fontSize"=> "25px",
                "fontFamily"=> "sans-serif",
                "fontWeight"=> 600,
                "fontColor"=> "#a06dcc",
                "borderWidth"=> 2,
                "borderColor"=> "#a06dcc",
                "borderColorHover"=> "#ec327e",
                "nodeBGColor"=> "#eedfff",
                "nodeBGColorHover"=> "#d5c3ff",
            )
        );

        $suppliers = Supplier::with('network', 'lines_')->get();
        foreach($suppliers as $key=>$supplier){
            $main = array(
                "id"=>$supplier->id,
                "name"=>$supplier->name,
                "category"=>$supplier->name,
                "options"=>array(
                    "nodeBGColorHover"=>"#97c7e3",
                    "borderColorHover"=>"#e563c7"
                )
            );

            if(count($supplier->network) >=1){
                $subtier['children'] = [];
                foreach($supplier->network as $subtiersupplier){
                    $x = Supplier::with('network', 'lines_')->where('id', $subtiersupplier->id)->first();
                    if(count($x->network)>=1){
                        foreach($x->network as $network){
                            $subtier['children'][] = array(
                                "id"=>$network->id,
                                "name"=>$network->name,
                                "category"=>$network->name,
                                "options"=>array(
                                    "nodeBGColorHover"=>"#97c7e3",
                                    "borderColorHover"=>"#e563c7"
                                )
                            );
                        }
                        $a=1;
                    }
                    else{
                        $subtier['children'][] = array(
                            "id"=>$subtiersupplier->id,
                            "name"=>$subtiersupplier->name,
                            "category"=>$supplier->name,
                            "options"=>array(
                                "nodeBGColorHover"=>"#97c7e3",
                                "borderColorHover"=>"#e563c7"
                            )
                        );
                    }

                    $main = array_merge($main, $subtier);
                }
            }
            if($supplier->parent_id==0){
                $data['children'][] = $main;
            }
            else{
                $b=1;
            }




        }

        return $data;
    }
    public static function getUsersSuppliers($user){
        //get the suppliers assigned to user in array
        $assigned_supplier_ids = [];
        foreach($user->suppliers as $supplier){
            $assigned_supplier_ids[] = $supplier->id;
        }

        $suppliers = Supplier::all();
        foreach($suppliers as $supplier){
            if(in_array($supplier->id, $assigned_supplier_ids)){
                $supplier->checked=true;
            }
        }
        return $suppliers;
    }
    public static function makeNode($x, $children=""){
        if(!empty($children)){
            $c = [];
            foreach($children as $child){

                foreach($child->network as $subtier){
                    $c[] = array('id'=>$subtier->id, 'label'=>$subtier->name, 'type'=>'link', 'slug'=>$subtier->slug);
                }
            }

            return array('id'=>$x->id, 'label'=>$x->name, 'type'=>'link', 'slug'=>$x->slug, 'children'=>$c);
        }
        else{
            return array('id'=>$x->id, 'label'=>$x->name, 'type'=>'link', 'slug'=>$x->slug);
        }

    }
    public static function formatNetwork($network){
        /*
         * children: [
        {
            label: 'Argentina',
            children: [
                {
                    label: 'Argentina'
                },
                {
                    label: 'Croatia'
                }
            ]
        },
        {
            label: 'France'
        }
    ]
         * */
        $children = [];
        foreach($network as $supplier){
            $count = $supplier->network->count();
            if($count>=1){
                $children[] = Supplier::makeNode($supplier, $supplier->network);
            }
            else{
                $children[] = Supplier::makeNode($supplier);
            }
        }
        $children[] = array('id'=>0, 'label'=>'Add Supplier', 'type'=>'button');
        return $children;
    }
    public static function calculateSupplierScore($scores){
        $x = [];
        foreach($scores as $score){
            $x[] = $score->value;
        }
        $sumOfScores = array_sum($x);
        if($sumOfScores <=0){
            $score = 1;
        }
        elseif($sumOfScores >100){
            $score = 100;
        }
        else{
            $score = $sumOfScores;
        }
        return $score;
    }
    public static function getCommitsForCalendar($supplier_id){
        $data =[];
        $lines = Line::where('active','y')->where('supplier_id', $supplier_id)->get();
        foreach($lines as $line){
            if(!empty($line->commit_date)){
                $data[] = array(date('Y', strtotime($line->commit_date)), date('m', strtotime($line->commit_date))-1, date('d', strtotime($line->commit_date)), $line->qty);

            }
        }
        return $data;
    }
    public static function getSupplier($slug){
        $model = Supplier::with(['orders.lines.sku', 'orders.lines.order', 'scores', 'activity.user', 'activity.supplier', 'activity.touchpoint', 'activity.order', 'activity.sku', 'activity.line', 'activity.supplierscore'])->where('slug', $slug)->first();
        $score = Supplier::calculateSupplierScore($model->scores);
        $model->score = $score;
        return $model;
    }
    public static function getSupplierBySlug($slug){
        $model = Supplier::with(['contacts','shippinglocation','orders.lines.sku', 'orders.lines.order', 'scores.ingestion', 'scores.touchpoint', 'activity.user', 'activity.supplier', 'activity.touchpoint.lineactivity', 'activity.comment', 'activity.order', 'activity.sku', 'activity.line', 'activity.supplierscore', 'network', 'user', 'users'])->where('slug', $slug)->first();
        $score = Supplier::calculateSupplierScore($model->scores);
        $model->score = $score;
        return $model;
    }
    public static function getSuppliers(){
        $suppliers = [];
        $lines = Line::where('active','y')->with('supplier.network', 'supplier.scores.ingestion')->get();

        foreach($lines as $line){
            if($line->supplier->parent_id ==0){
                if(!empty($line->supplier->scores)){
                    $score = Supplier::calculateSupplierScore($line->supplier->scores);
                    $line->supplier->score = $score;
                }
                else{
                    $line->supplier->score = 0;
                }
                $suppliers[$line->supplier->name] = $line->supplier;
            }
        }

        /*
        $suppliers = Supplier::with('orders.lines', 'network', 'scores')->where('parent_id', 0)->get();
        foreach($suppliers as $supplier){
            if(!empty($supplier->scores)){
                $score = Supplier::calculateSupplierScore($supplier->scores);
                $supplier->score = $score;
            }
            else{
                $supplier->score = 0;
            }
        }
        */
        ksort($suppliers);
        return $suppliers;
    }
    public static function getSuppliersBelowScore($target_score){
        $suppliers = [];
        $lines = Line::where('active','y')->with('supplier.network', 'supplier.scores', 'supplier.escalation', 'supplier.lines_')->get();

        foreach($lines as $line){
            if($line->supplier->parent_id ==0){
                if(!empty($line->supplier->scores)){
                    $score = Supplier::calculateSupplierScore($line->supplier->scores);

                    if($score <= $target_score){
                        $line->supplier->score = $score;
                        $suppliers[$line->supplier->id] = $line->supplier;

                        if($line->supplier->escalation){
                            $suppliers[$line->supplier->id]['escalation_id'] = $line->supplier->escalation->id;
                        }

                        //$x = Touchpoint::getTouchpointsNegativelyAffectingScore($line->supplier->activity);
                        //count($x['summary'])
                        $suppliers[$line->supplier->id]['reason_count'] = 1;

                    }
                }
            }
        }

        //escalate suppliers
        foreach($suppliers as $key=>$value){
            $model = Supplier::find($key);
            Escalation::EscalateSupplier($model);
        }

        return $suppliers;
    }
    public static function findOrGetSupplier($row){
        $vendor_name = Column_Map::getColumnByColumnID('vendor_name');
        $supplier_id = Column_Map::getColumnByColumnID('vendor_id');
        $supplier_id = $row[$supplier_id];
        $supplier = $row[$vendor_name];

        $existing_supplier = Supplier::exists($supplier);
        if(!$existing_supplier) {
            $model = Supplier::create([
                "supplier_id" => $supplier_id,
                "parent_id" => 0,
                "name" => $supplier,
                "slug" => strtolower(str_replace(" ", "-", $supplier))
            ]);

            return array("supplier_id"=>$model->id, "original_supplier_id"=>$supplier_id, "supplier"=>$supplier);
        }
        return array("supplier_id"=>$existing_supplier, "original_supplier_id"=>$supplier_id, "supplier"=>$supplier);

    }
    public static function import($ingestion_id, $row){
        $vendor_id = Column_Map::getColumnByColumnID('vendor_id');
        $vendor_name = Column_Map::getColumnByColumnID('vendor_name');
        $existing_supplier = Supplier::findOrGetSupplier($row);
        $name_of_vendor = explode("  ", trim($row[$vendor_name]));
        $supplier_id = $row[$vendor_id];
        $supplier = $row[$vendor_name];

        $existing_supplier = Supplier::exists($supplier);
        if(!$existing_supplier){
            $model = Supplier::create([
                "supplier_id"=>$supplier_id,
                "parent_id"=>0,
                "name"=>$supplier,
                "slug"=>strtolower(str_replace(" ","-", $supplier))
            ]);

            //give the supplier their score
            SupplierAdded::dispatch($ingestion_id, $model);

            return $model->id;
        }
        else{
            $model = Supplier::find($existing_supplier);

            //give the supplier their score
            SupplierAdded::dispatch($ingestion_id, $model);

            return $existing_supplier;
        }

    }


    public function lines(){
        return $this->hasManyThrough(
            'App\Models\Line',
            'App\Models\Order',
            'PO',
            'po_id',
            'id',
            'PO'
        );
    }
    public static function prepareScores($scores){
        $x = [];
        $starting_score = 0;
        foreach($scores as $score){
            $previous_score = $starting_score;
            $updated_score = $starting_score+$score->value;
            $starting_score = $updated_score;

            $x[] = array(
                "id"=>$score->id,
                "ingestion_id"=>$score->ingestion_id,
                "previous_score"=>$previous_score,
                "touchpoint"=>$score->touchpoint->touchpoint,
                "value"=>$score->value,
                "updated_score"=>$updated_score,
                "created_at"=>$score->created_at
            );
            $b=1;
        }
        return $x;
    }
    public static function savePlant($request){
        //does a location already exist?
        $count = Shippinglocation::where('supplier_id', $request->supplier_id)->count();

        if($count==0){
            //Let's add the location
            $model = new Shippinglocation();
        }
        else{
            //a location already exists, let's updated it
            $model = Shippinglocation::where('supplier_id', $request->supplier_id)->first();
        }
        $model->name = "shipping location";
        $model->supplier_id = $request->supplier_id;
        $model->address = $request->address;
        $model->city = $request->city;
        $model->state = $request->state;
        $model->zip = $request->zip;
        $model->country = $request->country;

        if(!empty($request->lat)){
            $model->lat = $request->lat;
        }
        if(!empty($request->lng)){
            $model->lng = $request->lng;
        }

        if(!$model->save()){
            Log::error("Couldn't update plant location for supplier id ".$request->supplier_id);
            $request->session()->flash("error", "Hmm...couldn't the supplier.");
            return false;
        }
        $request->session()->flash("success", "Success");
        return $model;
    }
    public static function saveSupplier($request){
        $slug = strtolower(str_replace(" ", "-", $request->supplier_name));
        $count = Supplier::where('slug', $slug)->count();

        //create the supplier
        $supplier = new Supplier();
        $supplier->supplier_id = 0;
        $supplier->parent_id = $request->supplier_id;
        $supplier->name = $request->supplier_name;
        $supplier->slug = ($count==0) ? $slug : $slug."-".$count+1;
        if(!$supplier->save()){
            Log::error("Couldn't save subtier supplier. ".$request->supplier_name." to Supplier #".$request->supplier_id);
            return false;
        }
        else{
            if(!empty($request->country) && !empty($request->city) && !empty($request->state) && !empty($request->zip)){
                //create the shipping location
                $address = $request->address." ".$request->city.", ".$request->state." ".$request->zip." ".$request->country;

                $geocoded_data = \GoogleMaps::load('geocoding')->setParam (['address' =>$address])->get();
                $geocoded_data_response = json_decode($geocoded_data);

                $location = new Shippinglocation();
                $location->supplier_id = $supplier->id;
                $location->name = "shipping location";
                $location->address = $request->address;
                $location->city = $request->city;
                $location->state = $request->state;
                $location->zip = $request->zip;
                $location->country = $request->country;

                if($geocoded_data_response->status=="OK"){
                    $location->lat = $geocoded_data_response->results[0]->geometry->location->lat;
                    $location->lng = $geocoded_data_response->results[0]->geometry->location->lng;
                }
                else{
                    Log::error("Couldn't get the geocoded data for address: ".$address);
                }

                if(!$location->save()){
                    Log::error("Couldn't' save location for supplier #".$supplier->id);
                }
            }


            //add the contacts if they exist
            if(!empty($request->fname) && !empty($request->lname) && !empty($request->email)){
                $contact = new Contact();
                $contact->name = $request->fname.' '.$request->lname;
                $contact->fname = $request->fname;
                $contact->lname = $request->lname;
                $contact->email = $request->email;
                $contact->phone = $request->phone;
                if(!$contact->save()){
                    Log::error("Could not save contact for supplier #".$supplier->id);
                }
            }
        }

        return $supplier;

    }
    public static function updateInfo($request){
        $model = Supplier::find($request->supplier_id);
        $model->url = $request->url;
        $model->description = $request->description;
        if(!$model->save()){
            Log::error("Couldn't update supplier info for supplier id ".$request->supplier_id);
            $request->session()->flash("error", "Hmm...couldn't the supplier.");
            return false;
        }
        $request->session()->flash("success", "Success");
        return $model;
    }
}
