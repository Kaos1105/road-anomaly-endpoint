<?php

declare(strict_types=1);

namespace App\Http\DTO\Negotiation;

use App\Http\DTO\Common\UserInfoData;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Site\SiteSupplierResource;
use App\Models\ClientEmployee;
use App\Models\ClientSite;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class ClientEmployeeDetailData extends Data
{
    public function __construct(
        public int                   $id,
        public ?string               $role,
        public ?int                  $clientSiteId,
        public ?int                  $employeeId,
        public EmployeeNameResource  $employee,
        public ?string               $memo,
        public int                   $displayOrder,
        public int                   $useClassification,
        public ?UserInfoData         $createdInfo,
        public ?UserInfoData         $updatedInfo,
        public ?SiteSupplierResource $site,
    )
    {

    }

    public static function fromModel(ClientEmployee $clientEmployee, ClientSite $clientSite): ClientEmployeeDetailData
    {
        $clientSite->load('site.company');

        return ClientEmployeeDetailData::from([
            ...$clientEmployee->toArray(),
            'employee' => EmployeeNameResource::make($clientEmployee->employee),
            'created_info' => $clientEmployee->created_by ? UserInfoData::fromData($clientEmployee->createdBy, $clientEmployee->created_at) : null,
            'updated_info' => $clientEmployee->updated_by ? UserInfoData::fromData($clientEmployee->updatedBy, $clientEmployee->updated_at) : null,
            'site' => SiteSupplierResource::make($clientSite->site)
        ]);
    }
}
