<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkorderResource;
use App\Models\Workorder;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    public function related(Request $request)
    {
        $filters = $request->query();

        $workorders = Workorder::query()
            ->select([
                'Workorder.W_WorkOrder',
                'Workorder.W_Status',
                'Workorder.W_Urgent',
                'Workorder.W_Requestor',
                'Workorder.W_Agent',
                'Workorder.W_Owner',
                'Workorder.W_Contractor',
                'Workorder.W_ContractorFee',
                'Workorder.W_InsCompany',
                'Workorder.W_InsPolicy',
                'Workorder.W_PolicyNo',
                'Workorder.W_TransNo',
                'Workorder.W_RecordNo',
                'Workorder.W_FirstName',
                'Workorder.W_MiddleInit',
                'Workorder.W_LastName',
                'Workorder.W_DOB',
                'Workorder.W_SS',
                'Workorder.W_NoFiles',
                'Workorder.W_AuthorizedFile',
                'Workorder.W_ImagePages',
                'Workorder.W_Tracking1',
                'Workorder.W_Tracking2',
                'Workorder.W_ShipFee1',
                'Workorder.W_ShipFee2',
                'Workorder.W_Note',
                'Workorder.W_Note2',
                'Workorder.W_Note3',
                'Workorder.W_FollowUpStatus',
                'Workorder.W_RequestorNote',
                'Workorder.W_ReceiveDate',
                'Workorder.W_UpdDate',
                'Workorder.W_UpdUser',
                'Workorder.W_FollowUpDt',
                'Workorder.W_CompletedDate',
                'Workorder.W_Hospital',
                'Hospital.H_ID',
            ])
            ->leftJoin('Hospital', 'Workorder.W_Hospital', '=', 'Hospital.H_Hospital')
            ->when($filters['W_FirstName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_FirstName', $v))
            ->when($filters['W_LastName'] ?? null, fn ($q, $v) => $q->where('Workorder.W_LastName', $v))
            ->when($filters['H_Phone'] ?? null, fn ($q, $v) => $q->where('Hospital.H_Phone', $v))
            ->when($filters['H_Fax'] ?? null, fn ($q, $v) => $q->where('Hospital.H_Fax', $v))
            ->orderBy('Workorder.W_CompletedDate', 'desc')
            ->orderBy('Workorder.W_ReceiveDate', 'desc')
            ->limit(20)
            ->get();

        return WorkorderResource::collection($workorders);
    }
}
