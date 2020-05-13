<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 2020/5/10
 * Time: 0:33
 */

namespace App\Console\Commands;


use App\Models\Unit;
use Illuminate\Console\Command;
use DB;

class StatisticNomineesStar extends Command
{
    protected $signature = 'nominees_star:statistic';

    protected $description = '工会维度统计个人之星数量';

    public function handle()
    {
        $nomineesStar = DB::select("select `unit_id`,`kind`,count(*) as `num` from `nominees` where `declare_status` = 1 group by `unit_id`,`kind`");
        foreach ($nomineesStar as $item) {
            $unit = Unit::query()->where('id', $item->unit_id)->first();
            if (!$unit) {
                if ($item->kind === 1) {
                    $unit->labour_star_amount = $item->num;
                }
                if ($item->kind === 2) {
                    $unit->skill_star_amount = $item->num;
                }
                if ($item->kind === 3) {
                    $unit->innovate_star_amount = $item->num;
                }
                if ($item->kind === 4) {
                    $unit->service_star_amount = $item->num;
                }
                $unit->save();
                $this->info('unit '.$item->unit_id.': statistic success');
            }
        }
        $this->info('all statistic finished');
    }
}