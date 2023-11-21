<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\General\DateHelper;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'redirect_link',
        'is_unread',
        'read_at'
    ];
    
    public static function pushNotification($msg, $redirectLink = '\pawn') {
        $notif = new Notification();
        $notif->message = $msg;
        $notif->redirect_link = $redirectLink;
        $notif->is_unread = true;
        $notif->read_at = null;
        return $notif->save();
    }

    public function markAsRead() {
        $this->update([
            'is_unread' => false
        ]);
    }

    public function markAsUnRead() {
        $this->update([
            'is_unread' => true
        ]);
    }

    public static function markAllUnreadNotificationsAsRead() {
        Notification::where('is_unread', true)->update([
            'is_unread' => false
        ]);
    }

    public static function getUnreadNotifications() {
        return Notification::where('is_unread', true);
    }

    public static function getReadNotifications() {
        return Notification::where('is_unread', false);
    }

    public static function deleteAllUnreadNotifications() {
        Notification::where('is_unread', true)->delete();
    }

    public static function deleteAllReadNotifications() {
        Notification::where('is_unread', false)->delete();
    }

    public static function deleteReadNotificationWhenIsMoreThanOneWeek() {
        $todayMinusOneWeekAgo = \Carbon\Carbon::today()->subWeek();
        Notification::whereDate('read_at', '<' , $todayMinusOneWeekAgo)->delete();
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(DateHelper::USER_FORMAT);
    }

}
