<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', [
        'uses' => 'LogoutController@loggedOut',
         'as' => 'logout'
    ]);
    // Route::get('/dams', [
    //     'uses' => 'DamUpdateController@gotoDashboard',
    //     'as' => 'dams'
    // ]);
    Route::get('/chat', [
        'uses' => 'DashboardController@gotoDashboard',
        'as' => 'chat'
    ]);
    Route::get('/tides', [
        'uses' => 'DashboardController@gotoDashboard',
        'as' => 'tides'
    ]);
    Route::get('/administrator', [
        'uses' => 'DashboardController@gotoDashboard',
        'as' => 'reports'
    ]);
    Route::get('/weather', [
        'uses' => 'DashboardController@gotoDashboard',
        'as' => 'weather'
    ]);

    Route::get('/assign', [
      'uses' => 'DashboardController@gotoDashboard',
      'as' => 'assign'
  ]);

  Route::get('/teams', [
    'uses' => 'DashboardController@gotoDashboard',
    'as' => 'teams'
  ]);

  Route::get('/settings', [
    'uses' => 'DashboardController@gotoDashboard',
    'as' => 'settings'
  ]);

  //teamleaders
  Route::post('/teams/add', 'TeamLeaderController@addMember');
  Route::get('/teams/get', 'TeamLeaderController@getMember');
  Route::get('/teams/get/{municipality?}', 'TeamLeaderController@getMembersByMunicipality');
  Route::put('/teams/update/{id?}', 'TeamLeaderController@editMember');
  //rescuers
  Route::post('/rescue/members', 'RescuerController@addMember');
  Route::put('/rescue/members/{id?}', 'RescuerController@editUser');
  Route::delete('/rescue/members/{id?}', 'RescuerController@deleteUser');
  Route::get('/rescue/members/get/{municipality?}', 'RescuerController@getMembers');
  //rescuer notification
  Route::get('/rescue/notifications', 'GPSController@getAllNotifications');
  Route::get('/rescue/name/{id?}', 'GPSController@getSpecificNotification');
  //block
  Route::get('/users', 'AccessControlController@getAllUsers');
  Route::put('/users/{id}', 'AccessControlController@blockUser');
  Route::get('/users/sort/{key?}', 'AccessControlController@sortUsers');
  //reports
  Route::get('/reports/total/{date?}', 'SendReportController@getTodaysTotalReports');
  Route::get('/reports/range/{date?}/{address?}/{type?}', 'SendReportController@getReportRangeDates');
  Route::get('/reports/orderby/{date?}/{type?}/{address?}', 'SendReportController@getReportsByDate');
  Route::get('/reports/total/{date?}/{type?}/{address?}', 'SendReportController@getTotalReports');
});

/** AUTH */

  
    Route::post('/register', [
        'uses' => 'RegisterController@createUser',
        'as' => 'register'
    ]);

    Route::post('/login', [
        'uses' => 'LoginController@loggedIn',
        'as' => 'login'
    ])->middleware('login');

    Route::get('/login', [
      'uses' => 'LoginController@gotoLogin',
        'as' => 'login'
    ]);

    Route::get('/register', [
      'uses' => 'RegisterController@gotoRegister',
      'as' => 'register'
    ]);

    Route::get('/forgot', [
        'uses' => 'ForgotPasswordController@gotoForgot',
        'as' => 'forgot'
    ]);

    /** user */

    Route::get('/', [
        'uses' => 'HomeController@gotoIndex',
        'as' => 'home'
    ]);

    Route::get('/about', [
        'uses' => 'AboutController@gotoAbout',
        'as' => 'about'
    ]);

    Route::get('/contacts', [
        'uses' => 'ContactsController@gotoContacts',
        'as' => 'contacts'
    ]);

    Route::get('/send', [
        'uses' => 'SendReportController@gotoSendReport',
        'as' => 'report'
    ]);
    /**mails */

    Route::get('/user/verify/{code}', 'RegisterController@verifyUser');
    Route::post('/forgot', [
        'uses' => 'RegisterController@recover',
        'as' => 'forgot'
    ]);
    Route::get('/password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset/', [
      'uses' => 'SetNewPasswordController@setNewPassword' ,
        'as' => 'reset'
    ]);

    /**rescue */

    Route::get('/rescue', [
        'uses' => 'GPSController@gotoRescue',
        'as' => 'rescue'
    ]);
    
    Route::post('/rescue/message', 'RescuerController@sendMessage');
    Route::get('/rescue/messages/all', 'RescuerController@getMessage');
    Route::get('/rescue/login/user/{password?}', 'GPSController@verifyRescuer');
    Route::get('/rescue/locate/{lat?}/{lng?}', 'GPSController@locateRescuer');
    Route::put('/rescue/add/{lat?}/{lng?}/{password?}', 'GPSController@updateLocation');
    Route::put('/rescue/reset/{id?}', 'GPSController@resetLocation');

    /**endpoints */

    Route::get('/notifications', 'ChatController@readMessageNotifications');
    //tides
    Route::post('/tides/add', 'TidesController@saveTideUpdates');
    Route::get('/tides/timeseries', 'TidesController@getTimeSeries');
    Route::get('/search/tides', 'HomeController@getHighTides');
    Route::get('/tides/latest', 'TidesController@newTideUpdates');
    //dam
    Route::post('/dams/add', 'DamUpdateController@updateDams');
    Route::get('/dams/status/angat', 'DamUpdateController@getAngatDamUpdates');
    Route::get('/dams/status/bustos', 'DamUpdateController@getBustosDamUpdates');
    Route::get('/dams/status/ipo', 'DamUpdateController@getIpoDamUpdates');
    //chat
    Route::get('/messages/{format?}', 'ChatController@getMessages');
    Route::post('/messages', 'ChatController@postMessages');
    //report
    Route::get('/reports/summary/get/{municipality?}/{status?}', 'SendReportController@getUndoneReports');
    Route::post('/reports/add', 'SendReportController@sendReport');
    Route::get('/reports/results/{municipality?}', 'SendReportController@getReports');
    Route::get('/reports/all', 'SendReportController@getAllReports');
    Route::get('/reports/{address?}/{status?}', 'SendReportController@queryPlaces');
    Route::get('reports/get/{municipality?}', 'SendReportController@getReportsByLocation'); 
    Route::get('/reports/stats/landmarks/{address?}/{date?}/{type?}/{landmark?}', 'SendReportController@queryReportLandmarks');
    Route::get('/reports/stats/address/{address?}/{date?}/{type?}', 'SendReportController@queryReports');
    Route::get('/reports/status/all/{status?}/{municipality?}', 'SendReportController@queryNotDone');
    Route::put('/reports/status/update/{status?}/{id?}', 'SendReportController@updateReportStatus');
    Route::get('/reports/barangays/{address?}/{status?}', 'SendReportController@getReportsByBarangay');
    Route::get('/reports/today/{status?}/{date?}', 'SendReportController@getTodaysReport');

    //tools
    Route::get('/geocode/{address?}', 'GoogleMapsController@geoCode');
    Route::get('/directions/{origin?}/{destination?}', 'GoogleMapsController@getDirections');
    //weather
    Route::get('/weather/get/{lat?}/{lng?}', 'WeatherNotificationsController@getWeatherUpdate');
    //gps
    Route::post('/rescue/notify/{id?}', 'GPSController@notifyInSite');

