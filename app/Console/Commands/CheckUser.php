<?php

namespace App\Console\Commands;

use App\Comment;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Helper;

class CheckUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check user after 14 days login';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $dbusers=User::where('deleted_at', '<',  Carbon::now()->subDays(14))->onlyTrashed()->get();

        $subdatabase = "Users";
        $json_users = Helper::getfirebase($subdatabase);
        $users = json_decode( $json_users, true);

        $collections = collect($users);
        //dd($collections);
        foreach($dbusers as $user) {
            $posts = Post::where('user_id', $user->id)->with('comments')->delete();
            $user->update(['phone'=> NULL,'name'=>'Kikiuser']);

            #User Delete from Firebase
            $collections = $collections->where('id' , $dbusers[0]->id);
            $collections = $collections->where('email' , $dbusers[0]->email);
            
            foreach ($collections as $key => $collection) {
                Helper::delfirebase("$subdatabase/$key");
                //echo Helper::delfirebase("$subdatabase/$key");
                //echo "<br>";
            }
        }
        $this->info('Demo:Cron Cummand Run successfully!');
    }
}
