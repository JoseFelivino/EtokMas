<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index() {
        //TODO: adjust render page
        Notification::deleteReadNotificationWhenIsMoreThanOneWeek();
        return Inertia::render('Notification',[
            'allUnreadNotifications' => Notification::getUnreadNotifications()->orderBy('created_at', 'desc')->paginate(15),
            'allReadNotifications' => Notification::getReadNotifications()->orderBy('created_at','desc')->paginate(15)
        ]);
    }

    public function markAsRead(Notification $notification) {
        $notification->markAsRead();
        return redirect()->route('notification.index')->with('successMessage', 'Notifikasi berhasil di tandai sebagai telah di baca!');
    }

    public function markAllUnreadNotificationsAsRead(){
        Notification::markAllUnreadNotificationsAsRead();
        return redirect()->route('notification.index')->with('successMessage', 'Notifikasi berhasil di tandai sebagai telah di baca!');
    }

    public function destroy(Notification $notification) {
        $notification->delete();
        return redirect()->route('notification.index')->with('successMessage', 'Notifikasi berhasil di hapus!');
    }

    public function destroyAllUnreadNotifications() {
        Notification::deleteAllUnreadNotifications();
        return redirect()->route('notification.index')->with('successMessage', 'Notifikasi berhasil di hapus!');
    }

    public function destroyAllReadNotifications() {
        Notification::deleteAllReadNotifications();
        return redirect()->route('notification.index')->with('successMessage', 'Notifikasi berhasil di hapus!');
    }

    public function isHasUnreadNotification() {
        $unreadNotification = Notification::getUnreadNotifications()->first();
        if($unreadNotification == null) return response()->json(['isHasUnreadNotification' => false]);
        return response()->json(['isHasUnreadNotification' => true]);
    }
}
