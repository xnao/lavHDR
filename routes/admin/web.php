<?php
Route::get('/abc',function(){
   return "ABC";
});

Route::group(['prefix'=>'/admin','namespace'=>'admin'],function(){
    //namespace: indicates all the router works under the admin folder
    //namespace is NOT case sensitive

   Route::get('/aff',function(){
       return "AFF";
   });
   //if not use namespace,then in the router need to use the full path
//   Route::get('login',['uses'=>'admin\EntryController@login']);

    //this is used namespace, so don't need to indicate admin
   Route::get('login',['uses'=>'EntryController@loginForm']);
   Route::post('login',['uses'=>'EntryController@login']);

   //admin logout
    Route::get('logout',['uses'=>'EntryController@logout']);

   //admin index page
   Route::any('index','entrycontroller@index');

   //manage Admin Info Router
   Route::get('adminInfo',['uses'=>'AdminController@info']);
   //change admin password
   Route::post('changepwd',['uses'=>'AdminController@changepwd']);
   //delete admin
    Route::post('adminDel',['uses'=>'AdminController@adminDel']);
});