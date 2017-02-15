<?php
use App\Post;

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
/*
Route::get('/', function () {
    return view('welcome');
});

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
