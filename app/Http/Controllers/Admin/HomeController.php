<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\Department;
use App\Models\Priority;
use App\User;
use App\Models\Customer;
use App\Models\CannedMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.dashboard')
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

       return !auth()->user()->hasRole('Super Admin') ? $this->agentDashboard() : $this->adminDashboard();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {

        $latest_tickets = Ticket::latest()->limit(5)->get();
        
        $open_tickets = Ticket::where('status', 'open')->count();
        $total_tickets = Ticket::count();
        $total_customers = Customer::count();
        $total_users = User::count();

        return view('admin.dashboard', compact('latest_tickets', 'open_tickets', 'total_tickets', 'total_customers', 'total_users'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function agentDashboard()
    {

        $latest_tickets = Ticket::where('user_id', auth()->user()->id)->latest()->limit(5)->get();
        
        $open_tickets = Ticket::where('user_id', auth()->user()->id)->where('status', 'open')->count();
        $total_tickets = Ticket::where('user_id', auth()->user()->id)->count();
        
        $unreplied_tickets = Ticket::where('user_id', auth()->user()->id)->where('status_reply', 'client_reply')->where('status', 'open')->count();

        return view('admin.agent_dashboard', compact('latest_tickets', 'open_tickets', 'total_tickets', 'unreplied_tickets'));
    }
}
