<?php

namespace App\Presentation\Api\Controller;

use App\Core\Application\Service\ShortLinkService;
use App\Core\Domain\Exception\ShortLinkException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

#[Route('/shortlink')]
class ShortLinkController extends AbstractController
{
    public function __construct(
        private ShortLinkService $shortLinkService,
        private LoggerInterface $logger,
        private ValidatorInterface $validator
    ) {
    }

    #[Route('', methods: ['POST'])]
    public function index(
        Request $request
    ): Response {
        $errors = $this->validator->validate($request->toArray(), new Assert\Collection(['url' => new Assert\Url()]));
        if ($errors->count() > 0) {
            $error = $errors->get(0);
            return $this->json(
                [
                    'error' => ['url' => $error->getMessage()],
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        try {
            return $this->json([
                'link' => $this->generateUrl(
                    'main',
                    ['alias' => $this->shortLinkService->create($request->toArray()['url'])],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ),
            ]);
        } catch (ShortLinkException $e) {
            $this->logger->error(
                sprintf("Can't generate unique link, user will not receive demanded link. %s", $e->getMessage()),
                [
                    'exception' => $e,
                ]
            );

            return $this->json(['error' => "Can't generate new link"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function getShortLink(Request $request): Response
    {
        $shortLinkId = $request->get('id');
        $shortLink = $this->shortLinkService->get($shortLinkId);

        if ($shortLink === null) {
            throw new NotFoundHttpException("Link with id: $shortLinkId is not found");
        }

        return $this->json($shortLink);
    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function remove(Request $request): Response
    {
        $shortLinkId = $request->get('id');
        $shortLink = $this->shortLinkService->get($shortLinkId);

        if ($shortLink === null) {
            throw new NotFoundHttpException("Link with id: $shortLinkId is not found");
        }

        $this->shortLinkService->remove($shortLink);

        return new Response();
    }
}
