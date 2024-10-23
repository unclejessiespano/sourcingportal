<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
class Contact extends Model
{
    use HasFactory;

    public static function deleteContact($contact_id){
        $model = Contact::find($contact_id);
        $model->supplier_id = null;
        if(!$model->save()){
            Log::error("Couldn't remove contact id: ".$contact_id." from supplier.");
            return false;
        }
        return true;
    }
    public static function saveContact($request){
        $model = new Contact();
        $model->supplier_id = $request->supplier_id;
        $model->name = $request->fname." ".$request->lname;
        $model->fname = $request->fname;
        $model->lname = $request->lname;
        $model->email = $request->email;
        $model->phone = $request->phone;
        if(!$model->save()){
            Log::error("Couldn't add contact for supplier id ".$request->supplier_id);
            $request->session()->flash("error", "Hmm...couldn't add contact.");
            return false;
        }
        $request->session()->flash("success", "Success");
        return $model;
    }
}
