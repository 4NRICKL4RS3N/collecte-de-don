<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.pages.dashboard');
    }

    public function dashboardData() {
        $donation_breakdown = DB::select("select * from v_donation_breakdown");
        $donation_last = DB::select("call p_donation_summary(DATE_SUB(NOW(), INTERVAL 15 DAY), NOW())");
        foreach ($donation_last as $item) {
            $item->payment_date = Carbon::parse($item->payment_date)->translatedFormat('j M Y');
        }
        $projects_classement = Project::select('id', 'title', 'donation_collected')
            ->orderBy('id', 'asc')
            ->get();
        $projects_donation_count = DB::select("select * from v_projects_donation_count");
        $projects_avg_donation = DB::select("select * from v_projects_avg_donation");
        $donator_new_and_returned = DB::select("select * from v_donator_new_and_returned");

        $total_donation = DB::selectOne("
            select sum(donation_amount) as amount from v_valid_payments
        ");
        $total_donors = DB::selectOne("
            select count(id) as count from v_users_donation_count where donation_count > 0
        ");
        $total_donation_count = DB::selectOne("
            select sum(donation_count) as count from v_users_donation_count
        ");
        $users_donation = DB::selectOne("
            select * from v_users_donation limit 1
        ");
        $users = DB::select("
            select u.id, u.name, u.email, ud.total from users u join v_users_donation ud on u.id = ud.id
        ");

        return response()->json([
            'donation_breakdown' => $donation_breakdown,
            'donation_last' => $donation_last,
            'projects_classement' => $projects_classement,
            'projects_donation_count' => $projects_donation_count,
            'projects_avg_donation' => $projects_avg_donation,
            'donator_new_and_returned' => $donator_new_and_returned,
            'total_donation' => $total_donation,
            'total_donors' => $total_donors,
            'total_donation_count' => $total_donation_count,
            'users_donation' => $users_donation,
            'users' => $users,
        ]);
    }

    function donation_between_two_dates(Request $request) {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $data = DB::select("
        CALL p_donation_summary(?, ?)", [$start_date, $end_date]);
        foreach ($data as $item) {
            $item->payment_date = Carbon::parse($item->payment_date)->translatedFormat('j M Y');
        }
        return response()->json($data);
    }

}
