<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('continue/with-phone', 'ApiController@continueWithPhone')->withoutMiddleware('api');
Route::get('resend/phone-verification-code', 'ApiController@resendPhoneVerificationCode');
Route::post('verify/phone', 'ApiController@verifyPhone');

Route::post('continue/with-facebook', 'ApiController@continueWithFacebook')->withoutMiddleware('api');
Route::post('continue/with-instagram', 'ApiController@continueWithInstagram')->withoutMiddleware('api');

Route::post('update/location', 'ApiController@updateLocation');
Route::post('update/profile', 'ApiController@updateProfile');
Route::get('profile', 'ApiController@getProfile');

Route::post('like/user', 'ApiController@likeUser');
Route::post('dislike/user', 'ApiController@dislikeUser');

Route::get('match', 'ApiController@match');

Route::post('follow/user', 'ApiController@followUser');
Route::post('unfollow/user', 'ApiController@unfollowUser');

Route::post('block/user', 'ApiController@blockUser');
Route::post('unblock/user', 'ApiController@unblockUser');
Route::get('blocked-users', 'ApiController@blockedUsers');

Route::get('my/friends', 'ApiController@myFriends');
Route::get('pending/requests', 'ApiController@pendingRequests');
Route::get('sent/requests', 'ApiController@sentRequests');
Route::post('cancel/request', 'ApiController@cancelRequest');


Route::get('meet', 'ApiController@meet');
Route::post('update/filters', 'ApiController@updateFilters');
Route::get('get/filters','ApiController@getFilters');
Route::get('available-filters','ApiController@availableFilters');

Route::get('online-users', 'ApiController@getOnlineUsers');
Route::post('start/conversation', 'ApiController@startConversation');

Route::get('community', 'ApiController@community');
Route::post('create/post', 'ApiController@createPost');
Route::post('update/post/{id}', 'ApiController@updatePost');
Route::delete('delete/post/{id}', 'ApiController@deletePost');

Route::get('likedislike/post/{id}', 'ApiController@likeDislikePost');
Route::get('dislike/post/{id}', 'ApiController@dislikePost');
Route::get('post/likes', 'ApiController@postLikes');

Route::post('add/comment', 'ApiController@addComment');
Route::post('update/comment/{id}', 'ApiController@updateComment');
Route::delete('delete/comment/{id}', 'ApiController@deleteComment');
Route::get('post/comments', 'ApiController@postComments');

Route::get('user/posts','ApiController@userPosts');
Route::get('user/friends','ApiController@userFriends');
Route::get('post','ApiController@singlePost');
Route::get('posts','ApiController@getkikiPost');

Route::post('create/event', 'ApiController@createEvent');
Route::post('update/event/{id}', 'ApiController@updateEvent');
Route::delete('delete/event/{id}', 'ApiController@deleteEvent');

Route::post('create/report', 'ApiController@createReport');
Route::delete('delete/report/{id}', 'ApiController@deleteReport');

Route::post('attend/event', 'ApiController@attendEvent');
Route::get('event/attendants', 'ApiController@eventAttendants');
Route::get('events','ApiController@events');
Route::get('event','ApiController@event');

// Report api

Route::post('save/report','ApiController@saveReports');
Route::post('report/problem','ApiController@reportProblem');

//Get Category IDS

Route::get('/get/category/{catID}','ApiController@getCategoryIDs');

//Delete Account\

Route::delete('delete/account/{id}','ApiController@deleteAccount');

Route::post('upgrade', 'ApiController@upgrade');
Route::post('incognito', 'ApiController@incognito');

Route::post('rewind-swipes', 'ApiController@rewindSwipes');

Route::post('send/notification', 'ApiController@sendNotification')->withoutMiddleware('api');
Route::post('call', 'ApiController@call');
//Missed Call Notification
Route::post('missed-call-notification', 'ApiController@missedCallNotification');
Route::get('notifications','ApiController@notifications');

Route::get('/ad-images','ApiController@getAdImages')->withoutMiddleware('api');
Route::get('/intro-images','ApiController@getIntroImages')->withoutMiddleware('api');