<?php

namespace App\Presentation\Web\Controller;

use App\Core\Application\Service\ShortLinkService;
use App\Core\Domain\Exception\ShortLinkException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RedirectController extends AbstractController
{
    public function __construct(private ShortLinkService $shortLinkService)
    {
    }

    public function index(
        Request $request
    ): Response {
        $alias = $request->get('alias');
        $shortLink = $this->shortLinkService->getByAlias($alias);

        if ($shortLink === null) {
            throw new NotFoundHttpException("Link with alias: $alias is not found");
        }

        return $this->redirect($shortLink->getUrl(), Response::HTTP_MOVED_PERMANENTLY);
    }
}
