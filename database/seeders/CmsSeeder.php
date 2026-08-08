<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CmsPage::updateOrCreate(
            ['slug' => 'privacy_policy'],
            [
                'title' => 'Privacy Policy',
                'content' => '',
            ],
        );

        CmsPage::updateOrCreate(
            ['slug' => 'term_condition'],
            [
                'title' => 'Term & Condition',
                'content' => '',
            ],
        );

        CmsPage::updateOrCreate(
            ['slug' => 'about_application'],
            [
                'title' => 'About Application',
                'content' => '',
            ],
        );
    }
}
