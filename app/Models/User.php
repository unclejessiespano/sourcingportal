<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User_Supplier;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function team(){
        return $this->hasMany('App\Models\User', 'manager_id', 'id');
    }
    public function suppliers(){
        return $this->hasMany('App\Models\User_Supplier', 'user_id', 'id');
    }
    public static function assignUsersToManager($users, $manager_id){
        foreach($users as $user_id){
            $model = User::find($user_id);
            $model->manager_id = $manager_id;
            if(!$model->save()){
                Log::error("Couldn't save the manager id for user ".$user_id);
            }
        }
        return true;
    }
    public static function createUser(Request $request){
        $model = new User();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = md5($request->password);
        if(!$model->save()){
            Log::error("Couldn't create user: ".$request->name." - ".$request->email);
            return false;
        }

        //assign the role
        $model->assignRole($request->role);

        //add the suppliers
        User_Supplier::addSuppliersToUser($model->id, $request->assigned_suppliers);
        return true;
    }
    public static function getUsersForTeam($id){
        $users = User::all();
        $filtered = $users->filter(fn($user) => $user->id != $id);
        return $filtered;
    }
    public static function updateUser(Request $request){
        $model = User::find($request->id);
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = md5($request->password);
        if(!$model->save()){
            Log::error("Couldn't create user: ".$request->name." - ".$request->email);
            return false;
        }

        //assign the role
        $model->assignRole($request->role);

        //add the suppliers
        User_Supplier::addSuppliersToUser($model->id, $request->assigned_suppliers);

        //assigned the users
        User::assignUsersToManager($request->assigned_users, $request->id);
        return true;
    }
}
