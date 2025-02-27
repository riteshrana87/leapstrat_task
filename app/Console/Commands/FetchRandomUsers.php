<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Location;
use Illuminate\Support\Facades\Http;

class FetchRandomUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:random-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch random users from API and store in database';
    
    public function handle() {
        for ($i = 0; $i < 5; $i++) {
            $response = Http::get('https://randomuser.me/api/');
            if ($response->successful()) {
                $data = $response->json()['results'][0];

                $user = User::create([
                    'name' => $data['name']['first'] . ' ' . $data['name']['last'],
                    'email' => $data['email']
                ]);

                UserDetail::create([
                    'user_id' => $user->id,
                    'gender' => $data['gender']
                ]);

                Location::create([
                    'user_id' => $user->id,
                    'city' => $data['location']['city'],
                    'country' => $data['location']['country']
                ]);
            }
        }

        $this->info('5 random users fetched and saved.');
    }
}
