<?php

declare(strict_types=1);

namespace App\Http\Controllers;

abstract class Controller
{
    public function domain()
    {
        $hostname = $_SERVER['HTTP_HOST'] ?? 'eis.expressimagingservices.net';
        $domain_parts = explode('.', $hostname);
        $domain = $domain_parts[0];
        $domain = preg_replace('/[^a-z0-9]/', '', $domain);
        return $domain;
    }

    public function subdomain()
    {
        $hostname = $_SERVER['HTTP_HOST'] ?? 'eis.expressimagingservices.net';
        $domain_parts = explode('.', $hostname);
        $subdomain = $domain_parts[0];
        $subdomain = preg_replace('/[^a-z0-9]/', '', $subdomain);
        return $subdomain;
    }

    public function workorderMap($value)
    {
        $options = [
            'W_WorkOrder' => 'Work Order',
            'W_PolicyNo' => 'Policy Number',
            'W_Requestor' => 'Requestor',
            'W_Agent' => 'Agent',
            'W_BillCompany' => 'Billing Company',
            'W_ReceiveDate' => 'Receive Date',
            'W_CompletedDate' => 'Completed Date',
            'W_Contractor' => 'Contractor',
            'W_ContractorFee' => 'Contractor Fee',
            'W_Note' => 'Note',
            'W_Note2' => 'Special Instructions for PDF Cover Page',
            'W_Note3' => 'Third Note',
            'W_SS' => 'Social Security Number',
            'W_LastName' => 'Last Name',
            'W_MiddleInit' => 'Middle Initial',
            'W_FirstName' => 'First Name',
            'W_DOB' => 'Date of Birth',
            'W_YearsOfRecord' => 'Years of Record',
            'W_RecordNo' => 'Record Number',
            'W_Hospital' => 'Hospital',
            'W_HospitalID' => 'Hospital ID',
            'W_InsPolicy' => 'Insurance Policy',
            'W_InsCompany' => 'Insurance Company',
            'W_Status' => 'Status',
            'W_DrFee' => 'Doctor Fee',
            'W_DrFee1' => 'Doctor Fee 1',
            'W_DrFee2' => 'Doctor Fee 2',
            'W_DrCheckNo' => 'Doctor Check Number',
            'W_DrCheckDate' => 'Doctor Check Date',
            'W_DrInvoiceNo' => 'Doctor Invoice Number',
            'W_ImageFile' => 'Image File',
            'W_ImagePages' => 'Image Pages',
            'W_NoFiles' => 'Number of Files',
            'W_AuthorizedFile' => 'Authorized File',
            'W_FollowUpDt' => 'Follow-up Date',
            'W_FollowUpDone' => 'Follow-up Done',
            'W_FollowUpStatus' => 'Follow-up Status',
            'W_UpdUser' => 'Updated By',
            'W_UpdDate' => 'Update Date',
            'W_DrCheckNo2' => 'Doctor Check Number 2',
            'W_DrCheckDate2' => 'Doctor Check Date 2',
            'W_DrInvoiceNo2' => 'Doctor Invoice Number 2',
            'W_ShipFee' => 'Shipping Fee',
            'W_ShipFee1' => 'Shipping Fee 1',
            'W_ShipFee2' => 'Shipping Fee 2',
            'W_Tracking1' => 'Tracking Number 1',
            'W_Tracking2' => 'Tracking Number 2',
            'W_ExamStatus' => 'Exam Status',
            'W_Urgent' => 'Urgent',
            'W_Owner' => 'Assigned To',
            'W_Gender' => 'Gender',
            'W_RequestorNote' => 'Requestor Note',
            'W_WebUploadID' => 'Web Upload ID',
            'W_DrFollowup' => 'Doctor Follow-up',
            'post_issue_audit' => 'Post Issue Audit',
        ];

        if (array_key_exists($value, $options)) {
            return $options[$value];
        }

        return $value;
    }
}
