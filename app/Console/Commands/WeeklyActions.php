<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DeliveryDay;
use Illuminate\Support\Carbon;

class WeeklyActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:weeklyactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $today = Carbon::now();
            $delivey_days_count = DeliveryDay::where('delivery_date', '>', $today)->count();

            if ($delivey_days_count < 20) {
                $additional_del = 20 - $delivey_days_count;
                $count = 1;
                // $c = $delivey_days_count . '_' . $count;

                while ($count <= $additional_del) {
                    $lastDeliveryDay = DeliveryDay::orderBy('delivery_date', 'desc')->first();
                    if ($lastDeliveryDay) {
                        $lastDeliveryDate = $lastDeliveryDay->delivery_date;
                        $date = Carbon::parse($lastDeliveryDate);
                    } else {
                        $date = Carbon::now();
                    }
                    $day = Carbon::parse($date)->format('l');

                    if ($day == 'Thursday') {
                        $nextDeliveryDate = $date->is('Friday') ? $date : $date->next('Friday');
                        $nextDeliverTo = 'friday';
                    } else {
                        $nextDeliveryDate = $date->is('Thursday') ? $date : $date->next('Thursday');
                        $nextDeliverTo = 'thursday';
                    }

                    $delivey_day = new DeliveryDay();
                    $delivey_day['deliver_to'] = $nextDeliverTo;
                    $delivey_day['delivery_date'] = $nextDeliveryDate;
                    // $delivey_day->save();
                    if ($delivey_day->save()) {
                        $lastDeliveryDay = $delivey_day;
                    }
                    $count++;
                    // $c = $c . '_' . $count;
                }
                // dd($c);
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            dd($error);
        }
        return 0;
    }
}
