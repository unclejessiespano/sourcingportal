<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class FinishedPart extends Model
{
    use HasFactory;

    public function parts(){
        return $this->hasMany('App\Models\FinishedPart', 'parent_id', 'id');
    }
    public function sku(){
        return $this->hasOne('App\Models\Sku', 'id', 'sku_id');
    }
    public static function addFinishedPart($request, $image){
        $model = new FinishedPart();
        $model->name = $request->name;
        $model->description = $request->description;
        $model->image = $image;

        if(!$model->save()){
            Log::error("Could not save finished part ".$request->name);
            return false;
        }
        return $model;
    }
    public static function buildSupplyChain($parts){
        $supplyChain = [];
        foreach($parts as $part){
            $supplyChain[] = array(
                "sku"=>$part->sku->sku,
                "sku_id"=>$part->sku->id,
                "description"=>$part->sku->description,
                "type"=>"part",
                "image"=>($part->detail) ? $part->detail->image : "/images/placeholder.svg"
            );
            if(!empty($part->sku->lines)){
                foreach($part->sku->lines as $line){
                    $expectingExpected = ($line->delivery_date < date('Y-m-d')) ? "Expected" : "Expecting";
                    $piecePieces = ($line->qty>1) ? "pieces" : "piece";
                    $status = ($line->delivery_date < date('Y-m-d')) ? "late" : "ontime";
                    $color = ($status=="late") ? "red" : "green";
                    $message = "<div><span class='inline-flex items-center rounded-md bg-".$color."-50 px-2 py-1 text-xs font-medium text-".$color."-700 ring-1 ring-inset ring-".$color."-600/20'>".$status."</span> ".$expectingExpected." <strong><a href='/supplier/".$line->supplier->slug."/".$line->identifier."'>".$line->qty."</a></strong> ".$piecePieces." from <strong><a href='/supplier/".$line->supplier->id."'>".$line->supplier->name."</a></strong> on <strong>".date('F jS', strtotime($line->delivery_date))."</strong></div>";
                    if(!$line->commit_date){
                        $message .="<div class='mt-5 rounded-md bg-yellow-100 p-4'><div class='flex'><div class='flex-shrink-0'>

      </div>
      <div class='ml-3'>
        <h3 class='text-sm font-medium text-yellow-800'>No commit given</h3>
        <div class='mt-2 text-sm text-yellow-700'>
          <p>".$line->supplier->name." has not given a confirmed commit for this line.</p>
        </div>
      </div></div></div>";
                    }
                    else{
                        $message .="<div>".$line->supplier->name." has committed to delivering the line by ".date('F jS', strtotime($line->commit_date))."</div>";
                    }
                    $supplyChain[] = array(
                        "type"=>"line",
                        "sku"=>null,
                        "description"=>null,
                        "line_id"=>$line->id,
                        "identifier"=>$line->identifier,
                        "supplier_id"=>$line->supplier->id,
                        "supplier"=>$line->supplier->name,
                        "supplier_slug"=>$line->supplier->slug,
                        "qty"=>$line->qty,
                        "document_date"=>$line->document_date,
                        "delivery_date"=>$line->delivery_date,
                        "commit_date"=>$line->commit_date,
                        "message"=>$message,
                        "status"=>$status
                    );
                }
            }

        }

        return $supplyChain;
    }
    public static function getCommitsForCalendar($parts){
        $data = [];
        foreach($parts as $part){
            foreach($part->sku->lines as $line){
                if(!empty($line->commit_date)){
                    $data[] = array(date('Y', strtotime($line->commit_date)), date('m', strtotime($line->commit_date))-1, date('d', strtotime($line->commit_date)), $line->qty);

                }
            }
        }
        return $data;
    }
    public static function removeSku($request){
        $model = FinishedPart::where('sku_id', $request->sku_id)->where('parent_id', $request->finishedgood_id)->first();
        if(!empty($model)){
            if($model->delete()){
                return true;
            }
        }
        return false;
    }
    public static function uploadPartImage($event){
        //create the directory if it doesn't exist
        if(!is_dir(storage_path('/app/public/parts/'))){
            mkdir(storage_path('/app/public/parts/'), 0755, true);
        }
        //upload the file
        $file = $event->request->file('file');
        $file = $file[0];

        $new_filename = uniqid().".".$file->extension();

        $tenant_directory = "tenant".tenancy()->tenant->id;
        $file_path = "/storage/parts/".$new_filename;
        $path_to_file = storage_path('/app/public/parts/'.$new_filename);

        $manager = new ImageManager(new Driver());
        $x = $manager->read($file);
        $temp_file_path = $x->origin()->filePath();
        $img = $manager->read($temp_file_path)->scaleDown(width:400)->save($path_to_file);

        return $img;
    }
    public static function writePartDescription($finishedpart){
        $part_name = $finishedpart->name;
        $part_description = $finishedpart->description;
        $num_of_parts_in_supply_chain = count($finishedpart->parts);

        $suppliers = [];
        $commits = [];
        $lates = [];
        $lines = [];
        foreach($finishedpart->parts as $part){
            foreach($part->sku->lines as $line){
                $lines[] = $line->id;
                $suppliers[] = $line->supplier->name;
                if(!empty($line->commit_date)){
                    $commits[] = $line->commit_date;
                }

                if($line->delivery_date < date('Y-m-d')){
                    $lates[] = $line->delivery_date;
                }
            }
        }

        $num_of_lines = count($lines);
        $num_of_late_lines = (!empty($lates)) ? count($lates) : 0;
        $num_of_commits = (!empty($commits)) ? count($commits) : 0;
        $num_of_suppliers = count($suppliers);

        if(!empty($part_description)){
            $description = $part_name." is a ".$part_description.". ".$num_of_parts_in_supply_chain." parts are connected in Mouker's supply chain for ".$part_name.". Of those, ".$num_of_late_lines." are late. ".$num_of_commits." lines have commit dates.";
        }
        else{
            $description = $num_of_parts_in_supply_chain." parts are connected in Mouker's supply chain for ".$part_name.". Of those, ".$num_of_late_lines." are late. ".$num_of_commits." lines have commit dates.";
        }
        return $description;
}
}
