<?php

namespace App\Console\Commands;

use DB;
use Log;
use Mail;
use Illuminate\Console\Command;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:everyMonth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send fee email to Ktv everymonth';

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
     * @return mixed
     */
    public function handle()
    {
        \App\Models\Ktv::where('fee_status', 'yes')->update(['fee_status' => 'no']);

        $ktv_reports = \App\Models\ImportedDataUsage::join('ktvs', 'imported_data_usages.ktv_id', '=', 'ktvs.id')
            ->whereBetween('imported_data_usages.date', [\Carbon\Carbon::now()->format('Y-m-01'), \Carbon\Carbon::now()->format('Y-m-31')])
            ->groupBy('ktv_id')
            ->select(DB::raw('sum(imported_data_usages.times) as total_times, ktvs.name as ktv_name, ktvs.email as email'))
            ->get();

        $config = json_decode(\App\Models\Config::orderBy('updated_at')->first()->config, true);

        foreach ($ktv_reports as $ktv_report) {
            $total_money = number_format($ktv_report->total_times * intval($config['price']), 0, '.', '.') . ' VNĐ';
            Mail::send('emails.fee_alert', array('ktv_name' => $ktv_report->ktv_name, 'total_money' => $total_money), function($message) use ($ktv_report) {
                $message->to($ktv_report->email, $ktv_report->ktv_name)->from('system@gmail.com', 'Hệ thống')->subject('Thông báo chi phí sử dụng bài hát hàng tháng!');
            });
        }
    }
}
