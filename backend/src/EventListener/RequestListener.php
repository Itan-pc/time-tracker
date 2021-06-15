<?php


namespace App\EventListener;


use App\Exception\JsonNotValidException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
	/**
	 * @param RequestEvent $event
	 */
	public function onKernelRequest(RequestEvent $event): void
	{
		if ($this->isJsonRequest($event->getRequest())) {
			$content = $event->getRequest()->getContent();

			if (empty($content)) {
				return;
			}

			$this->transformJsonBody($event->getRequest());
		}
	}

	/**
	 * Is JSON Request
	 *
	 * @param Request $request
	 * @return bool
	 */
	private function isJsonRequest(Request $request): bool
	{
		return 'json' === $request->getContentType();
	}

	/**
	 * Transform json content
	 *
	 * @param Request $request
	 */
	private function transformJsonBody(Request $request): void
	{
		$data = json_decode($request->getContent(), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw JsonNotValidException::new();
		}

		if ($data === null) {
			return;
		}

		$request->request->replace($data);
	}
}
