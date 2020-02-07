<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\presentation;


use Lukasz93P\dddPackage\application\query\QueryExecutor;
use Lukasz93P\dddPackage\presentation\auth\Auth;
use Lukasz93P\dddPackage\presentation\auth\User;
use Lukasz93P\SymfonyHttpApi\Request\FormPostHandler\RequestFormPostHandler;
use Lukasz93P\SymfonyHttpApi\Response\Responder\ApiResponderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;

abstract class ApiController extends AbstractController
{
    public const HTTP_RESPONSE_ERROR_MESSAGE_KEY = 'message';

    protected RequestFormPostHandler $formPostHandler;

    protected ApiResponderService $apiResponder;

    protected QueryExecutor $queryExecutor;

    private Auth $auth;

    protected function __construct(FormFactoryInterface $formFactory, QueryExecutor $queryExecutor, Auth $auth)
    {
        $this->formPostHandler = RequestFormPostHandler::instance($formFactory);
        $this->apiResponder = ApiResponderService::instance();
        $this->queryExecutor = $queryExecutor;
        $this->auth = $auth;
    }

    protected function user(): User
    {
        return $this->auth->user();
    }

}