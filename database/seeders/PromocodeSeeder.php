<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Promocode;
use Illuminate\Database\Seeder;

class PromocodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promocodeFor5km = Promocode::create([
            'title' => '5km Radius free',
            'code' => 'FREE5KM',
            'radius' => 5,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 5 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $promocodeFor10km = Promocode::create([
            'title' => '10km Radius free',
            'code' => 'FREE10KM',
            'radius' => 10,
            'radius_unit' => 'km',
            'description' => 'This promocode gives free ride within 10 km radius',
            'start_at' => now(),
            'end_at' => now()->addMonth(),
        ]);

        $events = Event::get();
        $events->each(function ($event) use ($promocodeFor5km, $promocodeFor10km) {
            $promocodeFor5km->events()->attach($event);
            $promocodeFor10km->events()->attach($event);
        });
    }
}
