<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobPosted extends Notification
{
    use Queueable;

    protected $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['database']; // يمكنك إضافة 'mail' إذا أردت إرسال إشعار عبر البريد الإلكتروني
    }

    public function toDatabase($notifiable)
    {
        return [
            'job_id' => $this->job->id,
            'job_title' => $this->job->title,
            'message' => 'تم نشر وظيفة جديدة: ' . $this->job->title,
        ];
    }
}