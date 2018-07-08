<?php

namespace App\Presenters;

use Nette;
use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
use Nette\Application\Responses;
use Nette\Http;
use Tracy\ILogger;


class ErrorPresenter extends BasePresenter implements Nette\Application\IPresenter
{
	//use Nette\SmartObject;

	/** @var ILogger */
	private $logger;


	public function __construct(ILogger $logger)
	{
	    parent::__construct();
		$this->logger = $logger;
	}

/*
	public function run(Nette\Application\Request $request)
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof Nette\Application\BadRequestException) {
			list($module, , $sep) = Nette\Application\Helpers::splitName($request->getPresenterName());
			return new Responses\ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new Responses\CallbackResponse(function (Http\IRequest $httpRequest, Http\IResponse $httpResponse) {
			if (preg_match('#^text/html(?:;|$)#', $httpResponse->getHeader('Content-Type'))) {
				require __DIR__ . '/templates/Error/500.latte';
			}
		});
	}*/
    /**
     * Renders error page
     * @param BadRequestException $exception exception, which called error presenter
     * @throws AbortException If render failed, then it is server failure - HTTP 500
     * @throws Nette\Application\AbortException
     */
    public function renderDefault($exception)
    {
        $serverError = false;
        // Request fault
        if ($exception instanceof BadRequestException) {
            // Writing to access.log.
            $this->logger->log("HTTP code {$exception->getCode()}: {$exception->getMessage()} in {$exception->getFile()}:{$exception->getLine()}", 'access');
        } else {
            $this->setView('500'); // Loads template 500.latte.
            $this->logger->log($exception, ILogger::EXCEPTION);
            $serverError = true;
        }

        if ($this->isAjax()) {
            $this->payload->error = true;
            $this->terminate();
        } elseif (!$serverError) {
            $this->redirect('Core:Product:list');
        }
    }
}
