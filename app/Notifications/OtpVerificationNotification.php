<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpVerificationNotification extends Notification
{
    public $otpCode;

    /**
     * Create a new notification instance.
     */
    public function __construct($otpCode)
    {
        $this->otpCode = $otpCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode Verifikasi OTP - Registrasi Akun')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar. Silakan gunakan kode OTP berikut untuk memverifikasi akun Anda:')
            ->line('**Kode OTP: ' . $this->otpCode . '**')
            ->line('Kode ini akan kadaluarsa dalam 10 menit.')
            ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.')
            ->salutation('Salam, Tim ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
