<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkorderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'W_WorkOrder' => $this->W_WorkOrder,
            'W_Status' => $this->W_Status,
            'W_Urgent' => $this->W_Urgent,
            'W_Requestor' => $this->W_Requestor,
            'W_Agent' => $this->W_Agent,
            'W_Owner' => $this->W_Owner,
            'W_Contractor' => $this->W_Contractor,
            'W_ContractorFee' => $this->W_ContractorFee,
            'W_InsCompany' => $this->W_InsCompany,
            'W_InsPolicy' => $this->W_InsPolicy,
            'W_PolicyNo' => $this->W_PolicyNo,
            'W_TransNo' => $this->W_TransNo,
            'W_RecordNo' => $this->W_RecordNo,
            'W_FirstName' => $this->W_FirstName,
            'W_MiddleInit' => $this->W_MiddleInit,
            'W_LastName' => $this->W_LastName,
            'W_DOB' => (string) $this->W_DOB?->format('Y-m-d'),
            'W_SS' => $this->W_SS,
            'W_NoFiles' => $this->W_NoFiles,
            'W_AuthorizedFile' => $this->W_AuthorizedFile,
            'W_ImagePages' => $this->W_ImagePages,
            'W_Tracking1' => $this->W_Tracking1,
            'W_Tracking2' => $this->W_Tracking2,
            'W_ShipFee1' => $this->W_ShipFee1,
            'W_ShipFee2' => $this->W_ShipFee2,
            'W_Note' => $this->W_Note,
            'W_Note2' => $this->W_Note2,
            'W_Note3' => $this->W_Note3,
            'W_FollowUpStatus' => $this->W_FollowUpStatus,
            'W_RequestorNote' => $this->W_RequestorNote,
            'W_ReceiveDate' => (string) $this->W_ReceiveDate?->format('Y-m-d'),
            'W_UpdDate' => (string) $this->W_UpdDate?->format('Y-m-d'),
            'W_UpdUser' => $this->W_UpdUser,
            'W_FollowUpDt' => (string) $this->W_FollowUpDt?->format('Y-m-d'),
            'W_CompletedDate' => (string) $this->W_CompletedDate?->format('Y-m-d'),
            'W_Hospital' => $this->W_Hospital,
            'H_ID' => $this->H_ID,
        ];
    }

    public function jsonOptions(): int
    {
        return JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK;
    }
}
