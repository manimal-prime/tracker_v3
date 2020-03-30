<?php

namespace App\Notifications;

use App\Channels\DiscordMessage;
use App\Channels\WebhookChannel;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MemberTransferred extends Notification
{
    use Queueable;
    /**
     * @var Member
     */
    private $member;

    /**
     * Create a new notification instance.
     *
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function toWebhook()
    {
        $division = $this->member->division;

        $channel = $division->settings()->get('slack_channel');

        return (new DiscordMessage())
            ->info()
            ->to($channel)
            ->fields([
                [
                    'name' => "**MEMBER TRANSFER**",
                    'value' => addslashes(":recycle: {$this->member->name} [{$this->member->clan_id}] transferred to {$this->member->division->name}")
                ],
            ])->send();
    }
}