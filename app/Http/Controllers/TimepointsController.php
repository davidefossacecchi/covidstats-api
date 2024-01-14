<?php

namespace App\Http\Controllers;

use App\Services\Connectors\Contracts\DataLoaderInterface;
use App\Services\Connectors\Exceptions\NotFoundLocalityException;
use App\Services\Ranges\DateRange;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TimepointsController extends Controller
{
    use ConvertsToLocalityType;
    public function __construct(private readonly DataLoaderInterface $dataLoader)
    {

    }

    public function show(string $localityKey, int $localityId, Request $request)
    {
        $this->validate($request, [
            'from' => 'date_format:Y-m-d',
            'to' => 'date_format:Y-m-d'
        ]);

        $localityType = $this->convertToLocalityType($localityKey);

        if (empty($localityType)) {
            throw new NotFoundHttpException();
        }

        $from = $request->has('from')
            ? \DateTimeImmutable::createFromFormat('Y-m-d', $request->get('from'))
            : null;

        $to = $request->has('to')
            ? \DateTimeImmutable::createFromFormat('Y-m-d', $request->get('to'))
            : null;

        $range = new DateRange($from, $to);

        try {
            return $this->dataLoader->load($localityType, $localityId, $range);

        } catch (NotFoundLocalityException $ex) {
            throw new NotFoundHttpException();
        }
    }
}
