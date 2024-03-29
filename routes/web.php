<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

// use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Auth::routes();
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login');

Route::group(['middleware' => 'auth'], function(){
    // Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard', function () {
        $user = DB::table('users AS a')
            ->leftJoin('t_mmatrix AS b', 'a.id', '=', 'b.t_muser_id')
            ->leftJoin('t_mresponsibility AS c', 'b.t_mresponsibility_id', '=', 'c.id')
            ->select('a.*', 'c.responsibility_name')
            ->where('a.id', Auth::guard()->id())->first();

        $auth = [
            'user_id'     => $user->id,
            'role'        => $user->responsibility_name,
            'email'       => $user->email,
            'name'        => $user->name,
        ];

        Session::put('user', $auth);
        return view('content');
    });
    Route::get('/logout', 'Otentikasi\OtentikasiController@logout')->name('logout');

    //Finance
    Route::get('/finance/invoice_terima', 'FinanceController@index')->name('finance.invoice_terima');


    /** Master */

    //Country
    Route::get('/master/country', 'MasterController@country')->name('master.country');
    Route::post('/master/country_doAdd', 'MasterController@country_doAdd')->name('master.country_doAdd');
    Route::post('/master/cek_country_code', 'MasterController@cek_country_code')->name('master.cek_country_code');
    Route::post('/master/country_doEdit', 'MasterController@country_doEdit')->name('master.country_doEdit');
    Route::post('/master/country_get', 'MasterController@country_get')->name('master.country_get');
    Route::post('/master/country_getAll', 'MasterController@get_all_country')->name('master.country_getAll');
    Route::get('/master/country_delete/{id}', 'MasterController@country_delete')->name('master.country_delete');

    //Carrier
    Route::get('/master/carrier', 'MasterController@carrier')->name('master.carrier');
    Route::post('/master/carrier_doAdd', 'MasterController@carrier_doAdd')->name('master.carrier_doAdd');
    Route::post('/master/cek_carrier_code', 'MasterController@cek_carrier_code')->name('master.cek_carrier_code');
    Route::post('/master/carrier_doEdit', 'MasterController@carrier_doEdit')->name('master.carrier_doEdit');
    Route::post('/master/carrier_get', 'MasterController@carrier_get')->name('master.carrier_get');
    Route::get('/master/carrier_delete/{id}', 'MasterController@carrier_delete')->name('master.carrier_delete');

    //Carrier
    Route::get('/master/charge', 'MasterController@charge')->name('master.charge');
    Route::post('/master/charge_doAdd', 'MasterController@charge_doAdd')->name('master.charge_doAdd');
    Route::post('/master/cek_charge_code', 'MasterController@cek_charge_code')->name('master.cek_charge_code');
    Route::post('/master/charge_doEdit', 'MasterController@charge_doEdit')->name('master.charge_doEdit');
    Route::post('/master/charge_get', 'MasterController@charge_get')->name('master.charge_get');
    Route::get('/master/charge_delete/{id}', 'MasterController@charge_delete')->name('master.charge_delete');

    //Vehicle
    Route::get('/master/vehicle', 'MasterController@vehicle')->name('master.vehicle');
    Route::post('/master/vehicle_doAdd', 'MasterController@vehicle_doAdd')->name('master.vehicle_doAdd');
    Route::post('/master/cek_vehicle_code', 'MasterController@cek_vehicle_code')->name('master.cek_vehicle_code');
    Route::post('/master/vehicle_doEdit', 'MasterController@vehicle_doEdit')->name('master.vehicle_doEdit');
    Route::post('/master/vehicle_get', 'MasterController@vehicle_get')->name('master.vehicle_get');
    Route::get('/master/vehicle_delete/{id}', 'MasterController@vehicle_delete')->name('master.vehicle_delete');

    //Port
    Route::get('/master/port', 'MasterController@port')->name('master.port');
    Route::post('/master/port_data', 'MasterController@port_data')->name('master.port_data');
    Route::post('/master/port_doAdd', 'MasterController@port_doAdd')->name('master.port_doAdd');
    Route::post('/master/cek_port_code', 'MasterController@cek_port_code')->name('master.cek_port_code');
    Route::post('/master/cek_port_name', 'MasterController@cek_port_name')->name('master.cek_port_name');
    Route::post('/master/port_doEdit', 'MasterController@port_doEdit')->name('master.port_doEdit');
    Route::post('/master/port_get', 'MasterController@port_get')->name('master.port_get');
    Route::post('/master/port_doEdit', 'MasterController@port_doEdit')->name('master.port_doEdit');
    Route::get('/master/port_delete/{id}', 'MasterController@port_delete')->name('master.port_delete');

    //Currency
    Route::get('/master/currency', 'MasterController@currency')->name('master.currency');
    Route::post('/master/currency_doAdd', 'MasterController@currency_doAdd')->name('master.currency_doAdd');
    Route::post('/master/cek_currency_code', 'MasterController@cek_currency_code')->name('master.cek_currency_code');
    Route::post('/master/currency_doEdit', 'MasterController@currency_doEdit')->name('master.currency_doEdit');
    Route::post('/master/currency_get', 'MasterController@currency_get')->name('master.currency_get');
    Route::post('/master/currency_doEdit', 'MasterController@currency_doEdit')->name('master.currency_doEdit');
    Route::get('/master/currency_delete/{id}', 'MasterController@currency_delete')->name('master.currency_delete');

    //Company
    Route::get('/master/company', 'MasterController@company')->name('master.company');
    Route::get('/master/company_add', 'MasterController@company_add')->name('master.company_add');
    Route::post('/master/company_addAddress', 'MasterController@company_addAddress')->name('master.company_addAddress');
    Route::post('/master/company_doAdd', 'MasterController@company_doAdd')->name('master.company_doAdd');
    Route::post('/master/cek_company_code', 'MasterController@cek_company_code')->name('master.cek_company_code');
    Route::get('/master/company_edit/{id}', 'MasterController@company_edit')->name('master.company_edit');
    Route::get('/master/company_view/{id}', 'MasterController@company_view')->name('master.company_view');
    Route::post('/master/company_doUpdate/{id}', 'MasterController@company_doUpdate')->name('master.company_doUpdate');
    Route::post('/master/company_loadDetail','MasterController@company_loadDetail')->name('master.company_loadDetail');
    Route::post('/master/company_deleteAddress','MasterController@company_deleteAddress')->name('master.company_deleteAddress');
    Route::post('/master/company_updateAddress', 'MasterController@company_updateAddress')->name('master.company_updateAddress');
    Route::post('/master/company_doEdit', 'MasterController@company_doEdit')->name('master.company_doEdit');
    Route::post('/master/company_get', 'MasterController@company_get')->name('master.company_get');
    Route::post('/master/company_doEdit', 'MasterController@company_doEdit')->name('master.company_doEdit');
    Route::get('/master/company_delete/{id}', 'MasterController@company_delete')->name('master.company_delete');

    Route::post('/master/company_addPic', 'MasterController@company_addPic')->name('master.company_addPic');
    Route::post('/master/company_loadDetailPic','MasterController@company_loadDetailPic')->name('master.company_loadDetailPic');
    Route::post('/master/company_deletePic','MasterController@company_deletePic')->name('master.company_deletePic');
    Route::post('/master/company_updatePic', 'MasterController@company_updatePic')->name('master.company_updatePic');

    //Document Type
    Route::get('/master/doc_type', 'MasterController@doc_type')->name('master.doc_type');
    Route::post('/master/doc_type_doAdd', 'MasterController@doc_type_doAdd')->name('master.doc_type_doAdd');
    Route::post('/master/doc_type_doEdit', 'MasterController@doc_type_doEdit')->name('master.doc_type_doEdit');
    Route::post('/master/doc_type_get', 'MasterController@doc_type_get')->name('master.doc_type_get');
    Route::get('/master/doc_type_delete/{id}', 'MasterController@doc_type_delete')->name('master.doc_type_delete');

    //User
    Route::get('/master/user', 'MasterController@user')->name('master.user');
    Route::post('/master/user_doAdd', 'MasterController@user_doAdd')->name('master.user_doAdd');
    Route::post('/master/user_doEdit', 'MasterController@user_doEdit')->name('master.user_doEdit');
    Route::post('/master/users_get', 'MasterController@users_get')->name('master.users_get');
    Route::match(array('GET', 'POST'), '/master/user_delete/{id}', 'MasterController@user_delete')->name('master.user_delete');
    Route::post('/master/cek_username', 'MasterController@cek_username')->name('master.cek_username');


    //Account
    Route::get('/master/account', 'MasterController@account')->name('master.account');
    Route::post('/master/account_doAdd', 'MasterController@account_doAdd')->name('master.account_doAdd');
    Route::post('/master/account_doEdit', 'MasterController@account_doEdit')->name('master.account_doEdit');
    Route::post('/master/account_get', 'MasterController@account_get')->name('master.account_get');
    Route::get('/master/account_delete/{id}', 'MasterController@account_delete')->name('master.account_delete');

    //Account Type
    Route::get('/master/acc_type', 'MasterController@acc_type')->name('master.acc_type');
    Route::post('/master/acc_type_doAdd', 'MasterController@acc_type_doAdd')->name('master.acc_type_doAdd');
    Route::post('/master/acc_type_doEdit', 'MasterController@acc_type_doEdit')->name('master.acc_type_doEdit');
    Route::post('/master/acc_type_get', 'MasterController@acc_type_get')->name('master.acc_type_get');
    Route::get('/master/acc_type_delete/{id}', 'MasterController@acc_type_delete')->name('master.acc_type_delete');


    //Schedule Type
    Route::get('/master/schedule', 'MasterController@schedule')->name('master.schedule');
    Route::post('/master/schedule_doAdd', 'MasterController@schedule_doAdd')->name('master.schedule_doAdd');
    Route::post('/master/schedule_doEdit', 'MasterController@schedule_doEdit')->name('master.schedule_doEdit');
    Route::post('/master/schedule_get', 'MasterController@schedule_get')->name('master.schedule_get');
    Route::get('/master/schedule_delete/{id}', 'MasterController@schedule_delete')->name('master.schedule_delete');


    //Loaded Type
    Route::get('/master/loaded', 'MasterController@loaded')->name('master.loaded');
    Route::post('/master/loaded_doAdd', 'MasterController@loaded_doAdd')->name('master.loaded_doAdd');
    Route::post('/master/loaded_doEdit', 'MasterController@loaded_doEdit')->name('master.loaded_doEdit');
    Route::post('/master/loaded_get', 'MasterController@loaded_get')->name('master.loaded_get');
    Route::get('/master/loaded_delete/{id}', 'MasterController@loaded_delete')->name('master.loaded_delete');

    //Freight
    Route::get('/master/freight', 'MasterController@freight')->name('master.freight');
    Route::post('/master/freight_doAdd', 'MasterController@freight_doAdd')->name('master.freight_doAdd');
    Route::post('/master/freight_doEdit', 'MasterController@freight_doEdit')->name('master.freight_doEdit');
    Route::post('/master/freight_get', 'MasterController@freight_get')->name('master.freight_get');
    Route::get('/master/freight_delete/{id}', 'MasterController@freight_delete')->name('master.freight_delete');

    //incoterms
    Route::get('/master/incoterms', 'MasterController@incoterms')->name('master.incoterms');
    Route::post('/master/incoterms_doAdd', 'MasterController@incoterms_doAdd')->name('master.incoterms_doAdd');
    Route::post('/master/incoterms_doEdit', 'MasterController@incoterms_doEdit')->name('master.incoterms_doEdit');
    Route::post('/master/incoterms_get', 'MasterController@incoterms_get')->name('master.incoterms_get');
    Route::get('/master/incoterms_delete/{id}', 'MasterController@incoterms_delete')->name('master.incoterms_delete');


    //container
    Route::get('/master/container', 'MasterController@container')->name('master.container');
    Route::post('/master/container_doAdd', 'MasterController@container_doAdd')->name('master.container_doAdd');
    Route::post('/master/container_doEdit', 'MasterController@container_doEdit')->name('master.container_doEdit');
    Route::post('/master/container_get', 'MasterController@container_get')->name('master.container_get');
    Route::get('/master/container_delete/{id}', 'MasterController@container_delete')->name('master.container_delete');

    //service
    Route::get('/master/service', 'MasterController@service')->name('master.service');
    Route::post('/master/service_doAdd', 'MasterController@service_doAdd')->name('master.service_doAdd');
    Route::post('/master/service_doEdit', 'MasterController@service_doEdit')->name('master.service_doEdit');
    Route::post('/master/service_get', 'MasterController@service_get')->name('master.service_get');
    Route::get('/master/service_delete/{id}', 'MasterController@service_delete')->name('master.service_delete');


    //Charge Group
    Route::get('/master/charge_group', 'MasterController@charge_group')->name('master.charge_group');
    Route::post('/master/charge_group_doAdd', 'MasterController@charge_group_doAdd')->name('master.charge_group_doAdd');
    Route::post('/master/charge_group_doEdit', 'MasterController@charge_group_doEdit')->name('master.charge_group_doEdit');
    Route::post('/master/charge_group_get', 'MasterController@charge_group_get')->name('master.charge_group_get');
    Route::get('/master/charge_group_delete/{id}', 'MasterController@charge_group_delete')->name('master.charge_group_delete');
    Route::post('/master/cek_charge_group_name', 'MasterController@cek_charge_group_name')->name('master.cek_charge_group_name');


    //UOM
    Route::get('/master/uom', 'MasterController@uom')->name('master.uom');
    Route::post('/master/uom_doAdd', 'MasterController@uom_doAdd')->name('master.uom_doAdd');
    Route::post('/master/uom_doEdit', 'MasterController@uom_doEdit')->name('master.uom_doEdit');
    Route::post('/master/uom_get', 'MasterController@uom_get')->name('master.uom_get');
    Route::get('/master/uom_delete/{id}', 'MasterController@uom_delete')->name('master.uom_delete');
    Route::post('/master/cek_uom_code', 'MasterController@cek_uom_code')->name('master.cek_uom_code');

    //vehicle
    Route::get('/master/vehicleType', 'MasterController@vehicleType')->name('master.vehicleType');
    Route::post('/master/vehicleType_doAdd', 'MasterController@vehicleType_doAdd')->name('master.vehicleType_doAdd');
    Route::post('/master/vehicleType_doEdit', 'MasterController@vehicleType_doEdit')->name('master.vehicleType_doEdit');
    Route::post('/master/vehicleType_get', 'MasterController@vehicleType_get')->name('master.vehicleType_get');
    Route::get('/master/vehicleType_delete/{id}', 'MasterController@vehicleType_delete')->name('master.vehicleType_delete');

    /** Tax */
    Route::get('/master/tax', 'TaxController@index')->name('master.tax.index');
    Route::post('/master/tax', 'TaxController@save')->name('master.tax.save');

    /** Quotation */
    Route::get('quotation/list', 'QuotationController@index')->name('quotation.list');
    Route::get('/quotation/quote_add', 'QuotationController@quote_add')->name('quotation.quote_add');
    Route::post('/quotation/quote_doAdd', 'QuotationController@quote_doAdd')->name('quotation.quote_doAdd');
    Route::match(array('GET', 'POST'), '/quotation/quote_edit/{id}', 'QuotationController@quote_edit')->name('quotation.quote_edit');
    Route::post('/quotation/quote_doUpdate', 'QuotationController@quote_doUpdate')->name('quotation.quote_doUpdate');
    Route::get('quotation/quote_new/{id}', 'QuotationController@quote_new')->name('quotation.quote_new');
    Route::match(array('GET', 'POST'), 'quotation/preview/{no}/{id}', 'QuotationController@quote_preview');
    Route::get('booking/copy_booking/{id}', 'BookingController@copy_booking');
    Route::post('get/pic', 'QuotationController@get_pic')->name('get.pic');
    Route::post('get/pic_b', 'QuotationController@get_pic_b')->name('get.pic_b');
    Route::post('get/port', 'QuotationController@get_port')->name('get.port');
    Route::get('get/port_b', 'QuotationController@get_port_b')->name('get.port_b');
    Route::get('/quotation/get_where_port','quotationController@get_where_port')->name('quotation.get_where_port');
    Route::post('/quotation/quote_getCurrencyCode', 'QuotationController@quote_getCurrencyCode')->name('quotation.quote_getCurrencyCode');
    Route::match(array('GET', 'POST'), '/quotation/customer', 'QuotationController@get_customer')->name('get.customer');
    Route::match(array('GET', 'POST'), '/quotation/shipper', 'QuotationController@get_shipper')->name('get.shipper');
    Route::match(array('GET', 'POST'), '/quotation/consignee', 'QuotationController@get_consignee')->name('get.consignee');
    Route::match(array('GET', 'POST'), '/quotation/notify_party', 'QuotationController@get_notify_party')->name('get.notify_party');
    Route::match(array('GET', 'POST'), '/quotation/agent', 'QuotationController@get_agent')->name('get.agent');
    Route::match(array('GET', 'POST'), '/quotation/shipping_line', 'QuotationController@get_shipping_line')->name('get.shipping_line');
    Route::match(array('GET', 'POST'), '/quotation/vendor', 'QuotationController@get_vendor')->name('get.vendor');
    Route::match(array('GET', 'POST'), '/quotation/get_list_carrier', 'QuotationController@get_carrier')->name('get.carrier');

    #Load Detail Dimension
    Route::post('/quotation/quote_addDimension', 'QuotationController@quote_addDimension')->name('quotation.quote_addDimension');
    Route::post('/quotation/quote_loadDimension','QuotationController@quote_loadDimension')->name('quotation.quote_loadDimension');
    Route::post('/quotation/quote_deleteDimension','QuotationController@quote_deleteDimension')->name('quotation.quote_deleteDimension');
    // Route::post('/quotation/uom_getAll', 'QuotationController@uom_getAll')->name('quotation.quote_getAll');
    Route::post('/quotation/quote_updateDimension', 'QuotationController@quote_updateDimension')->name('quotation.quote_updateDimension');

    #Load Detail Shipping
    Route::post('/quotation/quote_addShipping', 'QuotationController@quote_addShipping')->name('quotation.quote_addShipping');
    Route::post('/quotation/quote_loadShipping','QuotationController@quote_loadShipping')->name('quotation.quote_loadShipping');
    Route::post('/quotation/quote_deleteShipping','QuotationController@quote_deleteShipping')->name('quotation.quote_deleteShipping');
    Route::post('/quotation/uom_getAll', 'QuotationController@uom_getAll')->name('quotation.quote_getAll');
    Route::post('/quotation/quote_getDetailShipping', 'QuotationController@quote_getDetailShipping')->name('quotation.quote_getDetailShipping');
    Route::post('/quotation/quote_updateShipping', 'QuotationController@quote_updateShipping')->name('quotation.quote_updateShipping');

    #Load Detail Quote
    Route::post('/quotation/quote_addDetail', 'QuotationController@quote_addDetail')->name('quotation.quote_addDetail');
    Route::post('/quotation/quote_loadDetail','QuotationController@quote_loadDetail')->name('quotation.quote_loadDetail');
    Route::post('/quotation/quote_deleteDetail','QuotationController@quote_deleteDetail')->name('quotation.quote_deleteDetail');
    Route::post('/quotation/quote_deleteAll','QuotationController@quote_deleteAll')->name('quotation.quote_deleteAll');
    Route::post('/quotation/quote_getDetailQ', 'QuotationController@quote_getDetailQ')->name('quotation.quote_getDetailQ');
    Route::post('/quotation/quote_updateDetail', 'QuotationController@quote_updateDetail')->name('quotation.quote_updateDetail');

    #Profit
    Route::post('/quotation/quote_addProfit', 'QuotationController@quote_addProfit')->name('quotation.quote_addProfit');
    Route::post('/quotation/quote_loadProfit','QuotationController@quote_loadProfit')->name('quotation.quote_loadProfit');

    #Approved Quote
    Route::post('/quotation/quoteApproved', 'QuotationController@quote_approved')->name('quotation.quoteApprove');

    #View Quote
    Route::post('/quotation/viewVersion', 'QuotationController@get_version')->name('quotation.viewVersion');
    Route::post('/quotation/cekVersion', 'QuotationController@cek_version')->name('quotation.cekVersion');
    Route::match(array('GET', 'POST'), '/quotation/quote_getView', 'QuotationController@quote_getView')->name('quotation.getView');

    /** Booking */
    Route::get('booking/list', 'BookingController@index')->name('booking.list');
    Route::get('booking/nomination', 'BookingController@nomination')->name('booking.nomination');
    Route::get('booking/nomination_doAdd', 'BookingController@addNomination')->name('booking.nomination_doAdd');
    Route::match(array('GET', 'POST'), 'booking/edit_booking/{id}', 'BookingController@edit_booking')->name('booking.edit');
    Route::match(['get', 'post'], 'booking/header_booking/{id}', 'BookingController@header_booking')->name('booking.header');
    Route::post('booking/detail', 'BookingController@booking_detail')->name('booking.detail');
    Route::post('booking/loadCarrier', 'BookingController@booking_loadCarrier')->name('booking.loadCarrier');
    Route::post('/booking/doAdd', 'BookingController@booking_doAdd')->name('booking.doAdd');
    Route::post('/booking/doAddVersion', 'BookingController@booking_doAddVersion')->name('booking.doAddVersion');
    Route::match(['get', 'post'], 'booking/booking_new/{id}', 'BookingController@new_version')->name('booking.new_version');
    Route::post('/booking/booking_doUpdate', 'BookingController@doUpdate')->name('booking.doUpdate');
    Route::post('/booking/booking_doUpdate_road', 'BookingController@doUpdate_road')->name('booking.doUpdate_road');
    Route::post('/booking/roadCons_doAdd', 'BookingController@roadCons_doAdd')->name('booking.roadCons_doAdd');
    Route::post('/booking/roadCons_doUpdate', 'BookingController@roadCons_doUpdate')->name('booking.roadCons_doUpdate');
    Route::post('/booking/loadRoadCons','BookingController@loadRoadCons')->name('booking.loadRoadCons');
    Route::post('booking/getRoadCons', 'BookingController@getRoadCons')->name('booking.getRoadCons');
    Route::post('/booking/deleteRoadCons','BookingController@deleteRoadCons')->name('booking.deleteRoadCons');
    Route::post('/booking/schedule_doAdd', 'BookingController@schedule_doAdd')->name('booking.schedule_doAdd');
    Route::post('/booking/loadSchedule','BookingController@loadSchedule')->name('booking.loadSchedule');
    Route::post('booking/getSchedule', 'BookingController@getSchedule')->name('booking.getSchedule');
    Route::post('/booking/deleteSchedule','BookingController@deleteSchedule')->name('booking.deleteSchedule');
    Route::post('/booking/deleteCF','BookingController@deleteCF')->name('booking.deleteCF');
    Route::post('/booking/booking_getDetailCharges','BookingController@booking_getDetailCharges')->name('booking.booking_getDetailCharges');
    Route::post('/booking/schedule_doUpdate', 'BookingController@schedule_doUpdate')->name('booking.schedule_doUpdate');
    Route::post('/booking/loadSellCost', 'BookingController@loadSellCost')->name('booking.loadSellCost');
    Route::post('/booking/updateSell', 'BookingController@updateSell')->name('booking.updateSell');
    Route::post('/booking/updateSellshp', 'BookingController@updateSellshp')->name('booking.updateSellshp');
    Route::match(array('GET', 'POST'), 'booking/preview/{id}', 'BookingController@booking_preview');
    Route::match(array('GET', 'POST'), '/booking/cetak_hbl/{id}/{hbl1}/{hbl2}/{op2}/{op3}', 'BookingController@cetak_hbl');
    Route::get('booking/cetak_awb/{id}', 'BookingController@cetak_hawb');
    Route::get('booking/cetak_vgm/{id}', 'BookingController@cetak_vgm');
    Route::get('booking/cetak_si_lcl/{id}/{op1}/{op2}/{op3}/{op4}', 'BookingController@cetak_si_lcl');
    Route::get('booking/cetak_si_fcl/{id}/{op1}/{op2}/{op3}/{op4}', 'BookingController@cetak_si_fcl');
    Route::get('booking/cetak_si_air/{id}/{op1}/{op2}/{op3}/{op4}', 'BookingController@cetak_si_air');
    Route::get('booking/cetak_si_trucking_fcl/{id}/{op1}', 'BookingController@cetak_si_trucking_fcl');
    Route::get('booking/cetak_si_trucking_lcl/{id}/{op1}', 'BookingController@cetak_si_trucking_lcl');
    Route::get('booking/cetak_suratjalan/{id}', 'BookingController@cetak_suratJalan');
    Route::post('/booking/update_request', 'BookingController@update_request')->name('booking.update_request');
    Route::post('/booking/approve_request', 'BookingController@approve_request')->name('booking.approve_request');

    Route::post('/booking/bcharges_addDetail', 'BookingController@bcharges_addDetail')->name('booking.bcharges_addDetail');
    Route::post('/booking/bcharges_updateDetail', 'BookingController@bcharges_updateDetail')->name('booking.bcharges_updateDetail');
    Route::post('booking/cancel', 'BookingController@booking_cancel')->name('booking.cancel');
    Route::post('booking/cancel_inv', 'BookingController@booking_cancel_inv')->name('booking.cancel_inv');
    Route::post('/booking/getPort/','BookingController@getPort')->name('booking.getPort');
    Route::post('/booking/getExistingPort/','BookingController@getExistingPort')->name('booking.getExistingPort');

    #Load Detail Commodity
    Route::post('/booking/addCommodity', 'BookingController@addCommodity')->name('booking.addCommodity');
    Route::post('/booking/loadCommodity','BookingController@loadCommodity')->name('booking.loadCommodity');
    Route::post('/booking/deleteCommodity','BookingController@deleteCommodity')->name('booking.deleteCommodity');
    Route::post('/booking/updateCommodity', 'BookingController@updateCommodity')->name('booking.updateCommodity');

    #Load Detail Packages
    Route::post('/booking/addPackages', 'BookingController@addPackages')->name('booking.addPackages');
    Route::post('/booking/getPackages','BookingController@getPackages')->name('booking.getPackages');
    Route::post('/booking/loadPackages','BookingController@loadPackages')->name('booking.loadPackages');
    Route::post('/booking/deletePackages','BookingController@deletePackages')->name('booking.deletePackages');
    Route::post('/booking/updatePackages', 'BookingController@updatePackages')->name('booking.updatePackages');

    #Load Detail Container
    Route::post('/booking/addContainer', 'BookingController@addContainer')->name('booking.addContainer');
    Route::post('/booking/loadContainer','BookingController@loadContainer')->name('booking.loadContainer');
    Route::post('/booking/deleteContainer','BookingController@deleteContainer')->name('booking.deleteContainer');
    Route::post('/booking/updateContainer', 'BookingController@updateContainer')->name('booking.updateContainer');
    Route::post('/booking/getAll', 'BookingController@getAll')->name('booking.getAll');

    #Load Detail Doc
    Route::post('/booking/addDoc', 'BookingController@addDoc')->name('booking.addDoc');
    Route::post('/booking/loadDoc','BookingController@loadDoc')->name('booking.loadDoc');
    Route::post('/booking/deleteDoc','BookingController@deleteDoc')->name('booking.deleteDoc');
    Route::post('/booking/updateDoc', 'BookingController@updateDoc')->name('booking.updateDoc');
    Route::post('/booking/getDoc', 'BookingController@getDoc')->name('booking.getDoc');

    #View Booking
    Route::post('/booking/viewVersion', 'BookingController@get_version')->name('booking.viewVersion');
    Route::post('/booking/cekVersion', 'BookingController@cek_version')->name('booking.cekVersion');
    Route::match(array('GET', 'POST'), '/booking/getView', 'BookingController@getView')->name('booking.getView');

    #Approved Booking
    Route::post('/booking/approved', 'BookingController@approved')->name('booking.Approve');


    /** Proforma Invoice */
    // Route::get('/invoice/proformainvoice', 'ProformaInvoiceController@index')->name('proformainvoice.index');
    // Route::get('/invoice/proformainvoice/create', 'ProformaInvoiceController@create')->name('proformainvoice.create');
    // Route::get('/invoice/proformainvoice/edit/{id}', 'ProformaInvoiceController@edit')->name('proformainvoice.edit');
    // Route::get('/invoice/proformainvoice/view/{id}', 'ProformaInvoiceController@view')->name('proformainvoice.view');
    // Route::post('/invoice/proformainvoice/save', 'ProformaInvoiceController@save')->name('proformainvoice.save');
    // Route::post('/invoice/proformainvoice/update', 'ProformaInvoiceController@update')->name('proformainvoice.update');
    // Route::get('/invoice/proformainvoice/create_cost', 'ProformaInvoiceController@create_cost')->name('proformainvoice.create_cost');
    // Route::post('/invoice/proformainvoice/loadSellCost', 'ProformaInvoiceController@loadSellCost')->name('proformainvoice.loadSellCost');

    Route::get('/invoice/proformainvoice', 'ProformaInvoiceController@index')->name('proforma_invoice.index');
    Route::get('/invoice/proformainvoice/view/{id}', 'ProformaInvoiceController@view')->name('proforma_invoice.view');
    Route::get('/invoice/proformainvoice/delete/{proformaInvoiceId}', 'ProformaInvoiceController@delete')->name('proforma_invoice.delete');
    Route::get('/invoice/proformainvoice/create/{invoiceId}', 'ProformaInvoiceController@create')->name('proforma_invoice.create');
    Route::get('/invoice/proformainvoice/edit/{proformaInvoiceId}', 'ProformaInvoiceController@edit')->name('proforma_invoice.edit');
    Route::get('/invoice/proformainvoice/sync', 'ProformaInvoiceController@syncProformaInvoiceDetail')->name('proforma_invoice.syncProformaInvoiceDetail');
    Route::post('/invoice/proformainvoice/create/', 'ProformaInvoiceController@save')->name('proforma_invoice.save');
    Route::post('/invoice/proformainvoice/create/deleteSession', 'ProformaInvoiceController@deleteSession')->name('proforma_invoice.deleteSession');
    Route::post('/invoice/proformainvoice/create/loadDetail', 'ProformaInvoiceController@loadDetail')->name('proforma_invoice.loadDetail');
    Route::post('/invoice/proformainvoice/create/loadDetailBefore', 'ProformaInvoiceController@loadDetailBefore')->name('proforma_invoice.loadDetailBefore');
    Route::post('/invoice/proformainvoice/create/loadDetailAfter', 'ProformaInvoiceController@loadDetailAfter')->name('proforma_invoice.loadDetailAfter');
    Route::post('/invoice/proformainvoice/create/saveDetailMerge', 'ProformaInvoiceController@saveMergeDetail')->name('proforma_invoice.saveMergeDetail');

    /** Invoice */
    Route::get('/invoice', 'InvoiceController@index')->name('invoice.index');
    Route::get('/invoice/create', 'InvoiceController@create')->name('invoice.create');
    Route::get('/invoice/create_cost', 'InvoiceController@create_cost')->name('invoice.create_cost');
    Route::post('/invoice/save', 'InvoiceController@save')->name('invoice.save');
    Route::post('/invoice/save_cost', 'InvoiceController@save_cost')->name('invoice.save_cost');
    Route::get('/invoice/internal/index/{tipe?}', 'InvoiceController@index')->name('invoice.index');
    Route::get('/invoice/internal/find/{id}', 'InvoiceController@getInvoice')->name('invoice.getInvoice');
    Route::get('/invoice/internal/edit/{id}', 'InvoiceController@edit')->name('invoice.edit');
    Route::get('/invoice/internal/view/{id}', 'InvoiceController@view')->name('invoice.view');
    Route::get('/invoice/internal/delete/{id}', 'InvoiceController@delete')->name('invoice.delete');
    Route::post('/invoice/internal/update_cost', 'InvoiceController@update_cost')->name('invoice.update_cost');
    Route::get('/invoice/internal/sync', 'InvoiceController@syncInvoiceDetail')->name('invoice.syncInvoiceDetail');
    Route::get('/invoice/internal/create', 'InvoiceController@create')->name('invoice.create');
    Route::post('/invoice/internal/save', 'InvoiceController@save')->name('invoice.save');
    Route::get('/invoice/internal/view_selisih/{id}', 'InvoiceController@view_selisih')->name('invoice.view_selisih');

    Route::get('/invoice/internal/delete_detail/{id}', 'InvoiceController@delete_detail')->name('invoice.delete_detail');
    // Route::post('/invoice/internal/delete', 'InvoiceController@delete')->name('invoice.delete');
    Route::post('/invoice/internal/loadSellCost', 'InvoiceController@loadSellCost')->name('invoice.loadSellCost');
    Route::post('/invoice/internal/getListInvoiceByCompanyId', 'InvoiceController@getListInvoiceByCompanyId')->name('invoice.getListInvoiceByCompanyId');
    Route::post('/invoice/internal/openINV', 'InvoiceController@openINV')->name('invoice.openINV');
    Route::get('/invoice/internal/print/{id}', 'InvoiceController@print')->name('invoice.print');
    Route::post('/invoice/internal/loadDetailInvoice', 'InvoiceController@loadDetailInvoice')->name('invoice.loadDetailInvoice');

    /** External **/
    Route::get('/invoice/external/create/{proformaInvoiceId}', 'ExternalInvoiceController@create')->name('external_invoice.create');
    Route::get('/invoice/external', 'ExternalInvoiceController@index')->name('external_invoice.index');
    Route::get('/invoice/external/find/{id}', 'ExternalInvoiceController@getExternalInvoice')->name('external_invoice.getExternalInvoice');
    Route::get('/invoice/external/view/{id}', 'ExternalInvoiceController@view')->name('external_invoice.view');
    Route::get('/invoice/external/edit/{id}', 'ExternalInvoiceController@edit')->name('external_invoice.edit');
    Route::get('/invoice/external/delete/{id}', 'ExternalInvoiceController@delete')->name('external_invoice.delete');
    Route::get('/invoice/external/sync', 'ExternalInvoiceController@syncExternalInvoiceDetail')->name('external_invoice.syncExternalInvoiceDetail');
    Route::get('/invoice/external/create/{proformaInvoiceId}', 'ExternalInvoiceController@create')->name('external_invoice.create');
    Route::post('/invoice/external/create/', 'ExternalInvoiceController@save')->name('external_invoice.save');
    Route::post('/invoice/external/create/loadDetail', 'ExternalInvoiceController@loadDetail')->name('external_invoice.loadDetail');
    Route::post('/invoice/external/create/loadDetailBefore', 'ExternalInvoiceController@loadDetailBefore')->name('external_invoice.loadDetailBefore');
    Route::post('/invoice/external/create/loadDetailAfter', 'ExternalInvoiceController@loadDetailAfter')->name('external_invoice.loadDetailAfter');
    Route::post('/invoice/external/create/saveDetailMerge', 'ExternalInvoiceController@saveMergeDetail')->name('external_invoice.saveMergeDetail');
    Route::post('/invoice/external/getListExternalInvoiceByCompanyId', 'ExternalInvoiceController@getListExternalInvoiceByCompanyId')->name('external_invoice.getListExternalInvoiceByCompanyId');

    Route::post('/invoice/getInvoiceHeader', 'InvoiceController@getInvoiceHeader')->name('invoice.getInvoiceHeader');

    /** Pembayaran **/
    Route::get('/pembayaran/cancel/{id}', 'PembayaranController@cancelPembayaran')->name('pembayaran.cancel');

    //HUTANG
    Route::get('/pembayaran/index', 'PembayaranController@index')->name('pembayaran.index');
    Route::get('/pembayaran/view/{id}', 'PembayaranController@view')->name('pembayaran.view');
    Route::get('/pembayaran/add', 'PembayaranController@add')->name('pembayaran.add');
    Route::post('/pembayaran/save', 'PembayaranController@save')->name('pembayaran.save');
    Route::get('/pembayaran/edit/{id}', 'PembayaranController@edit')->name('pembayaran.edit');
    Route::get('/pembayaran/delete/{id}', 'PembayaranController@delete')->name('pembayaran.delete');
    Route::post('/pembayaran/list_hutang', 'PembayaranController@list_hutang')->name('pembayaran.list_hutang');
    Route::post('/pembayaran/getDataInv', 'PembayaranController@getDataInv')->name('pembayaran.getDataInv');
    Route::post('/pembayaran/saveDetailPembayaran', 'PembayaranController@saveDetailPembayaran')->name('pembayaran.saveDetailPembayaran');
    Route::post('/pembayaran/list_detail', 'PembayaranController@list_detail')->name('pembayaran.list_detail');
    Route::post('/pembayaran/deleteDetailPembayaran', 'PembayaranController@deleteDetailPembayaran')->name('pembayaran.deleteDetailPembayaran');
    Route::post('/pembayaran/update', 'PembayaranController@update')->name('pembayaran.update');
    Route::post('/pembayaran/openPMB', 'PembayaranController@openPMB')->name('pembayaran.openPMB');

    /** list hutang */
    Route::get('/hutang', 'HutangController@index')->name('hutang.index');

    //PIUTANG
    Route::get('/pembayaran/piutang', 'PembayaranController@piutang')->name('pembayaran.piutang');
    Route::get('/pembayaran/add_piutang', 'PembayaranController@add_piutang')->name('pembayaran.add_piutang');
    Route::post('/pembayaran/list_piutang', 'PembayaranController@list_piutang')->name('pembayaran.list_piutang');
    Route::post('/pembayaran/getDataInvExt', 'PembayaranController@getDataInvExt')->name('pembayaran.getDataInvExt');
    Route::post('/pembayaran/saveDetailPembayaranPiutang', 'PembayaranController@saveDetailPembayaranPiutang')->name('pembayaran.saveDetailPembayaranPiutang');
    Route::post('/pembayaran/deleteDetailPembayaranPiutang', 'PembayaranController@deleteDetailPembayaranPiutang')->name('pembayaran.deleteDetailPembayaranPiutang');


    /** list piutang */
    Route::get('/piutang', 'PiutangController@index')->name('piutang.index');

    /** Kas Masuk*/
    Route::get('/cash/in', 'KasMasukController@indexKasMasuk')->name('kas.masuk.index');
    Route::get('/cash/in/add', 'KasMasukController@addKasMasuk')->name('kas.masuk.add');
    Route::post('/cash/in/loadDetail', 'KasMasukController@loadDetailKasMasuk')->name('kas.masuk.loadDetail');
    Route::post('/cash/in/saveDetail', 'KasMasukController@saveDetailKasMasuk')->name('kas.masuk.saveDetail');
    Route::post('/cash/in/deleteDetail', 'KasMasukController@deleteDetailKasMasuk')->name('kas.masuk.deleteDetail');
    Route::post('/cash/in', 'KasMasukController@saveKasMasuk')->name('kas.masuk.save');
    Route::get('/cash/in/view/{id}', 'KasMasukController@viewKasMasuk')->name('kas.masuk.view');

    /** Kas Keluar */
    Route::get('/cash/out', 'KasKeluarController@indexKasKeluar')->name('kas.keluar.index');
    Route::get('/cash/out/add', 'KasKeluarController@addKasKeluar')->name('kas.keluar.add');
    Route::post('/cash/out/loadDetail', 'KasKeluarController@loadDetailKasKeluar')->name('kas.keluar.loadDetail');
    Route::post('/cash/out/saveDetail', 'KasKeluarController@saveDetailKasKeluar')->name('kas.keluar.saveDetail');
    Route::post('/cash/out/deleteDetail', 'KasKeluarController@deleteDetailKasKeluar')->name('kas.keluar.deleteDetail');
    Route::post('/cash/out', 'KasKeluarController@saveKasKeluar')->name('kas.keluar.save');
    Route::get('/cash/out/view/{id}', 'KasKeluarController@viewKasKeluar')->name('kas.keluar.view');

    /** Kas Transfer */
    Route::get('/cash/transfer', 'KasTransferController@indexKasTransfer')->name('kas.transfer.index');
    Route::get('/cash/transfer/add', 'KasTransferController@addKasTransfer')->name('kas.transfer.add');
    Route::post('/cash/transfer/save', 'KasTransferController@saveKasTransfer')->name('kas.transfer.save');

    /** Journal */
    Route::get('/accounting/journal', 'JournalController@indexJournal')->name('journal.index');
    Route::get('/accounting/journal/add', 'JournalController@addJournal')->name('journal.add');
    Route::post('/accounting/journal/save', 'JournalController@saveJournal')->name('journal.save');
    Route::post('/accounting/journal/post', 'JournalController@postJournal')->name('journal.post');
    Route::get('/accounting/journal/edit/{id}', 'JournalController@editJournal')->name('journal.edit');
    Route::get('/accounting/journal/view/{id}', 'JournalController@viewJournal')->name('journal.view');
    Route::get('/accounting/journal/delete/{id}', 'JournalController@deleteJournal')->name('journal.delete');
    Route::post('/accounting/journal/loadDetail', 'JournalController@loadDetailJournal')->name('journal.loadDetail');
    Route::post('/accounting/journal/saveDetail', 'JournalController@saveDetailJournal')->name('journal.saveDetail');
    Route::post('/accounting/journal/updateDetail', 'JournalController@updateDetailJournal')->name('journal.updateDetail');
    Route::post('/accounting/journal/deleteDetail', 'JournalController@deleteDetailJournal')->name('journal.deleteDetail');
    Route::post('/accounting/journal/clearSession', 'JournalController@clearSessionJournal')->name('journal.clearSession');
    Route::post('/accounting/journal/updatepph23', 'JournalController@updatepph23Journal')->name('journal.updatepph23');

    /** Journal Deposit */
    Route::get('/accounting/journal_deposit/add', 'JournalDepositController@addJournal')->name('journal_deposit.add');
    Route::get('/accounting/journal_deposit/edit/{id}', 'JournalDepositController@editJournal')->name('journal_deposit.edit');
    Route::post('/accounting/journal_deposit/save', 'JournalDepositController@saveJournal')->name('journal_deposit.save');
    Route::post('/accounting/journal_deposit/loadDetail', 'JournalDepositController@loadDetailJournal')->name('journal_deposit.loadDetail');
    Route::post('/accounting/journal_deposit/saveDetail', 'JournalDepositController@saveDetailJournal')->name('journal_deposit.saveDetail');
    Route::post('/accounting/journal_deposit/updateDetail', 'JournalDepositController@updateDetailJournal')->name('journal_deposit.updateDetail');
    Route::post('/accounting/journal_deposit/deleteDetail', 'JournalDepositController@deleteDetailJournal')->name('journal_deposit.deleteDetail');
    Route::post('/accounting/journal_deposit/clearSession', 'JournalDepositController@clearSessionJournal')->name('journal_deposit.clearSession');

    /** General Ledgers */
    Route::get('/accounting/general_ledger', 'GeneralLedgerController@index')->name('general_ledger.index');
    Route::post('/accounting/general_ledger/loadDetail', 'GeneralLedgerController@loadDetail')->name('general_ledger.loadDetail');

    /** Deposit */
    Route::get('/deposit', 'DepositController@index')->name('deposit.index');
    Route::get('/deposit/add', 'DepositController@add')->name('deposit.add');
    Route::post('/deposit/loadDetail', 'DepositController@loadDetail')->name('deposit.loadDetail');
    Route::post('/deposit/saveDetail', 'DepositController@saveDetail')->name('deposit.saveDetail');
    Route::post('/deposit/deleteDetail', 'DepositController@deleteDetail')->name('deposit.deleteDetail');
    Route::post('/deposit', 'DepositController@save')->name('deposit.save');
    Route::post('/deposit/processSave', 'DepositController@processSave')->name('deposit.processSave');
    Route::post('/deposit/processSavePembayaranDeposit', 'DepositController@processSavePembayaranDeposit')->name('deposit.processSavePembayaranDeposit');
    Route::get('/deposit/view/{id}', 'DepositController@view')->name('deposit.view');
    Route::post('/deposit/getDepositCompany', 'DepositController@getDepositCompany')->name('deposit.getDepositCompany');
    Route::post('/deposit/getListDeposit', 'DepositController@getListDeposit')->name('deposit.getListDeposit');

    /** Role Access **/
    Route::get('/user/access', 'ManagementController@user_access')->name('user.access');
    Route::post('/user/access_doAdd', 'ManagementController@user_accessdoAdd')->name('user.access_doAdd');
    Route::post('/user/access_doEdit', 'ManagementController@user_accessdoEdit')->name('user.access_doEdit');
    Route::post('/user/access_get', 'ManagementController@user_access_get')->name('user.access_get');
    Route::get('/master/access_delete/{id}', 'ManagementController@user_accessDelete')->name('user.access_delete');
    Route::get('/user/roles', 'ManagementController@user_roles')->name('user.roles');
    Route::post('/user/roles_doAdd', 'ManagementController@user_rolesdoAdd')->name('user.roles_doAdd');
    Route::post('/user/roles_doEdit', 'ManagementController@user_rolesdoEdit')->name('user.roles_doEdit');
    Route::post('/user/roles_get', 'ManagementController@user_roles_get')->name('user.roles_get');
    Route::get('/master/roles_delete/{id}', 'ManagementController@user_rolesDelete')->name('user.roles_delete');

    /** Profile */
    Route::get('/user/{id}', 'UserController@index')->name('profile');
    Route::post('/user/user_doAdd', 'UserController@user_doAdd')->name('user.doAdd');
    Route::post('/user/change_password', 'UserController@doChangePassword')->name('user.change_password');

    Route::get('/report', 'ReportController@index')->name('report.index');
    Route::get('/report/print', 'ReportController@print')->name('report.print');
    Route::get('/report/print/income_statement', 'ReportController@print_income_statement')->name('report.print.income_statement');
    Route::get('/report/print/balance_sheet', 'ReportController@print_balance_sheet')->name('report.print.balance_sheet');
    Route::get('/report/print/general_ledger', 'ReportController@print_general_ledger')->name('report.print.general_ledger');
    Route::get('/report/print/trial_balance', 'ReportController@print_trial_balance')->name('report.print.trial_balance');
    Route::get('/report/print/cash', 'ReportController@print_cash')->name('report.print.cash');
    Route::get('/report/print/ar_ap', 'ReportController@print_ar_ap')->name('report.print.ar_ap');
    Route::get('/report/test', 'ReportController@test');
});


Route::get('/home', 'HomeController@index')->name('home');
