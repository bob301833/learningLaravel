<?php
use App\Post;
use App\User;
use App\Country;
use App\Photo;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*
Route::get('/about', function () {
    return 'Hi about page';
});

Route::get('/contact', function () {
    return 'HI I am contact';
});

Route::get('/post/{id}/{name}', function ($id, $name) {
    return 'This is post number:'.$id.'<br>This post name is '.$name;
});

Route::get('admin/posts/example', array('as' => 'admin.home', function () {
    $url = route('admin.home');

    return 'This url is '.$url;
}));
*/

//Route::get('/posts/{id}', 'PostController@index');

//Route::resource('posts','PostController');

//Route::get('/contact', 'PostController@contact');

//Route::get('post/{id}/{name}/{password}', 'PostController@show_post');

/*
|--------------------------------------------------------------------------
| DATABASE Raw SQL Queries
|--------------------------------------------------------------------------
*/


Route::get('/insert', function () {
    DB::insert('insert into posts (title, content) values (?, ?)', ['PHP with Laravel', 'Laravel is the best thing happend to PHP']);
});

Route::get('/read', function () {
    $results = DB::select('select * from posts where id=?', [1]);
    foreach($results as $post) {
        return $post->title;
    }
});

Route::get('/update', function () {
    $updated = DB::update('update posts set title = "Updated title" where id = ?', [1]);
    return $updated;
});

Route::get('/delete', function () {
    $deleted = DB::delete('delete from posts where id = ?', [1]);
    return $deleted;
});


/*
|--------------------------------------------------------------------------
| ELOQUENT
|--------------------------------------------------------------------------
*/

Route::get('/find', function () {
    //$posts = Post::find(1);
    $posts = Post::all();

    //return $posts;
    
    foreach($posts as $post) {
        return $post->title;
    }
});

Route::get('/findwhere', function() {
    //
    $posts = Post::where('id',3)->orderBy('id', 'desc')->take(1)->get();
    return $posts;

});

Route::get('/findmore', function () {
    $posts = Post::findOrFail(3);

    return $posts;

    //$posts = Post::where('users_count','<',50)->firstOrFail();
    


});

Route::get('/basicinsert', function() {
    $post = new Post;

    $post->title = 'new Eloquent title';
    $post->content = 'wow Eloquent is really cool, lookat this content';

    $post->save();
});

Route::get('/basicinsert2', function() {
    $post = Post::find(1);

    $post->title = 'new Eloquent title2';
    $post->content = 'wow Eloquent is really cool, lookat this content';

    $post->save();
});

Route::get('/create', function() {
    Post::create(['title' => 'the create method', 'content' => 'WOW I\'am learning laravel']);
});

Route::get('/update', function() {
    POST::where('id', 3)->where('is_admin', 0)->update(['title'=>'NEW PHP TITLE','content'=>'I love my instructor']);
});

Route::get('/delete', function() {
    $post = Post::find(1);
    $post->delete();
});

Route::get('/delete2', function() {
    //Post::destroy(3);
    //Post::where('is_admin', 0)->delete();
    Post::destroy([4, 5]);
});

Route::get('/softdelete', function() {
    Post::find(3)->delete();
});

Route::get('/readsoftdelete', function() {
    //$post = Post::find(5);
    //return $post;


    $post = Post::withTrashed()->where('is_admin',0)->get();
    return $post;

    // $post = Post::onlyTrashed()->where('is_admin',0)->get();
    // return $post;

});

Route::get('/restore/{id}' ,function($id) {
    Post::withTrashed()->where('id', $id)->restore();

});

Route::get('/forcedelete/{id}', function($id) {
    Post::withTrashed()->where('id', $id)->forceDelete();
});

/*
|--------------------------------------------------------------------------
| ELOQUENT Relationships
|--------------------------------------------------------------------------
*/

//One to One relationship
Route::get('/user/{id}/post', function($id) {
    return User::find($id)->post->content;
});

//inverse
Route::get('/post/{id}/user', function($id) {
    return Post::find($id)->user->name;
});

//One to Many relationship
Route::get('/posts/{id}', function($id) {
    $user = User::find($id);
    foreach($user->posts as $post){
        echo $post->title."<br>";
    }
});

//Many to Many relationship
Route::get('/user/{id}/role', function($id) {
    // $user = User::find($id);
    // foreach($user->roles as $role){
    //     echo $role->name."<br>";
    // }

    $user = User::find($id)->roles()->orderBy('id','desc')->get();
    return $user;
});

//Accessing the intermediate table / pivot

Route::get('/user/{id}/pivot', function($id) {
    $user = User::find($id);
    foreach($user->roles as $role){
        echo $role->pivot->created_at;
    }

});

Route::get('/user/country/{id}', function($id){
    $country = Country::find($id);

    foreach($country->posts as $post){
        echo $post->title;
    }
});

//Polymorphic Relations

Route::get('user/photos/{id}' ,function($id){
    $user = User::find($id);

    foreach($user->photos as $photo){
        echo $photo->path;
    }
});

Route::get('post/photos/{id}' ,function($id){
    $post = Post::find($id);

    foreach($post->photos as $photo){
        echo $photo->path.'<br>';
    }
});

//Polymorphic Relations inverse
Route::get('photo/{id}/owner', function($id){
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
});
