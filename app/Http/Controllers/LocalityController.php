<?php

namespace App\Http\Controllers;

use App\Services\Connectors\Contracts\LocalityConnectorInterface;
use App\Services\Connectors\Contracts\LocalityType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocalityController extends Controller
{
    use ConvertsToLocalityType;
    public function __construct(private readonly LocalityConnectorInterface $localityConnector)
    {

    }

    public function index(string $localityType)
    {
        $type = $this->convertToLocalityType($localityType);

        if (empty($type)) {
            throw new NotFoundHttpException();
        }

        return $this->localityConnector->getLocalities($type);
    }
}
