<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
class User_Supplier extends Model
{
    use HasFactory;
    protected $table = "user_suppliers";

    public function supplier(){
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }

    public static function addSuppliersToUser($user_id, $suppliers){
        //delete all of the suppliers before adding them to the user
        User_Supplier::where('user_id', $user_id)->delete();

        //loop through and add all of the assigned suppliers to the user
        array_unique($suppliers);
        foreach($suppliers as $supplier_id){
            $model = new User_Supplier();
            $model->user_id = $user_id;
            $model->supplier_id = $supplier_id;
            if(!$model->save()){
                Log::error("Could not save supplier ".$supplier_id." to user ".$user_id);
                return false;
            }
        }
        return true;
    }
    public static function getAssignedSuppliers($user_id){
        $assigned_suppliers = [];
        $items = User_Supplier::where('user_id', $user_id)->get();
        foreach($items as $item){
            $assigned_suppliers[] = $item->supplier_id;
        }
        return $assigned_suppliers;
    }
    public static function getAssignedUsers($team){
        $assigned_users = [];
        foreach($team as $teamuser){
            $assigned_users[] = $teamuser->id;
        }

        return $assigned_users;
    }
    public static function getSuppliers(){
        $suppliers = [];
        $user = Auth::user();
        $items = User_Supplier::with(['supplier.network', 'supplier.scores'])->where('user_id', $user->id)->get();
        foreach($items as $item){
            if(!empty($item->supplier)){
                if($item->supplier->parent_id ==0){
                    if(!empty($item->supplier->scores)){
                        $score = Supplier::calculateSupplierScore($item->supplier->scores);
                        $item->supplier->score = $score;
                    }
                    else{
                        $item->supplier->score = 0;
                    }
                }
                $suppliers[$item->supplier->name] = $item->supplier;
            }

        }
        ksort($suppliers);
        return collect($suppliers);
    }
}
