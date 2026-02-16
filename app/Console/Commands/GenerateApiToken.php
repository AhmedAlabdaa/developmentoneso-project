<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\User;

class GenerateApiToken extends Command
{
    protected $signature   = 'api:token {user_id?}';
    public function handle()
    {
        $id   = $this->argument('user_id') ?? $this->ask('Enter user ID');
        $user = \App\Models\User::find($id);

        if (! $user) {
            return $this->error("User ID {$id} not found.");
        }

        $this->info($user->createToken('api-client')->plainTextToken);
    }

}
