<?php

declare(strict_types=1);

use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/smartaccess', [App\Http\Controllers\SmartaccessController::class, 'index']);

Route::get('/authadmin/signin', [App\Http\Controllers\AuthAdminController::class, 'login'])->name('login');
Route::get('/authadmin/login', [App\Http\Controllers\AuthAdminController::class, 'login'])->name('authadmin.login');
Route::post('/authadmin/in', [App\Http\Controllers\AuthAdminController::class, 'in'])->name('authadmin.in');
Route::get('/authadmin/ipconfirm', [App\Http\Controllers\AuthAdminController::class, 'ipconfirm'])->name('authadmin.ipconfirm');
Route::post('/authadmin/ipconfirmin', [App\Http\Controllers\AuthAdminController::class, 'ipconfirmin'])->name('authadmin.ipconfirmin');
Route::get('/authadmin/logout', [App\Http\Controllers\AuthAdminController::class, 'logout'])->name('authadmin.logout');

Route::get('/contractors/login', [App\Http\Controllers\AuthUserController::class, 'login'])->name('authuser.login');
Route::post('/contractors/in', [App\Http\Controllers\AuthUserController::class, 'in'])->name('authuser.in');
Route::get('/contractors/ipconfirm', [App\Http\Controllers\AuthUserController::class, 'ipconfirm'])->name('authuser.ipconfirm');
Route::post('/contractors/ipconfirmin', [App\Http\Controllers\AuthUserController::class, 'ipconfirmin'])->name('authuser.ipconfirmin');
Route::get('/contractors/logout', [App\Http\Controllers\AuthUserController::class, 'logout'])->name('authuser.logout');
Route::get('/contractors/ip', [App\Http\Controllers\AuthUserController::class, 'ip'])->name('authuser.ip');
Route::get('/contractors/wipe', [App\Http\Controllers\AuthUserController::class, 'wipe'])->name('authuser.wipe');

Route::get('/auth/google', [App\Http\Controllers\AuthUserGoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [App\Http\Controllers\AuthUserGoogleController::class, 'callback']);

Route::resource('passwordresets', App\Http\Controllers\PasswordresetController::class);

Route::get('/sessioninfo', [App\Http\Controllers\SessioninfoController::class, 'index'])->name('sessioninfo.index');
Route::get('/sessioninfo/debug', [App\Http\Controllers\SessioninfoController::class, 'debug'])->name('sessioninfo.debug');
Route::get('/sessioninfo/admindebug', [App\Http\Controllers\SessioninfoController::class, 'admindebug'])->name('sessioninfo.admindebug');

Route::get('/docusigncode', [App\Http\Controllers\DocusigndocumentController::class, 'index'])->name('docusigndocuments.index');
Route::get('/dst', [App\Http\Controllers\DocusigndocumentController::class, 'dst'])->name('docusigndocuments.dst');
Route::post('/docusigncode/sendcode', [App\Http\Controllers\DocusigndocumentController::class, 'sendcode'])->name('docusigndocuments.sendcode');

Route::get('/qr', [App\Http\Controllers\QrController::class, 'index'])->name('qr.index');

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

    Route::post('/workorders/prg', [App\Http\Controllers\User\WorkorderController::class, 'prg'])->name('workorders.prg');
    Route::post('/workorders/transfer', [App\Http\Controllers\User\WorkorderController::class, 'transfer'])->name('workorders.transfer');
    Route::get('/workorders/history', [App\Http\Controllers\User\WorkorderController::class, 'history'])->name('workorders.history');
    Route::get('/workorders/hospitalchange/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'hospitalchange'])->name('workorders.hospitalchange');
    Route::get('/workorders/related/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'related'])->name('workorders.related');
    Route::get('/workorders/cancel/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'cancel'])->name('workorders.cancel');
    Route::get('/workorders/reopen/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'reopen'])->name('workorders.reopen');
    Route::get('/workorders/duplicate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'duplicate'])->name('workorders.duplicate');
    Route::get('/workorders/docusign/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'docusign'])->name('workorders.docusign');

    Route::get('/workorders/payment/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'payment'])->name('workorders.payment');
    Route::patch('/workorders/paymentupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'paymentupdate'])->name('workorders.paymentupdate');

    Route::get('/workorders/paymentnote/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'paymentnote'])->name('workorders.paymentnote');
    Route::patch('/workorders/paymentnoteupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'paymentnoteupdate'])->name('workorders.paymentnoteupdate');

    Route::patch('/workorders/updatestatusnote/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'updatestatusnote'])->name('workorders.updatestatusnote');
    Route::patch('/workorders/updatefollowupstatus/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'updatefollowupstatus'])->name('workorders.updatefollowupstatus');
    Route::patch('/workorders/updatefollowupnote/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'updatefollowupnote'])->name('workorders.updatefollowupnote');

    Route::get('/workorders/changerequestor/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'changerequestor'])->name('workorders.changerequestor');
    Route::patch('/workorders/changerequestorupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'changerequestorupdate'])->name('workorders.changerequestorupdate');

    Route::patch('/workorders/workorderhospitalupdate', [App\Http\Controllers\User\WorkorderController::class, 'workorderhospitalupdate'])->name('workorders.workorderhospitalupdate');
    Route::patch('/workorders/workorderhospitalstore', [App\Http\Controllers\User\WorkorderController::class, 'workorderhospitalstore'])->name('workorders.workorderhospitalstore');
    Route::patch('/workorders/cancelupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'cancelupdate'])->name('workorders.cancelupdate');
    Route::patch('/workorders/reopenupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'reopenupdate'])->name('workorders.reopenupdate');
    Route::patch('/workorders/duplicateupdate/{workorder}', [App\Http\Controllers\User\WorkorderController::class, 'duplicateupdate'])->name('workorders.duplicateupdate');

    Route::get('/workorders/export', [App\Http\Controllers\User\WorkorderController::class, 'export'])->name('workorders.export');

    Route::resource('workorders', App\Http\Controllers\User\WorkorderController::class);

    Route::resource('woins', App\Http\Controllers\User\WoinController::class);

    Route::get('/workorderfiles/file', [App\Http\Controllers\User\WorkorderfileController::class, 'file'])->name('workorderfiles.file');
    Route::get('/workorderfiles/qr/{W_WorkOrder}', [App\Http\Controllers\User\WorkorderfileController::class, 'qr'])->name('workorderfiles.qr');
    Route::get('/workorderfiles/coverpage/{W_WorkOrder}', [App\Http\Controllers\User\WorkorderfileController::class, 'coverpage'])->name('workorderfiles.coverpage');
    Route::get('/workorderfiles/createrequestfile', [App\Http\Controllers\User\WorkorderfileController::class, 'createrequestfile'])->name('workorderfiles.createrequestfile');
    Route::post('/workorderfiles/fileupload/{workorder}', [App\Http\Controllers\User\WorkorderfileController::class, 'fileupload'])->name('workorderfiles.fileupload');

    Route::post('/workorderfiles/authcheckembed', [App\Http\Controllers\User\WorkorderfileController::class, 'authcheckembed'])->name('workorderfiles.authcheckembed');

    Route::resource('workorderfiles', App\Http\Controllers\User\WorkorderfileController::class);

    Route::resource('workorderprefills', App\Http\Controllers\User\WorkorderprefillController::class);

    Route::resource('workorderfiledownloads', App\Http\Controllers\User\WorkorderfiledownloadController::class);
    Route::resource('workorderfiletransfers', App\Http\Controllers\User\WorkorderfiletransferController::class);

    Route::resource('examrequests', App\Http\Controllers\User\ExamrequestController::class);

    Route::post('/hospitals/prg', [App\Http\Controllers\User\HospitalController::class, 'prg'])->name('hospitals.prg');
    Route::post('/hospitals/transfer', [App\Http\Controllers\User\HospitalController::class, 'transfer'])->name('hospitals.transfer');
    Route::post('/hospitals/fileupload/{hospital}', [App\Http\Controllers\User\HospitalController::class, 'fileupload'])->name('hospitals.fileupload');
    Route::resource('hospitals', App\Http\Controllers\User\HospitalController::class);

    Route::resource('files', App\Http\Controllers\User\FileController::class);

    Route::resource('requestlogs', App\Http\Controllers\User\RequestlogController::class);

    Route::resource('shipments', App\Http\Controllers\User\ShipmentController::class);

    Route::resource('workorderpayments', App\Http\Controllers\User\WorkorderpaymentController::class);

    Route::resource('faxes', App\Http\Controllers\User\FaxController::class);

    Route::resource('emails', App\Http\Controllers\User\EmailController::class);

    Route::resource('additionalrequests', App\Http\Controllers\User\AdditionalrequestController::class);
    Route::resource('creditcardauthorizations', App\Http\Controllers\User\CreditcardauthorizationController::class);

    Route::get('/docusigns/index', [App\Http\Controllers\User\DocusignController::class, 'index'])->name('docusigns.index');
    Route::post('/docusigns/setup', [App\Http\Controllers\User\DocusignController::class, 'setup'])->name('docusigns.setup');
    Route::get('/docusigns/edit', [App\Http\Controllers\User\DocusignController::class, 'edit'])->name('docusigns.edit');
    Route::post('/docusigns/update', [App\Http\Controllers\User\DocusignController::class, 'update'])->name('docusigns.update');
    Route::post('/docusigns/sign', [App\Http\Controllers\User\DocusignController::class, 'sign'])->name('docusigns.sign');
    // Route::resource('docusigns', App\Http\Controllers\User\DocusignController::class);

    Route::post('/docusignchanges/resend', [App\Http\Controllers\User\DocusignchangeController::class, 'resend'])->name('docusignchanges.resend');
    Route::post('/docusignchanges/voidenvelope', [App\Http\Controllers\User\DocusignchangeController::class, 'voidenvelope'])->name('docusignchanges.voidenvelope');
    Route::resource('docusignchanges', App\Http\Controllers\User\DocusignchangeController::class);

    Route::get('/docusigndocuments/download', [App\Http\Controllers\User\DocusigndocumentController::class, 'download'])->name('docusigndocuments.download');
    Route::get('/docusigndocuments/stats', [App\Http\Controllers\User\DocusigndocumentController::class, 'stats'])->name('docusigndocuments.stats');
    Route::resource('docusigndocuments', App\Http\Controllers\User\DocusigndocumentController::class);

    Route::get('/prefills/stats', [App\Http\Controllers\User\PrefillController::class, 'stats'])->name('prefills.stats');
    Route::resource('prefills', App\Http\Controllers\User\PrefillController::class);

    Route::resource('signforms', App\Http\Controllers\User\SignformController::class);

    Route::post('/facilityforms/fileupload/{facilityform}', [App\Http\Controllers\User\FacilityformController::class, 'fileupload'])->name('facilityforms.fileupload');
    Route::get('/facilityforms/file', [App\Http\Controllers\User\FacilityformController::class, 'file'])->name('facilityforms.file');
    Route::resource('facilityforms', App\Http\Controllers\User\FacilityformController::class);

    Route::get('/filetransfers', [App\Http\Controllers\User\FiletransferController::class, 'index'])->name('filetransfers.index');
    Route::get('/filetransfers/{filetransfer}', [App\Http\Controllers\User\FiletransferController::class, 'show'])->name('filetransfers.show');

    Route::get('datachanges', [App\Http\Controllers\User\DatachangeController::class, 'index'])->name('datachanges.index');
    Route::get('datachanges/{datachange}', [App\Http\Controllers\User\DatachangeController::class, 'show'])->name('datachanges.show');

    Route::resource('statustriggers', App\Http\Controllers\User\StatustriggerController::class);

    Route::post('/copyservices/fileupload/{copyservice}', [App\Http\Controllers\User\CopyserviceController::class, 'fileupload'])->name('copyservices.fileupload');
    Route::resource('copyservices', App\Http\Controllers\User\CopyserviceController::class);

    Route::resource('alternatepayments', App\Http\Controllers\User\AlternatepaymentController::class);

    Route::resource('rois', App\Http\Controllers\User\RoiController::class);

    Route::resource('companyupdates', App\Http\Controllers\User\CompanyupdateController::class);

    Route::get('/bankstatements', [App\Http\Controllers\User\BankstatementController::class, 'index'])->name('bankstatements.index');
    Route::get('/bankstatements/{bankstatement}', [App\Http\Controllers\User\BankstatementController::class, 'show'])->name('bankstatements.show');

    Route::get('/workorderholdtimes/detail', [App\Http\Controllers\User\WorkorderholdtimeController::class, 'detail'])->name('workorderholdtimes.detail');
    Route::resource('workorderholdtimes', App\Http\Controllers\User\WorkorderholdtimeController::class);

    Route::resource('workordernotices', App\Http\Controllers\User\WorkordernoticeController::class);

    Route::resource('workorderemails', App\Http\Controllers\User\WorkorderemailController::class);
    Route::resource('workorderemailsend', App\Http\Controllers\User\WorkorderemailsendController::class);

    Route::resource('checks', App\Http\Controllers\User\CheckController::class);

    Route::get('requestors/autocomplete', [App\Http\Controllers\User\RequestorController::class, 'autocomplete'])->name('requestors.autocomplete');

    Route::get('contractors/logout', [App\Http\Controllers\User\ContractorController::class, 'logout'])->name('contractors.logout');
    Route::resource('contractors', App\Http\Controllers\User\ContractorController::class);

    Route::get('/tickets/comment/{ticket}', [App\Http\Controllers\User\TicketController::class, 'comment'])->name('tickets.comment');
    Route::post('/tickets/commentadd/{ticket}', [App\Http\Controllers\User\TicketController::class, 'commentadd'])->name('tickets.commentadd');
    Route::post('/tickets/fileadd/{ticket}', [App\Http\Controllers\User\TicketController::class, 'fileadd'])->name('tickets.fileadd');
    Route::get('/tickets/filedownload/{ticket}', [App\Http\Controllers\User\TicketController::class, 'filedownload'])->name('tickets.filedownload');
    Route::post('/tickets/close/{ticket}', [App\Http\Controllers\User\TicketController::class, 'close'])->name('tickets.close');
    Route::resource('tickets', App\Http\Controllers\User\TicketController::class);

    Route::resource('purge_configs', App\Http\Controllers\User\PurgeConfigController::class);

    Route::resource('incoming_aps_configs', App\Http\Controllers\User\IncomingApsConfigController::class);
    Route::resource('incoming_aps_logs', App\Http\Controllers\User\IncomingApsLogController::class);

    Route::resource('report_configs', App\Http\Controllers\User\ReportConfigController::class);
    Route::resource('report_config_types', App\Http\Controllers\User\ReportConfigTypeController::class);
    Route::resource('report_config_names', App\Http\Controllers\User\ReportConfigNameController::class);

    Route::view('utilities', 'user.utilities.index')->name('utilities.index');

    Route::resource('shippinglabels', App\Http\Controllers\User\ShippinglabelController::class);

    Route::resource('apscancellations', App\Http\Controllers\User\ApscancellationController::class);

    Route::resource('inquiries', App\Http\Controllers\User\InquiryController::class);

    Route::resource('insurancecompanies', App\Http\Controllers\User\InsurancecompanyController::class);

    Route::post('/seqsterorders/sendemail/{id}', [App\Http\Controllers\User\SeqsterorderController::class, 'sendemail'])->name('seqsterorders.sendemail');
    Route::get('/seqsterorders/stats', [App\Http\Controllers\User\SeqsterorderController::class, 'stats'])->name('seqsterorders.stats');
    Route::resource('seqsterorders', App\Http\Controllers\User\SeqsterorderController::class);

    Route::any('/ehrorders/invitationemailfasten/{id}', [App\Http\Controllers\User\EhrorderController::class, 'invitationemailfasten'])->name('ehrorders.invitationemailfasten');
    Route::get('/ehrorders/coverpage/{ehrorder}', [App\Http\Controllers\User\EhrorderController::class, 'coverpage'])->name('ehrorders.coverpage');
    Route::resource('ehrorders', App\Http\Controllers\User\EhrorderController::class);

    Route::get('/ehrorderssearchresults/export', [App\Http\Controllers\User\EhrorderssearchresultController::class, 'export'])->name('ehrorderssearchresults.export');

    Route::post('/ehrorderssearchresults/{id}/requestrecords', [App\Http\Controllers\User\EhrorderssearchresultController::class, 'requestrecords']);

    Route::resource('ehrorderssearchresults', App\Http\Controllers\User\EhrorderssearchresultController::class);
    Route::resource('ehrorderssearchresultsexclusions', App\Http\Controllers\User\EhrorderssearchresultsexclusionController::class);
    Route::resource('ehrordersdocuments', App\Http\Controllers\User\EhrordersdocumentController::class);

    Route::post('/timecards/clockin', [App\Http\Controllers\User\TimecardController::class, 'clockin'])->name('timecards.clockin');
    Route::post('/timecards/clockout', [App\Http\Controllers\User\TimecardController::class, 'clockout'])->name('timecards.clockout');
    Route::post('/timecards/breakstart', [App\Http\Controllers\User\TimecardController::class, 'breakstart'])->name('timecards.breakstart');
    Route::post('/timecards/breakend', [App\Http\Controllers\User\TimecardController::class, 'breakend'])->name('timecards.breakend');
    Route::resource('timecards', \App\Http\Controllers\User\TimecardController::class);

    Route::get('/synodextransmissions/acordreferenceid', [App\Http\Controllers\User\SynodextransmissionsController::class, 'acordreferenceid'])->name('synodextransmissions.acordreferenceid');
    Route::resource('synodextransmissions', \App\Http\Controllers\User\SynodextransmissionsController::class);

    Route::resource('addonorders', \App\Http\Controllers\User\AddonorderController::class);

    Route::resource('workorderdetails', \App\Http\Controllers\User\WorkorderdetailController::class);

    Route::resource('webhooks', \App\Http\Controllers\User\WebhookController::class);

    Route::get('/daily_stats', [App\Http\Controllers\User\DailyStatController::class, 'index'])->name('daily_stats.index');
    Route::get('/daily_stats/totals', [App\Http\Controllers\User\DailyStatController::class, 'totals'])->name('daily_stats.totals');

    Route::post('/llm/chat', [App\Http\Controllers\User\LlmController::class, 'chat'])->name('llm.chat');
    Route::post('/spell/chat', [App\Http\Controllers\User\SpellController::class, 'chat'])->name('spell.chat');

    Route::get('/contractorlogins/stats', [App\Http\Controllers\User\ContractorloginController::class, 'stats'])->name('contractorlogins.stats');
    Route::get('/contractorlogins/statsdaily', [App\Http\Controllers\User\ContractorloginController::class, 'statsdaily'])->name('contractorlogins.statsdaily');

    Route::resource('orders', App\Http\Controllers\User\OrderController::class);

    Route::resource('eisweborders', App\Http\Controllers\User\EisweborderController::class);

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
    Route::resource('contractorloginips', App\Http\Controllers\Admin\ContractorloginipController::class);
    Route::resource('contractorloginattempts', App\Http\Controllers\Admin\ContractorloginattemptController::class);
    Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class);
    Route::resource('requestors', App\Http\Controllers\Admin\RequestorController::class);
    Route::resource('creditcards', App\Http\Controllers\Admin\CreditcardController::class);
    Route::resource('datachanges', App\Http\Controllers\Admin\DatachangeController::class);
    Route::resource('filetransfers', App\Http\Controllers\Admin\FiletransferController::class);
    Route::resource('statustriggers', App\Http\Controllers\Admin\StatustriggerController::class);
    Route::resource('billtopicklists', App\Http\Controllers\Admin\BilltopicklistController::class);

    Route::get('/contractors/{contractor}/password', [App\Http\Controllers\Admin\ContractorController::class, 'password'])->name('contractors.password');
    Route::patch('/contractors/{contractor}/passwordupdate', [App\Http\Controllers\Admin\ContractorController::class, 'passwordupdate'])->name('contractors.passwordupdate');

    Route::get('/requestors/{requestor}/password', [App\Http\Controllers\Admin\RequestorController::class, 'password'])->name('requestors.password');
    Route::patch('/requestors/{requestor}/passwordupdate', [App\Http\Controllers\Admin\RequestorController::class, 'passwordupdate'])->name('requestors.passwordupdate');

    Route::get('/contractorlogins/stats', [App\Http\Controllers\Admin\ContractorloginController::class, 'stats'])->name('contractorlogins.stats');
    Route::get('/contractorlogins/statsdaily', [App\Http\Controllers\Admin\ContractorloginController::class, 'statsdaily'])->name('contractorlogins.statsdaily');
    Route::resource('contractorlogins', App\Http\Controllers\Admin\ContractorloginController::class);

    Route::get('/logins/stats', [App\Http\Controllers\Admin\LoginController::class, 'stats'])->name('logins.stats');
    Route::resource('logins', App\Http\Controllers\Admin\LoginController::class);

    Route::get('/loginattempts/stats', [App\Http\Controllers\Admin\LoginattemptController::class, 'stats'])->name('loginattempts.stats');
    Route::resource('loginattempts', App\Http\Controllers\Admin\LoginattemptController::class);

    Route::resource('loginips', App\Http\Controllers\Admin\LoginipController::class);

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

    Route::resource('requestorroles', App\Http\Controllers\Admin\RequestorroleController::class);
    Route::resource('websiteconfigs', App\Http\Controllers\Admin\WebsiteconfigController::class);

    Route::post('/ticketmanagers/assign', [App\Http\Controllers\Admin\TicketmanagerController::class, 'assign'])->name('ticketmanagers.assign');
    Route::resource('ticketmanagers', App\Http\Controllers\Admin\TicketmanagerController::class);

    Route::resource('over60daysnoticeconfigs', App\Http\Controllers\Admin\Over60daysnoticeconfigController::class);

    Route::resource('settings', App\Http\Controllers\Admin\SettingController::class);

    Route::resource('accountmanagers', App\Http\Controllers\Admin\AccountmanagerController::class);

    Route::resource('platform-configurations', App\Http\Controllers\Admin\PlatformConfigurationController::class);

    Route::resource('requestor-password-changes', App\Http\Controllers\Admin\RequestorPasswordChangeController::class);

    Route::resource('changelogs', App\Http\Controllers\Admin\ChangelogController::class);

    Route::resource('shelteragents', App\Http\Controllers\Admin\ShelteragentController::class);

    Route::resource('smartaccessthemes', App\Http\Controllers\Admin\SmartaccessthemeController::class);

    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

    Route::resource('azure', \App\Http\Controllers\Admin\AzureController::class);

});
