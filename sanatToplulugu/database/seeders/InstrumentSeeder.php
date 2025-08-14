<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instruments = [
            // Telli Enstrümanlar
            ['name' => 'Gitar', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Bağlama', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Keman', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Ud', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Cura', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Kanun', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Mandolin', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Banjo', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Ukulele', 'category' => 'Telli Enstrümanlar'],
            ['name' => 'Viyola', 'category' => 'Telli Enstrümanlar'],
            
            // Klavyeli Enstrümanlar
            ['name' => 'Piyano', 'category' => 'Klavyeli Enstrümanlar'],
            ['name' => 'Org', 'category' => 'Klavyeli Enstrümanlar'],
            ['name' => 'Elektronik Klavye', 'category' => 'Klavyeli Enstrümanlar'],
            ['name' => 'Akordeon', 'category' => 'Klavyeli Enstrümanlar'],
            
            // Nefesli Enstrümanlar
            ['name' => 'Flüt', 'category' => 'Nefesli Enstrümanlar'],
            ['name' => 'Klarnet', 'category' => 'Nefesli Enstrümanlar'],
            ['name' => 'Saksafon', 'category' => 'Nefesli Enstrümanlar'],
            ['name' => 'Ney', 'category' => 'Nefesli Enstrümanlar'],
            ['name' => 'Zurna', 'category' => 'Nefesli Enstrümanlar'],
            
            // Vurmalı Enstrümanlar
            ['name' => 'Davul', 'category' => 'Vurmalı Enstrümanlar'],
            ['name' => 'Bateri', 'category' => 'Vurmalı Enstrümanlar'],
            ['name' => 'Darbuka', 'category' => 'Vurmalı Enstrümanlar'],
            ['name' => 'Bendir', 'category' => 'Vurmalı Enstrümanlar'],
            ['name' => 'Tef', 'category' => 'Vurmalı Enstrümanlar'],
            
            // Vokal
            ['name' => 'Solist', 'category' => 'Vokal'],
            
            // Sanat Dalları
            ['name' => 'Tiyatro', 'category' => 'Sanat Dalları'],
            ['name' => 'Dans', 'category' => 'Sanat Dalları'],
            ['name' => 'Resim', 'category' => 'Sanat Dalları'],
            ['name' => 'Fotoğrafçılık', 'category' => 'Sanat Dalları'],
            ['name' => 'El İşi', 'category' => 'Sanat Dalları'],
        ];

        foreach ($instruments as $instrument) {
            \App\Models\Instrument::create($instrument);
        }
    }
}
