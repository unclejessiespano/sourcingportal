<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['PO', 'plant_id', 'supplier_id', 'document_date'];
    public function lines(){
        return $this->hasMany('App\Models\Line', 'po_id', 'id');
    }
    public function plant(){
        return $this->hasOne('App\Models\Plant', 'id', 'plant_id');
    }
    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    public static function exists($po){
        $model = Order::where('PO', $po)->first();
        return (!empty($model)) ? $model->id : false;
    }
    public static function getOrder($id){
        $model = Order::with('supplier', 'plant', 'lines.sku', 'lines.order.supplier')->find($id);
        return $model;
    }
    public static function getOpenOrders(){
        $model = Order::with('lines', 'supplier', 'plant')->get();
        return $model;
    }
    public static function import($supplier_id, $row){
        //TODO - need to add functionality to import plants

        $purchasing_document = Column_Map::getColumnByColumnID('purchasing_document');
        $order_date = Column_Map::getColumnByColumnID('order_date');
        $plant = Column_Map::getColumnByColumnID('plant');

        $plant_id = (!empty($plant)) ? $row[$plant] : 0;
        $existing_po = Order::exists($row[$purchasing_document]);
        if(!$existing_po){
            $unix_date = ($row[$order_date] - 25569) * 86400;
            $document_date = gmdate("Y-m-d", $unix_date);

            $model = Order::create([
                "PO"=>$row[$purchasing_document],
                "plant_id"=>$plant_id,
                "supplier_id"=>$supplier_id,
                "document_date"=>$document_date
            ]);
            return $model->id;
        }
        else{
            //the order exists. has it changed?
            /*
             * Probably nothing to worry about here unless the plant, supplier or document date changed
             * */
            $a =1;
        }
        return $existing_po;
    }


}
