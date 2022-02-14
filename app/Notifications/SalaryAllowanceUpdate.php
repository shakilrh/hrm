<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SalaryAllowanceUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $allowance;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($allowance)
    {
        $this->allowance = $allowance;
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
                    ->line('Your salary allowance updated.')
                    ->action('View', route('payroll.salary.manager.manage', $this->allowance->employee->employee_code))
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
            'title' => 'Your salary allowance updated.',
            'action' => route('payroll.salary.manager.manage', $this->allowance->employee->employee_code),
        ];
    }
}
