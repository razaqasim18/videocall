<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agent::updateOrCreate(
            ['email' => 'agent@agent.com'],
            [
                'name' => 'agent',
                'password' => Hash::make('agent'),
            ]
        );
    }
}
