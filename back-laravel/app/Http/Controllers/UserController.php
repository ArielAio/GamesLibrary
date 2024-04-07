<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
 
class UserController extends Controller
{
    /**
     * Show a list of all of the application's users.
     */
    public function index()
    {
        $users = DB::select('select * from users');
 
        foreach ($users as $user) {
            echo $user->name_user;
        }
    }

    public function insert(Request $request){
        $name_user = $request->input('name_user');
        $email_user = $request->input('email_user');
        $password_user = $request->input('password_user');
     
        DB::insert('insert into users (name_user, email_user, password_user) values (?, ?, ?)', [$name_user, $email_user, $password_user]);
     }

    public function update(){
        
        $affected = DB::update(
            'update users set votes = 100 where name = ?',
            ['Anita']
        );
    }
    public function delete(){

        $deleted = DB::delete('delete from users');


    }
    
    
}
