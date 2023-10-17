<?php

namespace App\Notifications;

use App\Models\Member;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParticipantAssigned extends Notification
{
    use Queueable;

    public Member $member;
    public Member $admin;
    public Participant $participant;

    public static $display_name = 'Participant Assigned';

    public static $display_description = 'A new participant has been assigned to you.';

    public static $display_model_key = 'participant';

    public static $display_data_key = 'canonical_id';

    public static $model_route_name = 'participant.show';

    /**
     * Create a new notification instance.
     */
    public function __construct(Participant $participant, Member $member, Member $admin)
    {
        $this->participant = $participant;
        $this->member = $member;
        $this->admin = $admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Participant Assigned')
            ->greeting('Hello!')
            ->line('A participant has been assigned to you by ' . $this->admin->name . '.')
            ->action('View the participant', url(route($this->model_route_name(), $this->participant->id)))
            ->salutation('Please reach out to your administrator with any questions.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'member' => $this->member->only(['id', 'name', 'email_address']),
            'participant' => $this->participant->only(['id', 'canonical_id', 'email_address']),
            'admin' => $this->admin->only(['id', 'name', 'email_address']),
            'string' => $this->participant->canonical_id . ' has been assigned to you by ' . $this->admin->name . '.'
        ];
    }

    /**
     * Get the string representation of this notification's name.
     *
     * @return string
     */

    public function display_name()
    {
        return static::$display_name;
    }

    /**
     * Get the string representation of this notification's description.
     *
     * @return string
     */
    public function display_description()
    {
        return static::$display_description;
    }

    /**
     * Get the string representation of the model key that should be displayed for additional detail about this notification.
     *
     * @return string
     */
    public function display_model_key()
    {
        return static::$display_model_key;
    }

    /**
     * Get the string representation of the data key that should be displayed for additional detail about this notification.
     *
     * @return string
     */
    public function display_data_key()
    {
        return static::$display_data_key;
    }

    /**
     * Get the string representation of the data key that should be displayed for additional detail about this notification.
     *
     * @return string
     */
    public function model_route_name()
    {
        return static::$model_route_name;
    }
}
