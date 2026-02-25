<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class ApiTokenSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $token = $user->tokens()->where('name','api-client')->first()
            ?: $user->createToken('api-client');
        echo "API token: {$token->plainTextToken}\n";
    }
}
