<?php

namespace Database\Seeders;

use App\Models\LineActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LineActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //{ name: 'Escalate', value: null, icon: XMarkIcon, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
        $activities = array(
            array('activity'=>'Requested Update','slug'=>'requested-update','icon'=>'SignalIcon','icon_color'=>'text-white','bg_color'=>'bg-blue-500','value'=>'requested-update', 'touchpoint'=>'requpd'),
            array('activity'=>'Lined Shipped','slug'=>'line-shipped','icon'=>'TruckIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'line-shipped', 'touchpoint'=>'linshi'),
            array('activity'=>'Lined Delayed','slug'=>'line-delayed','icon'=>'ClockIcon','icon_color'=>'text-white','bg_color'=>'bg-amber-500','value'=>'line-delayed', 'touchpoint'=>'lindel'),
            array('activity'=>'Escalate','slug'=>'escalate','icon'=>'ExclamationCircleIcon','icon_color'=>'text-white','bg_color'=>'bg-red-500','value'=>'escalate', 'touchpoint'=>'linesc'),
            array('activity'=>'Line Late','slug'=>'line-late','icon'=>'ExclamationCircleIcon','icon_color'=>'text-white','bg_color'=>'bg-red-500','value'=>'line-late', 'touchpoint'=>'linelt', 'score'=>'-5'),
            array('activity'=>'Supplier Added','slug'=>'supplier-added','icon'=>'BuildingOfficeIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'supplier-added', 'touchpoint'=>'supadd', 'score'=>'100'),
            array('activity'=>'Received Commit','slug'=>'received-commit','icon'=>'HandThumbUpIcon','icon_color'=>'text-white','bg_color'=>'bg-red-500','value'=>'received-commit', 'touchpoint'=>'commit', 'score'=>'1'),
            array('activity'=>'Line Delivered','slug'=>'line-delivered','icon'=>'TruckIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'line-delivered', 'touchpoint'=>'lindlv', 'score'=>'5'),
            array('activity'=>'Commented on a line','slug'=>'line-comment','icon'=>'ChatBubbleLeftEllipsisIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'line-comment', 'touchpoint'=>'comlin', 'score'=>'5'),
            array('activity'=>'Called the supplier','slug'=>'called-supplier','icon'=>'PhoneIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'called-supplier', 'touchpoint'=>'called', 'score'=>'0'),
            array('activity'=>'Requested a meeting','slug'=>'requested-meeting','icon'=>'UserGroupIcon','icon_color'=>'text-white','bg_color'=>'bg-green-500','value'=>'requested-meeting', 'touchpoint'=>'reqmee', 'score'=>'0'),
            array('activity'=>'Failed to reply to email within 48 hours','slug'=>'late-reply','icon'=>'ClockIcon','icon_color'=>'text-white','bg_color'=>'bg-red-500','value'=>'late-reply', 'touchpoint'=>'nrw48', 'score'=>'-3'),
            );

        foreach($activities as $activity){
            $count = LineActivity::where('touchpoint', $activity['touchpoint'])->count();
            if($count==0){
                DB::table('line_activities')->insert($activity);
            }

        }
    }
}
