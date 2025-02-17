<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RelationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RelationController extends Controller
{
    public function __construct(
        protected RelationService $relationService
    ) {}

    public function index()
    {
        $userId = Auth::user()->id;
        $users = $this->relationService->people($userId);
        // dd($userId);
        return view('people')->with(compact('users'));
    }

    public function mark(Request $request): RedirectResponse
    {
        $userId = Auth::user()->id;
        $friendId = $request->query('friend_id');
        if ($this->relationService->checkFriendsRow($userId, $friendId)) {
            abort(403, 'Forbidden');
        }
        $this->relationService->markAsFriend($userId, $friendId);
        $this->relationService->sendNotification($friendId, Auth::user()->id,
            'You have been marked by '.Auth::user()->name.'.');
        return redirect('people');
    }

}
