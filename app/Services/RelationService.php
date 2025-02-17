<?php

namespace App\Services;

use App\Models\User;
use App\Models\Relation;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RelationService
{
    /**
     * Create a new relation.
     */
    public function create(int $userId, int $friendId, int $accepted): void
    {
        Relation::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'accepted' => $accepted,
        ]);
    }

    public function accept(int $userId, int $friendId): void
    {
        Relation::where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->update(['accepted' => true]);
    }

    public function acceptable(int $userId): Collection
    {
        return Relation::where('friend_id', $userId)
            ->where('accepted', false)
            ->get();
    }

    public function people(int $userId): Collection
    {
        $users = User::where('id', '<>', $userId)->get();
        $friends = Relation::where('user_id', $userId)
            ->orWhere('friend_id', $userId)
            ->get();
        foreach ($users as $user) {
            $userId = $user->id;
            $filter = $friends->filter(function($x) use ($userId) {
                return $userId == $x->user_id || $userId == $x->friend_id;
            });
            $user->markable = $filter->isEmpty();
        }
        return $users;
    }

    public function friends(int $userId)
    {
        return
            DB::table('users')->where('users.id', '<>', $userId)
                ->join('relations', 'relations.user_id', '=', 'users.id')
                ->where('relations.accepted', true)
                ->select('users.*')
                ->get()
            ->concat(
                DB::table('users')->where('users.id', '<>', $userId)
                ->join('relations', 'relations.friend_id', '=', 'users.id')
                ->where('relations.accepted', true)
                ->select('users.*')
                ->get()
            );
    }

    public function markAsFriend(int $userId, int $friendId): void
    {
        $this->create($userId, $friendId, false);
    }

    public function delete(int $userId, int $friendId): void
    {
        DB::statement("DELETE FROM `relations`
            WHERE (user_id=$userId AND friend_id=$friendId)
            OR (user_id=$friendId AND friend_id=$userId)");
    }

    public function refuse(int $userId, int $friendId): void
    {
        DB::statement("DELETE FROM `relations`
            WHERE (user_id=$userId AND friend_id=$friendId)
            OR (user_id=$friendId AND friend_id=$userId)");
    }

    public function sendNotification(int $user_id, int $friend_id, string $message): void
    {
        Notification::create([
            'user_id' => $user_id,
            'friend_id' => $friend_id,
            'message' => $message,
            'readen' => false
        ]);
    }

    public function read(int $user_id, int $friend_id, string $message): void
    {
        Notification::where('user_id', $user_id)
            ->where('friend_id', $friend_id)
            ->where('message', $message)
            ->update(['readen' => true]);
    }

    public function checkFriends(int $user_id, int $friend_id, int $accepted=1): bool
    {
        $check1 = Relation::where('user_id', $user_id)
            ->where('friend_id', $friend_id)
            ->where('accepted', $accepted)
            ->first();
        $check2 = Relation::where('user_id', $friend_id)
            ->where('friend_id', $user_id)
            ->where('accepted', $accepted)
            ->first();
        return $check1!=null || $check2!=null;
    }

    public function checkFriendsRow(int $user_id, int $friend_id): bool
    {
        $check1 = Relation::where('user_id', $user_id)
            ->where('friend_id', $friend_id)
            ->first();
        $check2 = Relation::where('user_id', $friend_id)
            ->where('friend_id', $user_id)
            ->first();
        return $check1!=null || $check2!=null;
    }

}
