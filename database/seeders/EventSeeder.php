<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'title' => 'The Roaring 2020\s Dinner & Party',
            'description' => '<p>Bring in the New Year at The Pier House ! Our NYE Dinner with a Prix Fixe Menu is 8pm-10pm. Our NYE Party starts at 10pm-close.</p><p>Good Times Made Locally!</p><p>For any questions, please contact Charlotte (213) 984-9456</p>',
            'latitude' => 33.9793132,
            'longitude' => -118.4674853,
        ]);

        Event::create([
            'title' => 'Yamashiro NYE \'21 | NEW YEAR\'S EVE PARTY',
            'description' => '<p>This New Year’s Eve take advantage of the unique opportunity to celebrate the holiday in the historic Los Angeles masterpiece, Yamashiro. The 1911 Hollywood hilltop mansion is opening its doors for an exclusive party that will be talked about for months after the legendary evening.</p><p>An overwhelmingly impressive exterior welcomes you into the majestic Japanese space. Inside, the spectacular evening is amenity-packed with luxuries like a five hour premium open bar. The opulent venue will fill with music from a live DJ heating up the dance floor with Top 40, hip hop, and house tracks. The evening culminates in a DJ-led live countdown to midnight complete with complimentary champagne and party favors.</p><p>Towering 250 feet above Hollywood Boulevard, Yamashiro is a Hollywood Institution that has served as a film set, an event space, and a nightlife venue for Los Angeles elite for decades. A traditional Japanese mansion in the Hollywood Hills, Yamashiro provides breathtaking views and stunning architecture. It is comprised of a beautiful courtyard garden, a ballroom decked out in Asian flourishes, and outdoor pool with a Buddha shrine and unparalleled views of Los Angeles.</p><p>Yamashiro, which translates to “Mountain Palace,” is a direct replica of a palace located near the Yamashiro province mountains near Kyoto, Japan and there’s no doubt guests feel transported the moment they ascend its impressive drive. This LA mansion will be transformed into a palace of entertainment this New Year’s Eve. Join us for the most luminous event in the City of Angels this NYE at Yamashiro.</p>',
            'latitude' => 34.1057604,
            'longitude' => -118.3420926,
        ]);
    }
}
