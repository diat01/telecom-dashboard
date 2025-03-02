<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = Service::create([
            "name" => "Internet Hyzmaty"
        ]);

        SubscriptionPlan::create([
            "name"       => "1 mb/s",
            "price"      => "150",
            "service_id" => $service->id
        ]);

        SubscriptionPlan::create([
            "name"       => "2 mb/s",
            "price"      => "180",
            "service_id" => $service->id
        ]);
        SubscriptionPlan::create([
            "name"       => "4 mb/s",
            "price"      => "230",
            "service_id" => $service->id
        ]);
        SubscriptionPlan::create([
            "name"       => "6 mb/s",
            "price"      => "280",
            "service_id" => $service->id
        ]);
    }
}
