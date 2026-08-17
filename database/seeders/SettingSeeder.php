<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['key' => 'application_name'], ['value' => 'VideoCall']);

        Setting::updateOrCreate(['key' => 'application_logo'], ['value' => '']);

        Setting::updateOrCreate(['key' => 'contact_email'], ['value' => '']);

        Setting::updateOrCreate(['key' => 'agent_commission'], ['value' => '10']);

        Setting::updateOrCreate(['key' => 'privacy_policy'], ['value' => '']);

        Setting::updateOrCreate(['key' => 'term_condition_policy'], ['value' => '']);

        Setting::updateOrCreate(['key' => 'about_application'], ['value' => '']);
    }
}
