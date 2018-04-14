<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Admin.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat', function ($user) {
    return $user;
  });

Broadcast::channel('sent-reports', function ($reports) {
    return $reports;
  });

Broadcast::channel('tide-updates', function($tideUpdates) {
  return $tideUpdates;
});

Broadcast::channel('results', function($result) {
  return $result;
});

Broadcast::channel('NewMessages', function ($message) {
  return $message;
});

Broadcast::channel('block', function ($admin) {
  return $admin;
});

Broadcast::channel('rescuers', function ($rescuer) {
  return $rescuer;
});