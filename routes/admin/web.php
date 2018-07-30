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

    //tab management
    Route::any('tab',['uses'=>'TabController@tabList']);
    //tab add
    Route::any('tabAdd',['uses'=>'TabController@tabAdd']);
    //tab edit
    Route::get('tabEdit/{id?}',['uses'=>'TabController@tabEdit']);
    //tab DELETE
    Route::post('tabDel',['uses'=>'TabController@tabDel']);


    //memerb management
    //memberlist
    Route::get('memberList',['uses'=>'memberController@memberList']);
    //member add
    Route::any('memberAdd',['uses'=>'memberController@memberAdd']);
    //editmemberdetails
    Route::any('memberEdit/{id?}',['uses'=>'memberController@memberEdit']);
    //change password
    Route::any('memberCpwd/{id?}',['uses'=>'memberController@changePassword']);

    //delete Member, DELETE 测试
    Route::delete('memberDel/{id?}',['uses'=>'memberController@memberDel']);


    //phpSpreadsheet test
    Route::any('excelBasic1',['uses'=>'excelController@basic1']);
    Route::any('excelBasic2',['uses'=>'excelController@basic2']);
    Route::any('excelBasic3',['uses'=>'excelController@basic3']);


    //********************crawler*************************//
    Route::get('crawl/{url?}',['uses'=>'crawlController@index']);


    //********************UPload mmmmmulity file test*************************//
    Route::get('upload',['uses'=>'uploadController@index']);
    Route::post('upload',['uses'=>'uploadController@upload']);





});
