<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS relations_view");
        DB::statement("CREATE VIEW relations_view AS
            SELECT
                users.id AS user_id,
                users.name AS user_name,
                friends.id AS friend_id,
                friends.name AS friend_name,
                relations.accepted
            FROM
                users
            LEFT JOIN
                relations ON users.id = relations.user_id
            LEFT JOIN
                users AS friends ON friends.id = relations.friend_id;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS relations_view");
    }
};
