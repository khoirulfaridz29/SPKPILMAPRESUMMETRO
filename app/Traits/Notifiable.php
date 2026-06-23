<?php

namespace App\Traits;

use App\Models\NotificationApp;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait Notifiable
{
    public function sendNotification($userId, $message, $type = 'info')
    {
        return NotificationApp::create([
            'user_id' => $userId,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
        ]);
    }

    public function notifyAllAdmins($message, $type = 'info')
    {
        $adminIds = User::where('role', 'admin')->pluck('id');
        if ($adminIds->isEmpty()) return;

        $now = now();
        $inserts = $adminIds->map(fn($id) => [
            'user_id' => $id,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        NotificationApp::insert($inserts);
    }

    public function notifyAllRole($role, $message, $type = 'info')
    {
        $userIds = User::where('role', $role)->pluck('id');
        if ($userIds->isEmpty()) return;

        $now = now();
        $inserts = $userIds->map(fn($id) => [
            'user_id' => $id,
            'message' => $message,
            'type'    => $type,
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        NotificationApp::insert($inserts);
    }
}
