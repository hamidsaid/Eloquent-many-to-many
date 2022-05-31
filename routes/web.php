<?php

use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create/{id}', function($user_id){
    //find the user that we want to enroll to a course
    $user = User::findOrFail($user_id);
    //instantiate a course
   // $course = new Course(['name'=>'Logic and Semantics', 'course_code'=>'mt249']);
   $course = new Course(['name'=>'Algorithms and Complexity', 'course_code'=>'1S239']);

  

    $user->courses()->save($course);
    
});

Route::get('/enroll/{id}', function($id){
    //enroll an existing course
    $user = User::findOrFail($id);
    $course = Course::find(2);

    $user->courses()->save($course);
    //you can also use attach()
    //avoid duplicates
   // $user->courses()->attach(7);
    //unenroll
    //$user->courses()->detach(2);
    return "enrolled to ". $course->name;
});


Route::get('/read/{id}', function($user_id){
    $user = User::findOrFail($user_id);

    echo $user->name . " is enrolled to :<br>";
    $numb = 1;
    foreach($user->courses as $course){
        echo $numb .". ". $course->name . "<br>";
        $numb++;
    }
});

Route::get('update/{id}' ,function($id){
    $user = User::findOrFail($id);
    //check if user is enrolled in any course
    //has is used to check if a user has a relatioship any many more
    //check docs
    if($user->has('courses')){
        foreach($user->courses as $course){
            if($course->course_code == 'IS239'){
                $course->name = 'Algorithms and Complexity';
                $course->save();
            }
        }
    }
});

Route::get('/delete', function(){
    $user = User::findOrFail(1);

    //this deletes all courses enrolled by this user
    //$user->courses()->delete();

    //deletes one
    foreach( $user->courses as $course){
         $course->whereId(2)->delete();
    }
   
});

Route::get('/sync/{id}', function ($id){
    $user = User::findOrFail($id);

    $user->courses()->sync([1,6,7]);
});