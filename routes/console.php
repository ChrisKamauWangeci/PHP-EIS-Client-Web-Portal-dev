<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:smartaccesscreate eis')->everyMinute();

Schedule::command('app:cancelstatuscreate')->everyFiveMinutes();

Schedule::command('app:faxcompany eis')->everyFiveMinutes()->withoutOverlapping();
Schedule::command('app:faxcompany nyl')->everyFiveMinutes()->withoutOverlapping();
Schedule::command('app:faxcompany usaa')->everyFiveMinutes()->withoutOverlapping();

Schedule::command('app:docusigndownload')->everyFiveMinutes();
Schedule::command('app:docusignresend')->everyTenMinutes();
Schedule::command('app:docusignvoidcompleted')->daily()->appendOutputTo(storage_path('app/private/docusignvoidcompleted.txt'))->emailOutputTo('andras@expressimagingservices.com');

Schedule::command('app:hospitalfacilityformupdate')->everyTenMinutes();
Schedule::command('app:hospitaltimezoneupdate')->everyTenMinutes();

Schedule::command('app:ehrordereneratecoverpage eis')->everyTenMinutes();

Schedule::command('app:seqsterordercreate')->everyThirtyMinutes();

Schedule::command('app:iplookup eis')->hourly();

Schedule::command('app:importshelteragentcode eis')->twiceDaily(9, 14);

Schedule::command('app:seqsterorderprovider')->hourly();

Schedule::command('app:seqsterorderreport')->twiceDaily(8, 16);
Schedule::command('app:seqsterorderreport')->daily();
Schedule::command('app:seqsterorderremindernorthwesternmutual')->dailyAt('06:00')->appendOutputTo(storage_path('app/private/seqsterorderreminder-northwesternmutual.txt'));

Schedule::command('app:faxreport')->daily();
Schedule::command('app:faxreportcompany')->dailyAt('07:00');

Schedule::command('app:dailystatrecord')->dailyAt('01:00');

Schedule::command('app:dailystatreport ' . now()->subDay()->toDateString() . ' ' . now()->subDay()->toDateString())->dailyAt('06:00');
Schedule::command('app:dailystatreport ' . now()->toDateString() . ' ' . now()->toDateString())->dailyAt('12:00');

Schedule::command('app:datamaintenance eisuat')->weekly()->appendOutputTo(storage_path('app/private/data-eisuat.txt'));
Schedule::command('app:datamaintenance eis')->weekly()->appendOutputTo(storage_path('app/private/data-eis.txt'));
Schedule::command('app:datamaintenance nyl')->weekly()->appendOutputTo(storage_path('app/private/data-nyl.txt'));
Schedule::command('app:datamaintenance usaa')->weekly()->appendOutputTo(storage_path('app/private/data-usaa.txt'));

Schedule::command('app:workorderpushback eis')->monthlyOn(1, '12:00')->appendOutputTo(storage_path('app/private/workorderpushback-eis.txt'));
Schedule::command('app:workorderpushback usaa')->monthlyOn(1, '12:00')->appendOutputTo(storage_path('app/private/workorderpushback-usaa.txt'));
Schedule::command('app:workorderpushback nyl')->monthlyOn(1, '12:00')->appendOutputTo(storage_path('app/private/workorderpushback-nyl.txt'));
