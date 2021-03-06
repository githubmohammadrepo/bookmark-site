<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //using raw sql in laravel
    public function index(){
        echo "<style>
            *{
                font-size:1.4rem;
                color:blue;
            }
        </style>";
        $email='computercodemohammad@gmail.com';
        $info = DB::select('select id from users where email=?',[$email]);
       if(count($info)){
           //show informations
            $informations = DB::select('select * from users where email=?',[$email]);
            foreach($informations as $info){
                echo 'your id is => '.$info->id.'<br>';
                echo 'your email is => '.$info->name.'<br >';
                echo 'your email is => '.$info->email.'<br >';
                echo 'your password is => '.$info->password.'<br >';
            }

           //delete informations
            $result = DB::delete('delete from users where email = ?', [$email]);
            if($result){
                echo 'your informations was deleted'.'<br>';
                echo 'please reload page for insert your informations'.'<br>';
            }else{
                echo 'your informations does not delete'.'<br>';;
            }
        }else{
            //insert informations
            echo 'no you must insert your informations'.'<br>';;
            $result = DB::insert('insert into users (name,email,password) values (?,?,?)', ['hedieh', 'computercodemohammad@gmail.com','computercodemohammad']);
            if($result){
                echo 'your informations was inserted'.'<br>';

                //shwo inserted informations
                //show informations
                $informations = DB::select('select * from users where email=?',[$email]);
                foreach($informations as $info){
                    echo 'your id is =>'.$info->id.'<br>';
                    echo 'your name is => '.$info->name.'<br >';
                    echo 'your email is => '.$info->email.'<br >';
                    echo 'your password is => '.$info->password.'<br >';
                }
            }else{
                echo 'your informations does not inserted'.'<br>';;
            }

       }

    }

    //using query builder inlaravewl
    public function builder(){
        $all_info=Array('test'=>'hello query builder');

        // //retrive informations with conditions
        // $select_one = DB::table('users')->where('id',10)->get();
        // array_push($all_info,$select_one);

        // //retrive one value from a single row
        // $name = DB::table('users')->where('id','10')->value('email');
        // array_push($all_info,$name);

        // //return all names in users table
        // $all_names=DB::table('users')->pluck('name');
        // array_push($all_info,'all Names');
        // array_push($all_info,$all_names);

        // $one = DB::table('users')->pluck('id','name');
        // foreach ($one as $key => $value) {
        //     //if name is soma and id is 2
        //     if($key == 'soma' && $value==2){
        //         echo 'your name is soma and id is 2';
        //     }else{
        //         continue;
        //     }
        // }



        //return aggrigate in laravel count min and max
        // $data = DB::table('users')->avg('id');
        // return $data;

        //return if record exist

        //ziba exist in real
        $is_soma = DB::table('users')->where('name','ziba')->exists();
        if($is_soma){
            echo 'soma name exist';
        }else{
            echo 'soma name does not exist any where';
        }

        echo '<hr color="blue">';

        //runner does not exist actully
        $is_not_exist = DB::table('users')->where('name','runner')->doesntExist();
        if($is_not_exist){
            echo 'your name does not exist';
        }else{
            echo 'your name is exist';
        }
        return;
        //return a view
        return view('database.builder',compact('all_info'));
    }

    //using select method in query builder laravel
    public function select(){

        $query = DB::table('users')->select('name');

        $info = $query->addSelect('email as user_email');
        $info = $query->addSelect('id');

        $info = $query->addSelect('password')->get();

        foreach ($info as $key => $value) {
            echo $value->id.' ******* ';
            echo $value->name.' ******* ';
            echo $value->user_email.' ******** ';
            echo $value->password.'<br >';
        }
        echo '<hr color="orange">';


    }

    //JOIN TABLES
    public function join(){
        $info = DB::table('users')
            ->join('test','users.id','=','test.user_id')
            ->select('users.name','test.age','test.city')
                ->get();

        foreach ($info as $key => $value) {
            echo $value->name.' ***** ';
            echo $value->age.' ***** ';
            echo $value->city.'<br >';
        }
    }

    //advande join in laravel
    public function advance(){
       $result = DB::table('users')
        ->join('test', function ($join) {
                            $join->on('users.id', '=', 'test.user_id')
                                ->where('users.id','>','1');
                        })
        ->get();

        dd($result);
    }


    //sub query join
    public function subquery(){
        $latestPosts = DB::table('users')
            ->select('id', DB::raw('MAX(created_at) as last_post_created_at'))
            ->where('id','>', 1)
            ->groupBy('id');

        $users = DB::table('test')
            ->joinSub($latestPosts, 'latest_posts', function ($join) {
                $join->on('test.user_id', '=', 'latest_posts.id');
            })->get();

        return $users;
    }


    //test validation in laravel
    public function testvalidation(){

        return view('test');
    }

    //get post data from form for validate it
    public function update(Request $request){
        $validatedData = $request->validate([
            'header' => 'required|max:255|min:5',
            'url' => 'required|max:255|min:10|url'
        ]);
        return 'you infomation was inseted into some place';
    }
}
