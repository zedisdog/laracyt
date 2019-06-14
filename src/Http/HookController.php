<?php
/**
 * Created by zed.
 */

namespace Dezsidog\LaraCyt\Http;


use Dezsidog\CytSdk\Notifies\NoticeOrderConsumed;
use Dezsidog\CytSdk\Notifies\NoticeOrderPrintSuccess;
use Dezsidog\CytSdk\Notifies\NoticeOrderRefundApproveResult;
use Dezsidog\CytSdk\Sdk;
use Dezsidog\LaraCyt\Events\NoticeOrderConsumedEvent;
use Dezsidog\LaraCyt\Events\NoticeOrderPrintSuccessEvent;
use Dezsidog\LaraCyt\Events\NoticeOrderRefundApproveResultEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Psr\Log\LoggerInterface;

class HookController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(Request $request)
    {
        /** @var LoggerInterface $logger */
        $logger = app()->make('log');
        $logger->info('receive-cyt-notify', $request->input());
        if (!$request->input('method') || !$request->input('requestParam')) {
            $logger->warning('receive-cyt-notify-error: 没有接收到< method >或< requestParam >');
            die('没有接收到< method >或< requestParam >');
        }
        /** @var Sdk $sdk */
        $sdk = app()->make(Sdk::class);
        $notice = $sdk->parseNotice($request->input('method'), $request->input('requestParam'));
        if ($notice instanceof NoticeOrderConsumed) {
            event(new NoticeOrderConsumedEvent($notice));
        } else if ($notice instanceof NoticeOrderPrintSuccess) {
            event(new NoticeOrderPrintSuccessEvent($notice));
        } else if ($notice instanceof NoticeOrderRefundApproveResult) {
            event(new NoticeOrderRefundApproveResultEvent($notice));
        } else {
            throw new \RuntimeException('unsupport notice');
        }

        $logger->info('response', $sdk->noticeResponse($request->input('method')));
        return $sdk->noticeResponse($request->input('method'));
    }
}