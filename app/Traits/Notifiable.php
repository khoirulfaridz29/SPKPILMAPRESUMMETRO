<?php

namespace App\Traits;

use App\Models\NotificationApp;

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
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $this->sendNotification($admin->id, $message, $type);
        }
    }

    public function notifyAllRole($role, $message, $type = 'info')
    {
        $users = \App\Models\User::where('role', $role)->get();
        foreach ($users as $user) {
            $this->sendNotification($user->id, $message, $type);
        }
    }
}
