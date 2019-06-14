<?php
declare(strict_types=1);
namespace Dezsidog\LaraCyt\Events;

use Dezsidog\CytSdk\Notifies\NoticeOrderPrintSuccess;
use Dezsidog\CytSdk\Responses\BaseIn;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NoticeOrderPrintSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var BaseIn
     */
    public $notice;

    /**
     * Create a new event instance.
     *
     * @param NoticeOrderPrintSuccess $notice
     */
    public function __construct(NoticeOrderPrintSuccess $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
