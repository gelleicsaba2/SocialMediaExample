<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RelationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class FriendsController extends Controller
{
    public function __construct(
        protected RelationService $relationService

    ) {}

    public function index(Request $request): View
    {
        $userId = Auth::user()->id;
        $friends = $this->relationService->friends($userId);
        return view('friends')->with(['friends' => $friends]);
    }

    public function view(Request $request): View
    {
        $userId = Auth::user()->id;
        $friendId = $request->query('friend_id');
        if (! $this->relationService->checkFriends($userId, $friendId)) {
            abort(403, 'Forbidden');
        }
        $friend = User::where('id', $friendId)->first();
        return view('view')->with(['friend' => $friend]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $userId = Auth::user()->id;
        $friendId = $request->query('friend_id');
        if (! $this->relationService->checkFriends($userId, $friendId)) {
            abort(403, 'Forbidden');
        }
        $this->relationService->delete($userId, $friendId);
        return redirect('friends');
    }
}
