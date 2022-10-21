<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    //To submit form err: Add [title] to fillable property to allow mass assignment on [App\Models\Listing].
    //VARIABLE NAME SHOULD BE $fillable cant be changed
    /**
     * AS logo column was updated later and here logo is not mentioned as fillable so the logo data doesnt saved, hence made changes in AppServiceProvider Model::unguard(); 
     */
    //protected $fillable = ['title','tags','company','location','email','website','description'];

    //WE CAN USE MODEL::UNGUARD also 

    //Setting up Tags Filter using Query var
    public function scopeFilter($query,array $filters){
        //dd($filters);
        //null coalescing operator
        if($filters['tag'] ?? false){
            //dd($query);
            $query->where('tags','like','%'.$filters['tag'].'%');
        }

        //Search
        if($filters['search'] ?? false){
            //dd($filters['search']);
            $query->where('title','like','%'.$filters['search'].'%')->orWhere('description','like','%'.$filters['search'].'%')->orWhere('tags','like','%'.$filters['search'].'%')->orWhere('location','like','%'.$filters['search'].'%');
        }
    }

    //RelationShip to user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
