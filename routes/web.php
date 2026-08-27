<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AccountmanagerController;
use App\Http\Controllers\Admin\AzureController;
use App\Http\Controllers\Admin\BilltopicklistController;
use App\Http\Controllers\Admin\ChangelogController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContractorloginattemptController;
use App\Http\Controllers\Admin\ContractorloginipController;
use App\Http\Controllers\Admin\CreditcardController;
use App\Http\Controllers\Admin\LoginattemptController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LoginipController;
use App\Http\Controllers\Admin\Over60daysnoticeconfigController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlatformConfigurationController;
use App\Http\Controllers\Admin\RequestorPasswordChangeController;
use App\Http\Controllers\Admin\RequestorroleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShelteragentController;
use App\Http\Controllers\Admin\SmartaccessthemeController;
use App\Http\Controllers\Admin\TicketmanagerController;
use App\Http\Controllers\Admin\WebsiteconfigController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthUserGoogleController;
use App\Http\Controllers\DocusigndocumentController;
use App\Http\Controllers\PasswordresetController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\SessioninfoController;
use App\Http\Controllers\SmartaccessController;
use App\Http\Controllers\User\AdditionalrequestController;
use App\Http\Controllers\User\AddonorderController;
use App\Http\Controllers\User\AlternatepaymentController;
use App\Http\Controllers\User\ApscancellationController;
use App\Http\Controllers\User\BankstatementController;
use App\Http\Controllers\User\CheckController;
use App\Http\Controllers\User\CompanyupdateController;
use App\Http\Controllers\User\ContractorController;
use App\Http\Controllers\User\ContractorloginController;
use App\Http\Controllers\User\CopyserviceController;
use App\Http\Controllers\User\CreditcardauthorizationController;
use App\Http\Controllers\User\DailyStatController;
use App\Http\Controllers\User\DatachangeController;
use App\Http\Controllers\User\DocusignchangeController;
use App\Http\Controllers\User\DocusignController;
use App\Http\Controllers\User\EhrorderController;
use App\Http\Controllers\User\EhrordersdocumentController;
use App\Http\Controllers\User\EhrorderssearchresultController;
use App\Http\Controllers\User\EhrorderssearchresultsexclusionController;
use App\Http\Controllers\User\EisweborderController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\ExamrequestController;
use App\Http\Controllers\User\FacilityformController;
use App\Http\Controllers\User\FaxController;
use App\Http\Controllers\User\FileController;
use App\Http\Controllers\User\FiletransferController;
use App\Http\Controllers\User\FollowUpStatusReviewController;
use App\Http\Controllers\User\HospitalController;
use App\Http\Controllers\User\IncomingApsConfigController;
use App\Http\Controllers\User\IncomingApsLogController;
use App\Http\Controllers\User\InquiryController;
use App\Http\Controllers\User\InsurancecompanyController;
use App\Http\Controllers\User\LlmController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PrefillController;
use App\Http\Controllers\User\PurgeConfigController;
use App\Http\Controllers\User\ReportConfigController;
use App\Http\Controllers\User\ReportConfigNameController;
use App\Http\Controllers\User\ReportConfigTypeController;
use App\Http\Controllers\User\RequestlogController;
use App\Http\Controllers\User\RequestorController;
use App\Http\Controllers\User\RoiController;
use App\Http\Controllers\User\SeqsterorderController;
use App\Http\Controllers\User\ShipmentController;
use App\Http\Controllers\User\ShippinglabelController;
use App\Http\Controllers\User\SignformController;
use App\Http\Controllers\User\SpellController;
use App\Http\Controllers\User\StatustriggerController;
use App\Http\Controllers\User\SynodextransmissionsController;
use App\Http\Controllers\User\TicketController;
use App\Http\Controllers\User\TimecardController;
use App\Http\Controllers\User\WebhookController;
use App\Http\Controllers\User\WoinController;
use App\Http\Controllers\User\WorkorderController;
use App\Http\Controllers\User\WorkorderdetailController;
use App\Http\Controllers\User\WorkorderemailController;
use App\Http\Controllers\User\WorkorderemailsendController;
use App\Http\Controllers\User\WorkorderfileController;
use App\Http\Controllers\User\WorkorderfiledownloadController;
use App\Http\Controllers\User\WorkorderfiletransferController;
use App\Http\Controllers\User\WorkorderholdtimeController;
use App\Http\Controllers\User\WorkordernoticeController;
use App\Http\Controllers\User\WorkorderpaymentController;
use App\Http\Controllers\User\WorkorderprefillController;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/smartaccess', [SmartaccessController::class, 'index']);

Route::get('/authadmin/signin', [AuthAdminController::class, 'login'])->name('login');
Route::get('/authadmin/login', [AuthAdminController::class, 'login'])->name('authadmin.login');
Route::post('/authadmin/in', [AuthAdminController::class, 'in'])->name('authadmin.in');
Route::get('/authadmin/ipconfirm', [AuthAdminController::class, 'ipconfirm'])->name('authadmin.ipconfirm');
Route::post('/authadmin/ipconfirmin', [AuthAdminController::class, 'ipconfirmin'])->name('authadmin.ipconfirmin');
Route::get('/authadmin/logout', [AuthAdminController::class, 'logout'])->name('authadmin.logout');

Route::get('/contractors/login', [AuthUserController::class, 'login'])->name('authuser.login');
Route::post('/contractors/in', [AuthUserController::class, 'in'])->name('authuser.in');
Route::get('/contractors/ipconfirm', [AuthUserController::class, 'ipconfirm'])->name('authuser.ipconfirm');
Route::post('/contractors/ipconfirmin', [AuthUserController::class, 'ipconfirmin'])->name('authuser.ipconfirmin');
Route::get('/contractors/logout', [AuthUserController::class, 'logout'])->name('authuser.logout');
Route::get('/contractors/ip', [AuthUserController::class, 'ip'])->name('authuser.ip');
Route::get('/contractors/wipe', [AuthUserController::class, 'wipe'])->name('authuser.wipe');

Route::get('/auth/google', [AuthUserGoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [AuthUserGoogleController::class, 'callback']);

Route::resource('passwordresets', PasswordresetController::class);

Route::get('/sessioninfo', [SessioninfoController::class, 'index'])->name('sessioninfo.index');
Route::get('/sessioninfo/debug', [SessioninfoController::class, 'debug'])->name('sessioninfo.debug');
Route::get('/sessioninfo/admindebug', [SessioninfoController::class, 'admindebug'])->name('sessioninfo.admindebug');

Route::get('/docusigncode', [DocusigndocumentController::class, 'index'])->name('docusigndocuments.index');
Route::get('/dst', [DocusigndocumentController::class, 'dst'])->name('docusigndocuments.dst');
Route::post('/docusigncode/sendcode', [DocusigndocumentController::class, 'sendcode'])->name('docusigndocuments.sendcode');

Route::get('/qr', [QrController::class, 'index'])->name('qr.index');

Route::get('/admin', function () {
    return redirect('/authadmin/login');
});

Route::get('/clear', fn () => '')->name('clear');

Route::group([
    'name' => 'user.',
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => [
        AuthUser::class,
    ],
], function () {

    Route::post('/workorders/prg', [WorkorderController::class, 'prg'])->name('workorders.prg');
    Route::post('/workorders/transfer', [WorkorderController::class, 'transfer'])->name('workorders.transfer');
    Route::get('/workorders/history', [WorkorderController::class, 'history'])->name('workorders.history');
    Route::get('/workorders/hospitalchange/{workorder}', [WorkorderController::class, 'hospitalchange'])->name('workorders.hospitalchange');
    Route::get('/workorders/related/{workorder}', [WorkorderController::class, 'related'])->name('workorders.related');
    Route::get('/workorders/cancel/{workorder}', [WorkorderController::class, 'cancel'])->name('workorders.cancel');
    Route::get('/workorders/reopen/{workorder}', [WorkorderController::class, 'reopen'])->name('workorders.reopen');
    Route::get('/workorders/duplicate/{workorder}', [WorkorderController::class, 'duplicate'])->name('workorders.duplicate');
    Route::get('/workorders/docusign/{workorder}', [WorkorderController::class, 'docusign'])->name('workorders.docusign');

    Route::get('/workorders/payment/{workorder}', [WorkorderController::class, 'payment'])->name('workorders.payment');
    Route::patch('/workorders/paymentupdate/{workorder}', [WorkorderController::class, 'paymentupdate'])->name('workorders.paymentupdate');

    Route::get('/workorders/paymentnote/{workorder}', [WorkorderController::class, 'paymentnote'])->name('workorders.paymentnote');
    Route::patch('/workorders/paymentnoteupdate/{workorder}', [WorkorderController::class, 'paymentnoteupdate'])->name('workorders.paymentnoteupdate');

    Route::patch('/workorders/updatestatusnote/{workorder}', [WorkorderController::class, 'updatestatusnote'])->name('workorders.updatestatusnote');
    Route::patch('/workorders/updatefollowupstatus/{workorder}', [WorkorderController::class, 'updatefollowupstatus'])->name('workorders.updatefollowupstatus');
    Route::patch('/workorders/updatefollowupnote/{workorder}', [WorkorderController::class, 'updatefollowupnote'])->name('workorders.updatefollowupnote');

    Route::get('/workorders/changerequestor/{workorder}', [WorkorderController::class, 'changerequestor'])->name('workorders.changerequestor');
    Route::patch('/workorders/changerequestorupdate/{workorder}', [WorkorderController::class, 'changerequestorupdate'])->name('workorders.changerequestorupdate');

    Route::patch('/workorders/workorderhospitalupdate', [WorkorderController::class, 'workorderhospitalupdate'])->name('workorders.workorderhospitalupdate');
    Route::patch('/workorders/workorderhospitalstore', [WorkorderController::class, 'workorderhospitalstore'])->name('workorders.workorderhospitalstore');
    Route::patch('/workorders/cancelupdate/{workorder}', [WorkorderController::class, 'cancelupdate'])->name('workorders.cancelupdate');
    Route::patch('/workorders/reopenupdate/{workorder}', [WorkorderController::class, 'reopenupdate'])->name('workorders.reopenupdate');
    Route::patch('/workorders/duplicateupdate/{workorder}', [WorkorderController::class, 'duplicateupdate'])->name('workorders.duplicateupdate');

    Route::get('/workorders/export', [WorkorderController::class, 'export'])->name('workorders.export');

    Route::resource('workorders', WorkorderController::class);

    Route::resource('woins', WoinController::class);

    Route::get('/workorderfiles/file', [WorkorderfileController::class, 'file'])->name('workorderfiles.file');
    Route::get('/workorderfiles/qr/{W_WorkOrder}', [WorkorderfileController::class, 'qr'])->name('workorderfiles.qr');
    Route::get('/workorderfiles/coverpage/{W_WorkOrder}', [WorkorderfileController::class, 'coverpage'])->name('workorderfiles.coverpage');
    Route::get('/workorderfiles/createrequestfile', [WorkorderfileController::class, 'createrequestfile'])->name('workorderfiles.createrequestfile');
    Route::post('/workorderfiles/fileupload/{workorder}', [WorkorderfileController::class, 'fileupload'])->name('workorderfiles.fileupload');

    Route::post('/workorderfiles/authcheckembed', [WorkorderfileController::class, 'authcheckembed'])->name('workorderfiles.authcheckembed');

    Route::resource('workorderfiles', WorkorderfileController::class);

    Route::resource('workorderprefills', WorkorderprefillController::class);

    Route::resource('workorderfiledownloads', WorkorderfiledownloadController::class);
    Route::resource('workorderfiletransfers', WorkorderfiletransferController::class);

    Route::resource('examrequests', ExamrequestController::class);

    Route::post('/hospitals/prg', [HospitalController::class, 'prg'])->name('hospitals.prg');
    Route::post('/hospitals/transfer', [HospitalController::class, 'transfer'])->name('hospitals.transfer');
    Route::post('/hospitals/fileupload/{hospital}', [HospitalController::class, 'fileupload'])->name('hospitals.fileupload');
    Route::resource('hospitals', HospitalController::class);

    Route::resource('files', FileController::class);

    Route::resource('requestlogs', RequestlogController::class);

    Route::resource('shipments', ShipmentController::class);

    Route::resource('workorderpayments', WorkorderpaymentController::class);

    Route::resource('faxes', FaxController::class);

    Route::resource('emails', EmailController::class);

    Route::resource('additionalrequests', AdditionalrequestController::class);
    Route::resource('creditcardauthorizations', CreditcardauthorizationController::class);

    Route::get('/docusigns/index', [DocusignController::class, 'index'])->name('docusigns.index');
    Route::post('/docusigns/setup', [DocusignController::class, 'setup'])->name('docusigns.setup');
    Route::get('/docusigns/edit', [DocusignController::class, 'edit'])->name('docusigns.edit');
    Route::post('/docusigns/update', [DocusignController::class, 'update'])->name('docusigns.update');
    Route::post('/docusigns/sign', [DocusignController::class, 'sign'])->name('docusigns.sign');
    // Route::resource('docusigns', App\Http\Controllers\User\DocusignController::class);

    Route::post('/docusignchanges/resend', [DocusignchangeController::class, 'resend'])->name('docusignchanges.resend');
    Route::post('/docusignchanges/voidenvelope', [DocusignchangeController::class, 'voidenvelope'])->name('docusignchanges.voidenvelope');
    Route::resource('docusignchanges', DocusignchangeController::class);

    Route::get('/docusigndocuments/download', [App\Http\Controllers\User\DocusigndocumentController::class, 'download'])->name('docusigndocuments.download');
    Route::get('/docusigndocuments/stats', [App\Http\Controllers\User\DocusigndocumentController::class, 'stats'])->name('docusigndocuments.stats');
    Route::resource('docusigndocuments', App\Http\Controllers\User\DocusigndocumentController::class);

    Route::get('/prefills/stats', [PrefillController::class, 'stats'])->name('prefills.stats');
    Route::resource('prefills', PrefillController::class);

    Route::resource('signforms', SignformController::class);

    Route::post('/facilityforms/fileupload/{facilityform}', [FacilityformController::class, 'fileupload'])->name('facilityforms.fileupload');
    Route::get('/facilityforms/file', [FacilityformController::class, 'file'])->name('facilityforms.file');
    Route::resource('facilityforms', FacilityformController::class);

    Route::get('/filetransfers', [FiletransferController::class, 'index'])->name('filetransfers.index');
    Route::get('/filetransfers/{filetransfer}', [FiletransferController::class, 'show'])->name('filetransfers.show');

    Route::get('datachanges', [DatachangeController::class, 'index'])->name('datachanges.index');
    Route::get('datachanges/{datachange}', [DatachangeController::class, 'show'])->name('datachanges.show');

    Route::resource('statustriggers', StatustriggerController::class);

    Route::post('/copyservices/fileupload/{copyservice}', [CopyserviceController::class, 'fileupload'])->name('copyservices.fileupload');
    Route::resource('copyservices', CopyserviceController::class);

    Route::resource('alternatepayments', AlternatepaymentController::class);

    Route::resource('rois', RoiController::class);

    Route::resource('companyupdates', CompanyupdateController::class);

    Route::get('/bankstatements', [BankstatementController::class, 'index'])->name('bankstatements.index');
    Route::get('/bankstatements/{bankstatement}', [BankstatementController::class, 'show'])->name('bankstatements.show');

    Route::get('/workorderholdtimes/detail', [WorkorderholdtimeController::class, 'detail'])->name('workorderholdtimes.detail');
    Route::resource('workorderholdtimes', WorkorderholdtimeController::class);

    Route::resource('workordernotices', WorkordernoticeController::class);

    Route::resource('workorderemails', WorkorderemailController::class);
    Route::resource('workorderemailsend', WorkorderemailsendController::class);

    Route::resource('checks', CheckController::class);

    Route::get('requestors/autocomplete', [RequestorController::class, 'autocomplete'])->name('requestors.autocomplete');

    Route::get('contractors/logout', [ContractorController::class, 'logout'])->name('contractors.logout');
    Route::resource('contractors', ContractorController::class);

    Route::get('/tickets/comment/{ticket}', [TicketController::class, 'comment'])->name('tickets.comment');
    Route::post('/tickets/commentadd/{ticket}', [TicketController::class, 'commentadd'])->name('tickets.commentadd');
    Route::post('/tickets/fileadd/{ticket}', [TicketController::class, 'fileadd'])->name('tickets.fileadd');
    Route::get('/tickets/filedownload/{ticket}', [TicketController::class, 'filedownload'])->name('tickets.filedownload');
    Route::post('/tickets/close/{ticket}', [TicketController::class, 'close'])->name('tickets.close');
    Route::resource('tickets', TicketController::class);

    Route::resource('purge_configs', PurgeConfigController::class);

    Route::resource('incoming_aps_configs', IncomingApsConfigController::class);
    Route::resource('incoming_aps_logs', IncomingApsLogController::class);

    Route::resource('report_configs', ReportConfigController::class);
    Route::resource('report_config_types', ReportConfigTypeController::class);
    Route::resource('report_config_names', ReportConfigNameController::class);

    Route::view('utilities', 'user.utilities.index')->name('utilities.index');

    Route::resource('shippinglabels', ShippinglabelController::class);

    Route::resource('apscancellations', ApscancellationController::class);

    Route::resource('inquiries', InquiryController::class);

    Route::resource('insurancecompanies', InsurancecompanyController::class);

    Route::post('/seqsterorders/sendemail/{id}', [SeqsterorderController::class, 'sendemail'])->name('seqsterorders.sendemail');
    Route::get('/seqsterorders/stats', [SeqsterorderController::class, 'stats'])->name('seqsterorders.stats');
    Route::resource('seqsterorders', SeqsterorderController::class);

    Route::any('/ehrorders/invitationemailfasten/{id}', [EhrorderController::class, 'invitationemailfasten'])->name('ehrorders.invitationemailfasten');
    Route::get('/ehrorders/coverpage/{ehrorder}', [EhrorderController::class, 'coverpage'])->name('ehrorders.coverpage');
    Route::resource('ehrorders', EhrorderController::class);

    Route::get('/ehrorderssearchresults/export', [EhrorderssearchresultController::class, 'export'])->name('ehrorderssearchresults.export');

    Route::post('/ehrorderssearchresults/{id}/requestrecords', [EhrorderssearchresultController::class, 'requestrecords']);

    Route::resource('ehrorderssearchresults', EhrorderssearchresultController::class);
    Route::resource('ehrorderssearchresultsexclusions', EhrorderssearchresultsexclusionController::class);
    Route::resource('ehrordersdocuments', EhrordersdocumentController::class);

    Route::post('/timecards/clockin', [TimecardController::class, 'clockin'])->name('timecards.clockin');
    Route::post('/timecards/clockout', [TimecardController::class, 'clockout'])->name('timecards.clockout');
    Route::post('/timecards/breakstart', [TimecardController::class, 'breakstart'])->name('timecards.breakstart');
    Route::post('/timecards/breakend', [TimecardController::class, 'breakend'])->name('timecards.breakend');
    Route::resource('timecards', TimecardController::class);

    Route::get('/synodextransmissions/acordreferenceid', [SynodextransmissionsController::class, 'acordreferenceid'])->name('synodextransmissions.acordreferenceid');
    Route::resource('synodextransmissions', SynodextransmissionsController::class);

    Route::resource('addonorders', AddonorderController::class);

    Route::resource('workorderdetails', WorkorderdetailController::class);

    Route::resource('webhooks', WebhookController::class);

    Route::get('/daily_stats', [DailyStatController::class, 'index'])->name('daily_stats.index');
    Route::get('/daily_stats/totals', [DailyStatController::class, 'totals'])->name('daily_stats.totals');

    Route::post('/llm/chat', [LlmController::class, 'chat'])->name('llm.chat');
    Route::post('/spell/chat', [SpellController::class, 'chat'])->name('spell.chat');

    // #########################################################################################################################
    Route::post('/llm/follow-up-status-review/{workorder:W_WorkOrder}', [FollowUpStatusReviewController::class, 'review'])
        ->name('llm.followupstatusreview.review');
    // #######################################################################################################################

    Route::get('/contractorlogins/stats', [ContractorloginController::class, 'stats'])->name('contractorlogins.stats');
    Route::get('/contractorlogins/statsdaily', [ContractorloginController::class, 'statsdaily'])->name('contractorlogins.statsdaily');

    Route::resource('orders', OrderController::class);

    Route::resource('eisweborders', EisweborderController::class);
});

Route::group([
    'name' => 'admin.',
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => [
        AuthAdmin::class,
        'auth:admin',
    ],
], function () {

    Route::get('/contractors/resetcompanyupdates', [App\Http\Controllers\Admin\ContractorController::class, 'resetcompanyupdates'])->name('contractors.resetcompanyupdates');
    Route::resource('contractors', App\Http\Controllers\Admin\ContractorController::class);
    Route::resource('contractorloginips', ContractorloginipController::class);
    Route::resource('contractorloginattempts', ContractorloginattemptController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('requestors', App\Http\Controllers\Admin\RequestorController::class);
    Route::resource('creditcards', CreditcardController::class);
    Route::resource('datachanges', App\Http\Controllers\Admin\DatachangeController::class);
    Route::resource('filetransfers', App\Http\Controllers\Admin\FiletransferController::class);
    Route::resource('statustriggers', App\Http\Controllers\Admin\StatustriggerController::class);
    Route::resource('billtopicklists', BilltopicklistController::class);

    Route::get('/contractors/{contractor}/password', [App\Http\Controllers\Admin\ContractorController::class, 'password'])->name('contractors.password');
    Route::patch('/contractors/{contractor}/passwordupdate', [App\Http\Controllers\Admin\ContractorController::class, 'passwordupdate'])->name('contractors.passwordupdate');

    Route::get('/requestors/{requestor}/password', [App\Http\Controllers\Admin\RequestorController::class, 'password'])->name('requestors.password');
    Route::patch('/requestors/{requestor}/passwordupdate', [App\Http\Controllers\Admin\RequestorController::class, 'passwordupdate'])->name('requestors.passwordupdate');

    Route::get('/contractorlogins/stats', [App\Http\Controllers\Admin\ContractorloginController::class, 'stats'])->name('contractorlogins.stats');
    Route::get('/contractorlogins/statsdaily', [App\Http\Controllers\Admin\ContractorloginController::class, 'statsdaily'])->name('contractorlogins.statsdaily');
    Route::resource('contractorlogins', App\Http\Controllers\Admin\ContractorloginController::class);

    Route::get('/logins/stats', [LoginController::class, 'stats'])->name('logins.stats');
    Route::resource('logins', LoginController::class);

    Route::get('/loginattempts/stats', [LoginattemptController::class, 'stats'])->name('loginattempts.stats');
    Route::resource('loginattempts', LoginattemptController::class);

    Route::resource('loginips', LoginipController::class);

    Route::resource('companyupdates', App\Http\Controllers\Admin\CompanyupdateController::class);

    Route::get('/workorders/stats', [App\Http\Controllers\Admin\WorkorderController::class, 'stats'])->name('workorders.stats');
    Route::resource('workorders', App\Http\Controllers\Admin\WorkorderController::class);

    Route::get('/workorderholdtimes/stats', [App\Http\Controllers\Admin\WorkorderholdtimeController::class, 'stats'])->name('workorderholdtimes.stats');
    Route::resource('workorderholdtimes', App\Http\Controllers\Admin\WorkorderholdtimeController::class);

    Route::get('/docusigndocuments/stats', [App\Http\Controllers\Admin\DocusigndocumentController::class, 'stats'])->name('docusigndocuments.stats');
    Route::resource('docusigndocuments', App\Http\Controllers\Admin\DocusigndocumentController::class);

    Route::resource('files', App\Http\Controllers\Admin\FileController::class);

    Route::resource('workordernotices', App\Http\Controllers\Admin\WorkordernoticeController::class);

    Route::resource('passwordresets', App\Http\Controllers\Admin\PasswordresetController::class);

    Route::resource('requestorroles', RequestorroleController::class);
    Route::resource('websiteconfigs', WebsiteconfigController::class);

    Route::post('/ticketmanagers/assign', [TicketmanagerController::class, 'assign'])->name('ticketmanagers.assign');
    Route::resource('ticketmanagers', TicketmanagerController::class);

    Route::resource('over60daysnoticeconfigs', Over60daysnoticeconfigController::class);

    Route::resource('settings', SettingController::class);

    Route::resource('accountmanagers', AccountmanagerController::class);

    Route::resource('platform-configurations', PlatformConfigurationController::class);

    Route::resource('requestor-password-changes', RequestorPasswordChangeController::class);

    Route::resource('changelogs', ChangelogController::class);

    Route::resource('shelteragents', ShelteragentController::class);

    Route::resource('smartaccessthemes', SmartaccessthemeController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('azure', AzureController::class);
});
