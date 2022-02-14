<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SalaryIncrement extends Notification implements ShouldQueue
{
    use Queueable;

    protected $increment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($increment)
    {
        $this->increment = $increment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your salary updated.')
                    ->action('View', route('payroll.salary.manager.manage', $this->increment->employee->employee_code))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Your salary updated.',
            'action' => route('payroll.salary.manager.manage', $this->increment->employee->employee_code),
        ];
    }
}
