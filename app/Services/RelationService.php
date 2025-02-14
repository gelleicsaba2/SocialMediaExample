<?php

namespace App\Services;

use App\Models\User;
use App\Models\Relation;
use App\Models\RelationView;
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
        DB::transaction(function() use ($userId, $friendId) {
            Relation::where('user_id', $userId)
                ->where('friend_id', $friendId)
                ->update(['accepted' => true]);
            $this->create($friendId, $userId, true);
        });
    }

    public function acceptable(int $userId): Collection
    {
        return RelationView::where('friend_id', $userId)
            ->where('accepted', false)
            ->orderBy('friend_name', 'asc')
            ->get();
    }

    public function people(int $userId): Collection
    {
        $users = User::where('id', '<>', $userId)->get();
        $friends = Relation::where('user_id', $userId)->get();
        $users = $users->filter(function($user) use ($friends) {
            return ! $friends->contains('friend_id', $user->id);
        });
        return $users;
    }

    public function friends(int $userId): Collection
    {
        return RelationView::where('user_id', $userId)
            ->where('accepted', true)
            ->orderBy('friend_name', 'asc')
            ->get();
    }

    public function markAsFriend(int $userId, int $friendId): void
    {
        $this->create($userId, $friendId, false);
    }

    public function delete(int $userId, int $friendId): void
    {
        DB::transaction(function() use ($userId, $friendId) {
            DB::statement("DELETE FROM `relations` WHERE user_id=$userId AND friend_id=$friendId");
            DB::statement("DELETE FROM `relations` WHERE user_id=$friendId AND friend_id=$userId");
        });
    }

    public function refuse(int $userId, int $friendId): void
    {
        DB::statement("DELETE FROM `relations` WHERE user_id=$userId AND friend_id=$friendId");
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

}
