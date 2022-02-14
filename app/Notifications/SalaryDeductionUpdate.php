<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SalaryDeductionUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $deduction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($deduction)
    {
        $this->deduction = $deduction;
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
                    ->line('Your salary deduction updated.')
                    ->action('View', route('payroll.salary.manager.manage', $this->deduction->employee->employee_code))
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
            'title' => 'Your salary deduction updated.',
            'action' => route('payroll.salary.manager.manage', $this->deduction->employee->employee_code),
        ];
    }
}
