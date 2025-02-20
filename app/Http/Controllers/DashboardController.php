<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User; // Import the User model
use Illuminate\Http\RedirectResponse;
use App\Models\Relation;
use Illuminate\Support\Facades\Auth;
use App\Services\RelationService;
use App\Models\Notification;

class DashboardController extends Controller
{

    public function __construct(
        protected RelationService $relationService

    ) {}

    public function index(Request $request): View
    {
        if (! Auth::user()) {
            abort(403, 'Forbidden');
        }

        $unverifiedUsers =
            Auth::user()->is_admin ?
                User::where('email_verified_at', null)->get()
                : [];

        $acceptableFriends =
                (! Auth::user()->is_admin) && Auth::user()->hasVerifiedEmail() ?
                    $this->relationService->acceptable(Auth::user()->id)
                    : [];

        $notifications =
            (! Auth::user()->is_admin) ? Notification::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get()
            : [];

        return view('dashboard')
            ->with(compact('unverifiedUsers', 'acceptableFriends', 'notifications'));
    }

    public function verify(Request $request): RedirectResponse
    {
        $id = $request->query('id');
        User::where('id', $id)->update(['email_verified_at' => now()]);
        $this->relationService->sendNotification($id, 1,
            'Good day! You are verified.');
        return redirect('dashboard');
    }

    public function accept(Request $request): RedirectResponse
    {
        $user_id = Auth::user()->id;
        $friend_id = $request->query('friend_id');
        if (! $this->relationService->checkFriends($user_id, $friend_id, 0)) {
            abort(403, 'Forbidden');
        }
        $this->relationService->accept($friend_id, $user_id);
        $this->relationService->sendNotification($friend_id, Auth::user()->id,
            'You have been accepted by '.Auth::user()->name.'.');
        return redirect('dashboard');
    }

    public function refuse(Request $request): RedirectResponse
    {
        $user_id = Auth::user()->id;
        $friend_id = $request->query('friend_id');
        if (! $this->relationService->checkFriends($user_id, $friend_id, 0)) {
            abort(403, 'Forbidden');
        }
        $this->relationService->refuse($friend_id, $user_id);
        $this->relationService->sendNotification($friend_id, Auth::user()->id,
            'You have been refused by '.Auth::user()->name.'.');
        return redirect('dashboard');
    }


}
