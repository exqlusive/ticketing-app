<?php

namespace Database\Seeders;

use App\Library\Enums\Event\EventStatusTypeEnum;
use App\Models\Event\Event;
use App\Models\Organization\Organization;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::updateOrCreate(
            ['slug' => 'test-event'],
            [
                'organization_id' => Organization::where('slug', 'pixxelfy')->first()->id,
                'slug' => 'test-event',
                'name' => 'Test Event',
                'description' => 'This is a test event.',
                'start_date' => now(),
                'end_date' => now()->addDay(),
                'venue' => 'Aquabest',
                'address' => 'Ekkersweijer 1, 5681 RZ Best',
                'status' => EventStatusTypeEnum::PUBLISHED->value,
            ]
        );
    }
}
