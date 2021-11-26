<?php

namespace App\Http\Controllers;

use App\AdminSetting;
use App\blockedUser;
use App\KikiPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\User;
use App\kikiReport;
use App\Report;
use App\Event;
use App\Post;
use App\UserReport;
use App\LikeDislike;
use App\Like;
use App\UserMatch;
use App\Comment;
use App\Follower;
use App\Message;
use App\Conversation;
use App\EventUser;
use App\AdImage;
use App\IntroImage;
use App\Notifications\Match;
use App\Notifications\UserLiked;
use App\Events\NewMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Agora\RtcTokenBuilder\RtcTokenBuilder;

class ApiController extends Controller
{
    public function continueWithPhone(Request $request)
    {
        $user = User::withTrashed()->where('phone', $request->phone)->first();
        if (!$user) {
            $user = new User();
            $user->phone = $request->phone;
            $user->last_online = Carbon::now();
            $user->generateAuthToken();
            $user->save();
        }

        if ($user->trashed()) $user->restore();

        if ($request->device_token) $user->update(['device_token' => $request->device_token]);

        $response = [
            'success' => true,
            'message' => 'Signed in using Phone',
            'user' => User::find($user->id)
        ];

        return response()->json($response);
    }

    public function continueWithFacebook(Request $request)
    {
        $user = User::withTrashed()->where('facebook', $request->uid)->first();
        if (!$user) {
            $user = new User();
            $user->facebook = $request->uid;
            $user->fill($request->all());
            $user->last_online = Carbon::now();
            $user->generateAuthToken();
            $user->save();
        }

        if ($user->trashed()) $user->restore();

        if ($request->device_token) $user->update(['device_token' => $request->device_token]);

        $response = [
            'success' => true,
            'message' => 'Signed in using Facebook',
            'user' => User::find($user->id)
        ];

        return response()->json($response);
    }

    public function continueWithInstagram(Request $request)
    {
        $user = User::withTrashed()->where('instagram', $request->uid)->first();
        if (!$user) {
            $user = new User();
            $user->instagram = $request->uid;
            $user->fill($request->all());
            $user->last_online = Carbon::now();
            $user->generateAuthToken();
            $user->save();
        }

        if ($user->trashed()) $user->restore();

        if ($request->device_token) $user->update(['device_token' => $request->device_token]);

        $response = [
            'success' => true,
            'message' => 'Signed in using Instagram',
            'user' => User::find($user->id)
        ];

        return response()->json($response);
    }

    public function resendPhoneVerificationCode()
    {
        if (Auth::user()->sendPhoneVerificationCode()) {

            $response = [
                'success' => true,
                'message' => 'Phone verification code has been sent successfully'
            ];

            return response()->json($response);
        }

        $response = [
            'success' => false,
            'message' => 'Could not send phone verification code. Try again'
        ];

        return response()->json($response);
    }

    public function verifyPhone(Request $request)
    {
        $user = Auth::user();
        $status = $user->verifyPhoneVerificationCode($request->code);
        
        if ($status === 'internet') {
            $response = [
                'success' => false,
                'message' => 'Phone number could not be verified. Check your internet connection'
            ];
        } elseif ($status === 'expired') {
            $response = [
                'success' => false,
                'message' => 'Phone verification code expired. Request resending new code'
            ];
        } elseif ($status) {
            $user->update(['phone_verified' => 1]);
            $response = [
                'success' => true,
                'message' => 'Phone number has been verified successfully',
                'data' => [
                    'user' => $user
                ]
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Phone verification code is incorrect'
            ];
        }

        return response()->json($response);
    }

    public function updateLocation(Request $request)
    {
        Auth::user()->update($request->only(['latitude', 'longitude']));

        $response = [
            'success' => true,
            'message' => 'Location has been updated successfully'
        ];

        return response()->json($response);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users,email,'. $user->id
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'message' => $validator->errors()->first()
            ];

            return response()->json($response);
        }

        if ($request->new_pics) {
            $user->addProfilePics($request->new_pics);
        }

        if ($request->deleted_pics) {
            $user->deleteProfilePics($request->deleted_pics);
        }

        $user->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Profile has been updated successfully',
            'user' => User::find($user->id)
        ];

        return response()->json($response);
    }

    public function getProfile(Request $request)
    {
        $response = [
            'success' => true,
            'user' => User::with('profile_pics:id,path,user_id')
                ->selectRaw('*,
                    (SELECT COUNT(*)
                    FROM followers
                    WHERE following_id IN(
                        SELECT follower_id FROM followers WHERE following_id = users.id GROUP BY following_id) AND follower_id = users.id
                    ) AS friends_count')
                ->where('id', $request->user_id ?: Auth::user()->id)
                ->first()
        ];

        return response()->json($response);
    }

    public function likeUser(Request $request)
    {
        $user = Auth::user();

        DB::table('user_swipes')->insert([
            'user_id' => $user->id,
            'swiped_id' => $request->id,
            'action' => 'liked'
        ]);

        $liked_user = User::find($request->id);

        LikeDislike::updateOrCreate([
            'liker_id' => $user->id,
            'user_id' => $request->id
        ]);

        $likes = $user->likes()->pluck('liker_id')->toArray();

        if (in_array($request->id, $likes)) {

            /*$match = new UserMatch();
            $match->user1_id = $request->id;
            $match->user2_id = $user->id;
            $match->save();*/

            UserMatch::updateOrCreate([
                'user1_id' => $request->id,
                'user2_id' => $user->id
            ]);

            $notification = [
                'title' => 'User Match',
                'body' => 'Hooray! It’s a MATCH. You can now connect with ' . $user->name . '.',
                'type' => 'match'
            ] + $user->only(['id', 'profile_pic']);

            $liked_user->sendNotification($notification);

            $notification = [
                'title' => 'User Match',
                'body' => 'Hooray! It’s a MATCH. You can now connect with ' . $liked_user->name . '.',
                'type' => 'match'
            ] + $liked_user->only(['id', 'profile_pic']);

            $user->sendNotification($notification);
        }

        $response = [
            'success' => true,
            'message' => 'Liked user successfully'
        ];
        
        return response()->json($response);
    }
    
    public function match()
    {
        $user = Auth::user();
        $likes = $user->likes();

        $response = [
            'success' => true,
            'message' => 'Match user successfully',
            'likes' => $likes->select(['users.id', 'profile_pic'])->get(),
            'matches' => $user->liked()
                ->whereIn('user_id', $likes->pluck('users.id')->toArray())
                ->select(['users.id', 'name', 'profile_pic', 'last_online', 'incognito'])
                ->get()
        ];

        return response()->json($response);
    }

    public function dislikeUser(Request $request)
    {
        $user = Auth::user();

        LikeDislike::updateOrCreate([
            'disliker_id' => $user->id,
            'user_id' => $request->id
        ]);

        DB::table('user_swipes')->insert([
            'user_id' => $user->id,
            'swiped_id' => $request->id,
            'action' => 'disliked'
        ]);

        $response = [
            'success' => true,
            'message' => 'Disliked user successfully'
        ];

        return response()->json($response);
    }

    public function followUser(Request $request)
    {
        $user = Auth::user();

        User::find($request->id)->followers()->sync([
            'follower_id' => $user->id
        ]);

        DB::table('user_swipes')->updateOrInsert([
            'user_id' => $user->id,
            'swiped_id' => $request->id,
            'action' => 'followed'
        ]);

        $response = [
            'success' => true,
            'message' => 'Followed user successfully'
        ];

        return response()->json($response);
    }

    public function unfollowUser(Request $request)
    {
        User::find($request->id)->followers()->detach([
            'follower_id' => Auth::user()->id
        ]);

        $deleteArr = [
            'user_id' => Auth::user()->id,
            'swiped_id' => $request->id,
            'action' => 'followed'
        ];
        DB::table('user_swipes')->where($deleteArr)->delete();
        
        $response = [
            'success' => true,
            'message' => 'Un-followed user successfully'
        ];

        return response()->json($response);
    }

    public function blockUser(Request $request)
    {
        $user=User::find($request->id);

        $user->blockedBy()->attach([
            'blocked_by' => Auth::user()->id
        ]);

        $blockedIds = $user->blockedBy->pluck('id')->toArray();

        Follower::where('follower_id',$blockedIds)->delete();

        $response = [
            'success' => true,
            'message' => 'Blocked user successfully'
        ];

        return response()->json($response);
    }

    public function unblockUser(Request $request)
    {
        User::find($request->id)->blockedBy()->detach([
            'blocked_by' => Auth::user()->id
        ]);

        $response = [
            'success' => true,
            'message' => 'user un-blocked successfully'
        ];

        return response()->json($response);
    }

    public function blockedUsers()
    {
        $response = [
            'success' => true,
            'blocked_users' => Auth::user()->blockedUsers()->get()
        ];

        return response()->json($response);
    }

    public function deleteAccount($id){

        $user =User::where('id',$id)->first();
        if ($user != null) {
            $user->delete();

        }


        $response = [
            'success' => true,
            'message' => 'Account deleted  successfully'
        ];

        return response()->json($response);

    }

    public function restoreDeletedProjects($id)
    {

        $project = Project::where('id', $id)->withTrashed()->first();

        $project->restore();

        return redirect()->route('projects.index')
            ->with('success', 'You successfully restored the project');
    }

    public function sentRequests(Request $request)
    {
        $user = Auth::user();

        $response = [
            'next_offset' => (int)$request->offset + 20,
            'Sent requests' => $user->following()
                ->whereNotIn('following_id', $user->followers()->pluck('users.id')->toArray())
                ->select(['users.id', 'name', 'profile_pic'])
                ->orderBy('users.created_at', 'desc')
                ->take(20)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);
    }

    public function cancelRequest(Request $request)
    {
        User::find($request->id)->followers()->detach([
            'follower_id' => Auth::user()->id
        ]);

        $response = [
            'success' => true,
            'message' => 'Request Cancel successfully'
        ];

        return response()->json($response);
    }

    public function pendingRequests(Request $request)
    {
        $user = Auth::user();
        
        $response = [
            'next_offset' => (int)$request->offset + 20,
            'Pending requests' => $user->followers()
                ->whereNotIn('follower_id', $user->following()->pluck('users.id')->toArray())
                ->select(['users.id', 'name', 'profile_pic'])
                ->orderBy('users.created_at', 'desc')
                ->take(20)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);
    }

    public function myFriends(Request $request)
    {
        $user = Auth::user();

        $response = [
            'next_offset' => (int)$request->offset + 20,
            'friends' => $user->following()
                ->whereIn('following_id', $user->followers()->pluck('users.id')->toArray())
                ->select(['users.id', 'name', 'profile_pic'])
                ->orderBy('followers.created_at', 'desc')
                ->take(20)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);
    }

    public function userFriends(Request $request)
    {
        $user = User::find($request->user_id);

        $response = [
            'next_offset' => (int)$request->offset + 20,
            'friends' => $user->following()
                ->whereIn('following_id', $user->followers()->pluck('users.id')->toArray())
                ->select(['users.id', 'name', 'profile_pic'])
                ->orderBy('followers.created_at', 'desc')
                ->take(20)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);
    }

    public function updateFilters(Request $request)
    {
        $user = Auth::user();
        $user->filters()
            ->updateOrCreate(['user_id' => $user->id], $request->all());

        $response = [
            'success' => true,
            'message' => 'Filters have been updated successfully'
        ];

        return response()->json($response);
    }

    public function meet(Request $request)
    {
        $user = Auth::user();

        $sqlDistance = function ($user, $earth_radius = 6371) {

            return '( ' . $earth_radius . ' * acos( cos( radians('. $user->latitude .') )
                        * cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians('. $user->longitude .') )
                        + sin( radians('. $user->latitude .') )
                        * sin( radians( latitude ) ) ) )';
        };

        $query = User::selectRaw("*, YEAR(CURDATE()) - YEAR(birthday) AS age,
                (SELECT COUNT(*)
                FROM followers
                WHERE following_id IN(
                    SELECT follower_id FROM followers WHERE following_id = users.id GROUP BY following_id) AND follower_id = users.id
                ) AS friends_count");

        $filters = $user->filters()->first();

        if ($filters) {

            foreach ($filters->toArray() as $key => $value) {

                if (!in_array($key, ['id', 'from_age', 'to_age', 'distance', 'distance_in', 'last_online', 'user_id', 'created_at', 'updated_at']) && $value) {
                    $query->where($key, $value);
                }

                if ($key == 'from_age' && $value) {

                    $query->having('age', '>=', (int)$value);
                }

                if ($key == 'to_age' && $value) {

                    $query->having('age', '<=', (int)$value);
                }

                if ($key == 'distance' && $value) {

                    $earth_radius = $filters['distance_in'] == 'km' ? 6371 : 3959;

                    $query->selectRaw("CONCAT(ROUND(". $sqlDistance($user, $earth_radius) .", 1), '" . $filters['distance_in'] . "') AS distance")
                        ->having('distance', '<=', (int)$value);
                }
            }

        } else {

            $query->selectRaw("CONCAT(ROUND(". $sqlDistance($user) .", 1), 'km') AS distance");
                // ->having('distance', '<=', 10);
        }

        $swiped_ids = DB::table('user_swipes')
            ->where('user_id', $user->id)
            ->pluck('swiped_id')
            ->toArray();

        $blocked_ids = DB::table('blocked_users')
            ->where('blocked_by', $user->id)
            ->pluck('user_id')
            ->toArray();

        $users = $query->where([
            ['id', '<>', $user->id],
            ['role', '<>', 'admin'],
            ['incognito', '=', 0]
        ])
        ->whereNotIn('id', array_merge($swiped_ids , $blocked_ids))
        ->get();
        
        $response = [
            'success' => true,
            'message' => 'Profiles have been fetched successfully',
            'users' => $users
        ];

        return response()->json($response);
    }

    public function getFilters()
    {
        $response = [
            'success' => true,
            'message' => 'Filters have been fetched successfully',
            'filters' => Auth::user()->filters()->first()
        ];

        return response()->json($response);
    }

    public function community(Request $request)
    {
        $user_id = Auth::user()->id;
        $posts_id = Like::where('user_id', $user_id)->pluck('post_id')->toArray();

        // $following = Follower::where('follower_id', $user_id)->pluck('following_id');
        // $following->prepend($user_id);
        // if (!$following->count()) {
        //     return response()->json('No following');
        // }

        $ads = AdImage::take(2)
            ->orderBy('created_at', 'desc')
            ->offset($request->offset ? ($request->offset / 10) + 1 : 0)
            ->get();

        if ($ads->count() < 2) {
            $ads = AdImage::take(2)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $response = [
            'success' => true,
            'message' => 'Community post fetch successfully',
            'next_offset' => (int)$request->offset + 10,
            'posts' => Post::with('media:id,path,post_id,user_id')
                ->withCount(['likes', 'comments'])
                ->with('user:id,name,profile_pic')
                // ->whereIn('user_id', $following->toArray())
                ->selectRaw(($posts_id ? 'IF(`posts`.id IN('.implode(',', $posts_id).'), 1, 0) AS IsLiked' : "0 as IsLiked") . ", null AS path, null AS link")
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->offset($request->offset)
                ->get()->map(function($post, $key) use($ads) {

                    if ($key == 4) {
                        $post->path = $ads[0]['path'];
                        $post->link = $ads[0]['link'];
                    } elseif ($key == 9) {
                        $post->path = $ads[1]['path'];
                        $post->link = $ads[1]['link'];
                    }

                    return $post;
                })
        ];

        return response()->json($response);
    }

    public function events(Request $request)
    {
        $response = [
            'next_offset' => (int)$request->offset + 10,
            'events' => Event::with(['attendants' => function($q){
                return $q->select(['user_id','name','profile_pic']);
            }])

            ->with(['user' => function($q) {
                return $q->select(['users.id', 'name', 'profile_pic']);
            }])

            ->withCount('attendants')
            ->orderBy('updated_at', 'desc')
            ->offset($request->offset)
            ->take(10)
            ->get()
        ];

        return response()->json($response);
    }

    public function event(Request $request)
    {
        $response = [
            'success' => true,
            'event' => Event::with(['attendants' => function($q){
                return $q->select(['user_id','name','profile_pic']);
            }])
            ->with(['user' => function($q) {
                return $q->select(['users.id', 'name', 'profile_pic']);
            }])
            ->where('id', $request->id)
            ->first()
        ];

        return response()->json($response);
    }

    public function createPost(Request $request)
    {
        $post = new Post();

        $post->body = $request->body;
        $post->user_id = $request->kikii ? null : Auth::user()->id;
        $post->save();

        if ($request->media) {
            $post->insertMedia($request->media);
        }

        $response = [
            'success' => true,
            'message' => 'Post has been created successfully',
            'post' => Post::with('media:id,path,post_id,user_id')
                ->where('id', $post->id)
                ->first()
        ];

        return response()->json($response);
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());

        if ($request->new_media) {
            $post->insertMedia($request->new_media);
        }

        if ($request->deleted_media_ids) {
            $post->deleteMedia($request->deleted_media_ids);
        }

        $response = [
            'success' => true,
            'message' => 'Post has been updated successfully',
            'post' => Post::with('media:id,path,post_id,user_id')
                ->where('id', $post->id)
                ->first()
        ];

        return response()->json($response);
    }

    public function userPosts(Request $request)
    {
        $user_id = Auth::user()->id;
        $posts_id = Like::where('user_id', $user_id)->pluck('post_id')->toArray();

        $response = [
            'success' => true,
            'message' => 'Single user posts',
            'next_offset' => (int)$request->offset + 10,
            'posts' => Post::with('media:id,path,post_id,user_id')
                ->withCount(['likes', 'comments'])
                ->with('user:id,name,profile_pic')
                ->where('user_id', $request->user_id)
                ->selectRaw($posts_id ? 'IF(`posts`.id IN('.implode(',', $posts_id).'), 1, 0) AS IsLiked' : "0 as IsLiked")
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);
    }

    public function singlePost(Request $request)
    {
        $posts_id = Like::where('user_id', Auth::user()->id)->pluck('post_id')->toArray();

        $response = [
            'success' => true,
            'message' => 'Single post',
            'post' => Post::with('media:id,path,post_id,user_id')
                ->withCount(['likes', 'comments'])
                ->with(['comments' => function($q){
                    return $q->with('user:id,name,profile_pic')
                        ->with(['replies' => function($q) {
                            return $q->with('user:id,name,profile_pic');
                        }])
                        ->take(20);
                }])
                ->with('user:id,name,profile_pic')
                ->where('id', $request->id)
                ->selectRaw($posts_id ? 'IF(`posts`.id IN('.implode(',', $posts_id).'), 1, 0) AS IsLiked' : "0 as IsLiked")
                ->first()
        ];

        return response()->json($response);
    }

    public function deletePost($id)
    {
        $post =Post::where('id',$id)->firstOrFail();

        $post->deleteMedia();
        $post->delete();

        $response = [
            'success' => true,
            'message' => 'Post has been deleted successfully'
        ];

        return response()->json($response);
    } 

    public function likeDislikePost($id)
    {

        $is_like = Like::where(['user_id' =>  Auth::user()->id,'post_id' => $id])->exists();
       
        if($is_like){

            Post::find($id)->likes()->detach([
                'user_id' => Auth::user()->id
            ]);

            $response = [
                'success' => true,
                'message' => 'Disliked post successfully'
            ];

            return response()->json($response);

        }

        $post = Post::find($id);
        $post->likes()->attach([
            'user_id' => Auth::user()->id
        ]);
        //Notification
        $post_id = $post->id;
        $post_user_id = $post->user_id;
        $post_user = User::find($post_user_id);
        $user = Auth::user();
        $notification = [
                'title' => 'Post Like',
                'body' => 'Your post was liked by  ' . $user->name . '.',
                'type' => 'post_like',
                'post_id' => $post_id
            ] + $user->only(['id', 'profile_pic']);
        $post_user->sendNotification($notification);

        $response = [
            'success' => true,
            'message' => 'Liked post successfully'
        ];

        return response()->json($response);

    }

    // public function dislikePost($id)
    // {
    //     Post::find($id)->likes()->detach([
    //         'user_id' => Auth::user()->id
    //     ]);

    //     $response = [
    //         'success' => true,
    //         'message' => 'Disliked post successfully'
    //     ];

    //     return response()->json($response);
    // }

    public function postLikes(Request $request)
    {
        $user_id = Auth::user()->id;
        $following = Follower::where('follower_id', $user_id)->pluck('following_id')->toArray();

        $select = [
            'id', 'name', 'profile_pic'
        ];

        if ($following) {
            array_push($select, \DB::raw('IF(`users`.id IN('.implode(',', $following).'), 1, 0) AS following'));
        }

        $response = [
            'next_offset' => (int)$request->offset + 30,
            'likes' => Like::with(['user' => function($q) use ($select) {
                return $q->select($select);
            }])
            ->orderBy('updated_at', 'desc')
            ->take(30)
            ->offset($request->offset)
            ->where('post_id', $request->post_id)
            ->get()
        ];

        return response()->json($response);
    }

    public function addComment(Request $request)
    {
        // dd($request->all());

        $comment = new Comment();
        $post = '';
         if ($request->post_id) {
            $comment->post_id = $request->post_id;
        } elseif($request->comment_id) {
            $comment->comment_id = $request->comment_id;
        }

        $comment->body = $request->body;

        if ($request->post_id) {
            $comment->post_id = $request->post_id;
        } elseif($request->comment_id) {
            $comment->comment_id = $request->comment_id;
        }

        $comment->user_id = Auth::user()->id;
        $comment->save();

        if ($request->media) {
            $comment->insertMedia($request->media);
        }

        //Notification
        if ($request->post_id) {
            $post = Post::find($request->post_id);
            $post_id = $post->id;
            $notify_user_id = $post->user_id;
            $title = 'Post Comment';
            $body = " commented on your post.";
        } elseif($request->comment_id) {
            $post_comment = Comment::find($request->comment_id);
            $post = Post::find($post_comment->post_id);
            $post_id = $post->id;
            $comment->comment_id = $request->comment_id;
            $notify_user_id = $post_comment->user_id;
            $title = 'Comment Reply';
            $body = " replied to your comment.";
        }

        
        $notify_user = User::find($notify_user_id);
        $user = Auth::user();
        $notification = [
                'title' => $title,
                'body' => $user->name . $body,
                'type' => 'post_comment',
                'post_id' => $post_id,
                'comment_id' => $comment->id
            ] + $user->only(['id', 'profile_pic']);
        $notify_user->sendNotification($notification);

        $response = [
            'success' => true,
            'message' => 'Comment has been added successfully',
             'comment' => Comment:: with('media:id,path,comment_id,user_id')->with('user:id,name,profile_pic')
                ->where('id', $comment->id)
                ->first()
        ];

        return response()->json($response);
    }

    public function updateComment(Request $request, $id)
    {
        Comment::find($id)->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Comment has been updated successfully'
        ];

        return response()->json($response);
    }

    public function deleteComment($id)
    {
        
        $comment=Comment::findorFail($id);
        if($comment){
            $comment->delete();

             $response = [
            'success' => true,
            'message' => 'Comment has been deleted successfully'
        ];
        } 
       
        return response()->json($response);
    }

    public function postComments(Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'Comment has been fetch successfully',
            'next_offset' => (int)$request->offset + 20,
            'comments' => Comment::with('user:id,name,profile_pic')
                ->with(['replies' => function($q) {
                    return $q->with('user:id,name,profile_pic');
                }])
                ->orderBy('updated_at', 'desc')
                ->take(20)
                ->offset($request->offset)
                ->where('post_id', $request->post_id)
                ->get()
        ];

        return response()->json($response);
    }

    public function createEvent(Request $request)
    {
        $event = new Event();

        $event->fill($request->all());
        $event->user_id = Auth::user()->id;
        $event->save();

        $response = [
            'success' => true,
            'message' => 'Event has been created successfully',
            'event' => $event
        ];

        return response()->json($response);
    }

    public function updateEvent(Request $request, $id)
    {
        Event::update($request->all())->where('id', $id);

        $response = [
            'success' => true,
            'message' => 'Event has been updated successfully'
        ];

        return response()->json($response);
    }

    public function deleteEvent($id)
    {
        Event::destroy($id);

        $response = [
            'success' => true,
            'message' => 'Event has been deleted successfully'
        ];

        return response()->json($response);
    }

    public function attendEvent(Request $request)
    {

        $is_attend = EventUser::where(['user_id' =>  Auth::user()->id])->exists();
       
        if($is_attend){
            Event::find($request->id)->attendants()->detach([
                'user_id' => Auth::user()->id
            ]);

            $response = [
                'success' => false,
                'message' => 'attendand not added successfully'
            ];

            return response()->json($response);
        }

        Event::find($request->id)->attendants()->attach([
            'user_id' => Auth::user()->id
        ]);

        $response = [
            'success' => true,
            'message' => 'Event attendant successfully'
        ];

        return response()->json($response);

    }

    public function getkikiPost(Request $request){

        $user_id=Auth::user()->id;

        $posts_id = Like::where('user_id', $user_id)->pluck('post_id')->toArray();



        $response = [
            'success' => true,
            'message' => 'Post has been fetch successfully',
            'next_offset' => (int)$request->offset + 20,

            'Posts' => Post::orderBy('updated_at', 'desc')
                ->whereNull('user_id')
                ->withCount(['likes', 'comments'])
                ->selectRaw($posts_id ? 'IF(`posts`.id IN('.implode(',', $posts_id).'), 1, 0) AS IsLiked' : "0 as IsLiked")
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->offset($request->offset)
                ->get()
        ];

        return response()->json($response);

    }

    public function eventAttendants(Request $request)
    {

        $response = Event::find($request->event_id)
            ->attendants()
            ->get();

          $response = [
        'success' => true,
        'message' => 'Event attendant'
        ];

        return response()->json($response);
    }

    public function createReport(Request $request){

        $report = new kikiReport();

        $report->fill($request->all());
        $report->user_id = Auth::user()->id;
        $report->save();

        $response = [
            'success' => true,
            'message' => 'Report created successfully',
            'event' => $report
        ];

        return response()->json($response);

    }

    public function deleteReport($id)
    {
        kikiReport::destroy($id);

        $response = [
            'success' => true,
            'message' => 'Report has been deleted successfully'
        ];

        return response()->json($response);
    }

    public function saveReports(Request $request)
    {
        $user_report = new UserReport();

        if ($request->post_id) {
            $user_report->post_id = $request->post_id;
        } elseif($request->user_id) {
            $user_report->user_id = $request->user_id;
        }
        elseif($request->comment_id) {
            $user_report->comment_id = $request->comment_id;
        }

        $user_report->report_by = Auth::user()->id;
        $user_report->user_id = $request->user_id;
        $user_report->save();
        
        $response = [
            'success' => true,
            'message' => 'Report has been created successfully',
            'post' => $user_report,
        ];

        return response()->json($response);
    }

    public function getCategoryIDs(Request $request,$key)
    {
        $category_name = AdminSetting::where('key', $key)->first();

        $response = [
            'success' => true,
            'message' => 'curosities fetched successfully',
            'value' => $category_name,
            'IsChecked'=>Auth::user()->$key
        ];

        return response()->json($response);

    }

    public function availableFilters()
    {
        $response = [
            'success' => true,
            'filters' => AdminSetting::all(),
        ];

        return response()->json($response);
    }

    public function reportProblem(Request $request)
    {
        $report = new Report();
        $report->title=$request->title;
        $report->text=$request->text;
        $report->user_id =  Auth::user()->id;
        $report->save();

        $response = [
            'success' => true,
            'message' => 'Report has been created successfully',
            'post' => $report,
        ];

        return response()->json($response);
    }

    public function upgrade(Request $request)
    {
        Auth::user()->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Account upgraded successfully'
        ];

        return response()->json($response);
    }

    public function incognito(Request $request)
    {
        Auth::user()->update($request->all());

        $response = [
            'success' => true,
            'message' => 'Settings saved successfully'
        ];

        return response()->json($response);
    }

    public function getOnlineUsers()
    {
        $user = Auth::user();
        $friends_ids = $user->following()
            ->whereIn('following_id', $user->followers()->pluck('users.id')->toArray())
            ->pluck('users.id')
            ->toArray();

        $response = [
            'success' => true,
            'users' => User::where('last_online', '>', Carbon::now()->subMinutes(5))
                ->where('incognito', 0)
                ->whereIn('id', $friends_ids)
                ->select(['id', 'name', 'profile_pic'])
                ->get()
        ];

        return response()->json($response);
    }

    public function rewindSwipes()
    {
        $user =Auth::user();

        DB::table('user_swipes')
            ->where([
                ['user_id', $user->id],
                ['action', 'disliked']
            ])
            ->delete();

        LikeDislike::where('disliker_id', $user->id)->delete();

        $response = [
            'success' => true,
            'message' => 'Rewinded swipes successfully'
        ];

        return response()->json($response);
    }

    public function startConversation(Request $request)
    {
        UserMatch::where([
            ['user1_id', $request->user1_id],
            ['user2_id', $request->user2_id]
        ])
        ->orWhere([
            ['user1_id', $request->user2_id],
            ['user2_id', $request->user1_id]
        ])
        ->update(['chat' => 1]);

        $response = [
            'success' => true,
            'message' => 'Conversation started successfully'
        ];

        return response()->json($response);
    }

    public function sendNotification(Request $request)
    {
        $data = [
            "registration_ids" => [$request->device_token],
            'notification' => [
                "title" => "A new trailer has arrived for you",
                "body" => "Fast and Furious F9 Official Trailer",
                "sound"=> "bingbong.aiff",
                "badge"=> 3
            ],
            'priority'=>'high'
        ];

        $headers = [
            'Authorization: key=' . $request->server_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return json_encode($data) . curl_exec($ch);
    }
    
    public function deleteUser(Request $request)
    {
        User::where('email', $request->email)->forceDelete();
        
        $response = [
            'success' => true,
            'message' => 'User deleted successfully'
        ];

        return response()->json($response);
    }

    public function getAdImages()
    {
        $response = [
            'success' => true,
            'images' => AdImage::all()
        ];

        return response()->json($response);
    }

    public function getIntroImages()
    {
        $response = [
            'success' => true,
            'images' => IntroImage::all()
        ];

        return response()->json($response);
    }

    public function call(Request $request)
    {
        $user = User::find($request->user_id);

        $data = $this->generateRtcToken($user);
        $notification = [
            'title' => 'Incoming Call',
            'body' => 'Incoming call from ' . Auth::user()->name,
            'type' => $request->type
        ] + $data;

        $user->sendNotification($notification);

        $response = [
            'success' => true
        ] + $data;

        return response()->json($response);
    }

    public function missedCallNotification(Request $request)
    {
        //dd(Auth::user()->profile_pic);
        $user = User::find($request->user_id);

        $data = $this->generateRtcToken($user);
        $notification = [
            'title' => 'Missed Call',
            'body' => 'You missed a call from ' . Auth::user()->name,
            'type' => 'missed_call',
            'caller_user_id' =>  Auth::user()->id,
            'caller_user_name' =>  Auth::user()->name,
            'caller_profile_pic' => Auth::user()->profile_pic
        ] ;

        $user->sendNotification($notification);

        $response = [
            'success' => true
        ] + $notification;

        return response()->json($response);
    }

    private function generateRtcToken($user)
    {
        $appID = config('app.agora_app_key');
        $appCertificate = config('app.agora_app_certificate');
        $channelName = Auth::user()->id . '-' . $user->id;
        $uid = 0;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $privilegeExpiredTs = time() + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);

        return [
            'token' => $token,
            'channel_name' => $channelName,
            'sender_id' => Auth::user()->id,
            'sender_name' => Auth::user()->name,
            'sender_image' => Auth::user()->profile_pic,
            'receiver_id' => $user->id,
            'receiver_name' => $user->name,
            'receiver_image' => $user->profile_pic
        ];
    }

    public function notifications()
    {
        $response = [
            'success' => true,
            'notifications' => Auth::user()->notifications()->get()->pluck('data')
        ];

        return response()->json($response);
    }
}