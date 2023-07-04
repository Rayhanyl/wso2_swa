<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthenticationController,
    HomepageController,
    DocumentationController,
    AboutusController,
    QuestionController,
    ConfigurationController,
    ApplicationController,
    SendMailController,
    SubscriptionController,
    TryoutController,
    ManageKeysController,
    CustomerController,
    AdminController,
    PaymentController,
};

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

Route::get('/', [HomepageController::class, 'homePage'])->name('home.page');
Route::get('/LoadImgApiHomePage', [HomepageController::class, 'loadimgapi'])->name('loadimgapihomepage');
Route::get('/LoginPage', [AuthenticationController::class, 'loginPage'])->name('login.page');
Route::post('/Authentication', [AuthenticationController::class, 'authentication'])->name('authentication');
Route::get('/RegisterPage', [AuthenticationController::class, 'registerPage'])->name('register.page');
Route::post('/Register', [AuthenticationController::class, 'register'])->name('register');
Route::get('/ForgotPasswordPage', [AuthenticationController::class, 'forgotPasswordPage'])->name('forgot.password.page');
Route::post('/SendEmail',[SendMailController::class, 'sendmail'])->name('sendmail');
Route::get('/NewPasswordPage', [AuthenticationController::class, 'newpassword'])->name('new.password');
Route::post('/ResetPassword',[AuthenticationController::class, 'resetpassword'])->name('resetpassword');
Route::get('/DocumentationPage', [DocumentationController::class, 'documentationPage'])->name('documentation.page');
Route::get('/AboutUsPage', [AboutusController::class, 'aboutusPage'])->name('about.us.page');
Route::get('/QuestionPage', [QuestionController::class, 'questionPage'])->name('question.answer.page');
Route::get('/SearchAPI', [DocumentationController::class, 'listApi'])->name('list.api');
Route::get('/ResultDocumentation', [DocumentationController::class, 'resultDocumentation'])->name('result.documentation');
Route::get('/LoadImgApiDocument', [DocumentationController::class, 'loadimgapi'])->name('loadimgapidocument');
Route::get('/Configuration', [ConfigurationController::class, 'configuration_page'])->name('configuration.page');
Route::get('/ConfigurationFAQS', [ConfigurationController::class, 'faqs_page'])->name('faqs.page');
Route::get('/ConfigurationFAQSCreate', [ConfigurationController::class, 'faqs_create'])->name('faqs.create.page');
Route::post('/ConfigurationFAQSPost', [ConfigurationController::class, 'faqs_store'])->name('faqs.store');


Route::middleware(['haslogin'])->group(function () { 
    Route::get('/ApplicationPage',[ApplicationController::class, 'application_page'])->name('application.page');
    Route::get('/CreateApplicationPage',[ApplicationController::class, 'create_application_page'])->name('create.application.page');
    Route::post('/StoreApplication', [ApplicationController::class, 'store_application'])->name('store.application');
    Route::get('/EditApplicationPage/{id}', [ApplicationController::class, 'edit_application'])->name('edit.application.page');
    Route::post('/UpdateApplication/{id}', [ApplicationController::class, 'update_application'])->name('update.application');
    Route::get('/DeleteApplication/{id}', [ApplicationController::class, 'delete_application'])->name('delete.application');
    Route::get('/SubscriptionPage/{id}', [SubscriptionController::class, 'subscription_page'])->name('subscription.page');
    Route::get('/GetApiByTypesubs', [SubscriptionController::class, 'get_apilist_by_typesubs'])->name('get.apilist.by.typesubs');
    // Route::get('/CreateSubscription/{id}', [SubscriptionController::class, 'create_subscription_page'])->name('create.subscription.page');
    Route::post('/StoreSubscription', [SubscriptionController::class, 'store_subscription'])->name('store.subscription');
    Route::get('/EditSubscription', [SubscriptionController::class, 'edit_subscription'])->name('edit.subscription');
    Route::get('/AddSubscription', [SubscriptionController::class, 'add_subscription'])->name('add.subscription');
    Route::post('/UpdateSubscription', [SubscriptionController::class, 'update_subscription'])->name('update.subscription');
    Route::get('/DeleteSubscription/{id}', [SubscriptionController::class, 'delete_subscription'])->name('delete.subscription');
    Route::get('/LoadImgApi', [SubscriptionController::class, 'loadimgapi'])->name('loadimgapi');
    Route::get('/TryOut/{id}/',[TryoutController::class, 'tryout_page'])->name('tryout.page');
    Route::get('/TryOutModalSandbox',[TryoutController::class, 'sandbox_form'])->name('sandbox.form');
    Route::get('/TryOutModalProduction',[TryoutController::class, 'production_form'])->name('production.form');
    Route::get('/Swaggerjson', [TryoutController::class, 'jsontryout'])->name('swaggerjson');
    Route::get('/DownloadjsonOpenapi', [TryoutController::class, 'downloadformatopenapi'])->name('downloadjsonopenapi');
    Route::get('/SandboxPage/{id}', [ManageKeysController::class, 'sandbox_page'])->name('sandbox.page');
    Route::get('/ProductionPage/{id}', [ManageKeysController::class, 'production_page'])->name('production.page');
    Route::post('/GenerateKeyOauth' ,[ManageKeysController::class, 'oauthgenerate'])->name('oauthgenerate');
    Route::post('/UpdateOauthKey' ,[ManageKeysController::class, 'updateoauth'])->name('updategenerate');
    Route::post('/Accesstoken' ,[ManageKeysController::class, 'generateaccesstoken'])->name('accesstoken');
    Route::post('/ApiKeys' ,[ManageKeysController::class, 'genapikey'])->name('genapikey');
    Route::get('/Logout', [AuthenticationController::class, 'logout'])->name('logout');  

    Route::get('/CustomerMonthlyReportSummary', [CustomerController::class, 'customer_monthly_report_summary_page'])->name('customer.monthly.report.summary.page');
    Route::get('/CustomerDownloadPDFReportSummary', [CustomerController::class, 'customer_monthly_report_summary_pdf'])->name('customer.monthly.report.summary.pdf');
    Route::get('/CustomerReportResultApi', [CustomerController::class, 'customer_result_api_summary_report'])->name('customer.result.api.summary.report');
    Route::get('/CustomerReportDetail/{app}/{api}/{year}/{month}', [CustomerController::class, 'customer_detail_logs_report'])->name('customer.detail.logs.report');
    Route::get('/CustomerDpwnloadPDFReportDetail', [CustomerController::class, 'customer_detail_logs_report_pdf'])->name('customer.detail.logs.report.pdf');
    Route::get('/CustomerApiResourceUsageSummary', [CustomerController::class, 'customer_api_resource_usage_summary_page'])->name('customer.api.resource.usage.summary.page');
    Route::get('/CustomerDownloadPDFApiResourceUsageSummary/{year}/{month}/{resources}/{api_id}', [CustomerController::class, 'customer_api_resource_usage_summary_pdf'])->name('customer.api.resource.usage.summary.pdf');
    Route::get('/CustomerUsageResultResource', [CustomerController::class, 'customer_result_resource_summary_usage'])->name('customer.result.resource.summary.usage');
    Route::get('/CustomerUsageResultMonth', [CustomerController::class, 'customer_result_month_summary_usage'])->name('customer.result.month.summary.usage');
    Route::get('/CustomerUsageDetail', [CustomerController::class, 'customer_detail_logs_usage'])->name('customer.detail.logs.usage');
    Route::get('/CustomerDownloadPDFUsageDetail', [CustomerController::class, 'customer_detail_logs_usage_pdf'])->name('customer.details.logs.pdf');
    Route::get('/CustomerDashboard', [CustomerController::class, 'customer_dashboard_page'])->name('customer.dashboard.page');
    Route::get('/CustomerDoughnutChartApiUsage', [CustomerController::class, 'customer_doughnut_chart_api_usage'])->name('customer.doughtnut_chart_api_usage');
    Route::get('/CustomerDoughnutChartResponseCount', [CustomerController::class, 'customer_doughnut_chart_response_count'])->name('customer.doughtnut.chart.response.count');
    Route::get('/CustomerDoughnutChartApplicationUsage', [CustomerController::class, 'customer_doughnut_chart_application_usage'])->name('customer.doughtnut.chart.application.usage');
    Route::get('/CustomerTableQuotaSubscription', [CustomerController::class, 'customer_table_quota_subscription'])->name('customer.table.quota.subscription');
    Route::get('/CustomerBarChartTopApiUsage', [CustomerController::class, 'customer_bar_chart_top_usage'])->name('customer.bar.chart.top.usage');
    Route::get('/CustomerBarChartTopFaultOvertime', [CustomerController::class, 'customer_bar_chart_fault_overtime'])->name('customer.bar.chart.fault.overtime');
    Route::get('/CustomerTableTopFaultOvertime', [CustomerController::class, 'customer_table_fault_overtime'])->name('customer.table.fault.overtime');
    Route::get('/CustomerPaymentPage', [CustomerController::class, 'customer_payment_page'])->name('customer.payment.page');
    Route::post('/CustomerCreatePayment', [CustomerController::class, 'customer_create_payment'])->name('customer.create.payment');
    Route::get('/CustomerPaymentHistoryPage', [CustomerController::class, 'customer_payment_history_page'])->name('customer.payment.history.page');
    Route::get('/CustomerInvoicePage', [CustomerController::class, 'customer_invoice_page'])->name('customer.invoice.page');
    Route::get('/CustomerHistoryWaiting', [CustomerController::class, 'customer_history_waiting'])->name('customer.history.waiting');
    Route::get('/CustomerHistoryAccepted', [CustomerController::class, 'customer_history_accepted'])->name('customer.history.accepted');
    Route::get('/CustomerHistoryRejected', [CustomerController::class, 'customer_history_rejected'])->name('customer.history.rejected');
    
    Route::get('/AdminMonthlyReportSummary', [AdminController::class, 'admin_monthly_report_summary_page'])->name('admin.monthly.report.summary.page');
    Route::get('/AdminReportDetail/{app}/{api}/{month}/{year}', [AdminController::class, 'admin_detail_logs_report'])->name('admin.detail.logs.report');
    Route::get('/AdminDownloadPDFReportSummary/{year}/{month}/{customer}/{api_name}', [AdminController::class, 'admin_monthly_report_summary_pdf'])->name('admin.monthly.report.summary.pdf');
    Route::get('/AdminDownloadPDFReportDetail/{app_id}/{api_id}/{month}/{year}', [AdminController::class, 'admin_detail_logs_report_pdf'])->name('admin.detail.logs.report.pdf');
    Route::get('/AdminApiResourceUsageSummary', [AdminController::class, 'admin_api_resource_usage_summary_page'])->name('admin.api.resource.usage.summary.page');
    Route::get('/AdminUsageDetail', [AdminController::class, 'admin_detail_logs_usage'])->name('admin.detail.logs.usage');
    Route::get('/AdminDownloadPDFApiResourceUsageSummary/{year}/{month}/{resources}/{api_id}', [AdminController::class, 'admin_api_resource_usage_summary_pdf'])->name('admin.api.resource.usage.summary.pdf');
    Route::get('/AdminDownloadPDFUsageDetail', [AdminController::class, 'admin_detail_logs_usage_pdf'])->name('admin.details.logs.pdf');
    Route::get('/AdminUsageResultMonth', [AdminController::class, 'admin_result_month_summary_usage'])->name('admin.result.month.summary.usage');
    Route::get('/AdminUsageResultResource', [AdminController::class, 'admin_result_resource_summary_usage'])->name('admin.result.resource.summary.usage');
    Route::get('/AdminApiNameReportSummary', [AdminController::class, 'admin_api_name_report_summary'])->name('admin.api.name.report.summary');
    Route::get('/AdminBackendApiUsage', [AdminController::class, 'admin_backend_api_usage_page'])->name('admin.backend.api.usage.page');
    Route::get('/AdminDetailBackendApiUsage/{api}', [AdminController::class, 'admin_detail_backend_api_usage_page'])->name('admin.detail.backend.api.usage.page');
    Route::get('/AdminDownloadPDFBackendApiUsage', [AdminController::class, 'admin_backend_api_usage_pdf'])->name('admin.backend.api.usage.pdf');
    Route::get('/AdminDownloadPDFDetailBackendApiUsage', [AdminController::class, 'admin_detail_backend_api_usage_pdf'])->name('admin.detail.backend.api.usage.pdf');
    Route::get('/AdminErrorSummary', [AdminController::class, 'admin_error_summary_page'])->name('admin.error.summary.page');
    Route::get('/AdminDownloadPDFErrorSummary', [AdminController::class, 'admin_error_summary_pdf'])->name('admin.error.summary.pdf');
    Route::get('/AdminDashboardPage', [AdminController::class, 'admin_dashboard_page'])->name('admin.dashboard.page');
    Route::get('/AdminDoughnutChartApiUsage', [AdminController::class, 'admin_doughnut_chart_api_usage'])->name('admin.doughtnut_chart_api_usage');
    Route::get('/AdminDoughnutChartResponseCount', [AdminController::class, 'admin_doughnut_chart_response_count'])->name('admin.doughtnut.chart.response.count');
    Route::get('/AdminDoughnutChartApplicationUsage', [AdminController::class, 'admin_doughnut_chart_application_usage'])->name('admin.doughtnut.chart.application.usage');
    Route::get('/AdminTableQuotaSubscription', [AdminController::class, 'admin_table_quota_subscription'])->name('admin.table.quota.subscription');
    Route::get('/AdminBarChartTopApiUsage', [AdminController::class, 'admin_bar_chart_top_usage'])->name('admin.bar.chart.top.usage');
    Route::get('/AdminBarChartTopFaultOvertime', [AdminController::class, 'admin_bar_chart_fault_overtime'])->name('admin.bar.chart.fault.overtime');
    Route::get('/AdminTableTopFaultOvertime', [AdminController::class, 'admin_table_fault_overtime'])->name('admin.table.fault.overtime');
    Route::get('/AdminInvoicePage', [AdminController::class, 'admin_invoice_page'])->name('admin.invoice.page');
    Route::get('/AdminCreateInvoicePage', [AdminController::class, 'admin_create_invoice_page'])->name('admin.create.invoice.page');
    Route::post('/AdminCreateInvoice', [AdminController::class, 'admin_create_invoice'])->name('admin.create.invoice');
    Route::get('/AdminPaymentPage', [AdminController::class, 'admin_payment_page'])->name('admin.payment.page');
    Route::get('/AdminHistoryWaiting', [AdminController::class, 'admin_history_waiting'])->name('admin.history.waiting');
    Route::get('/AdminModalConfirmationPayment', [AdminController::class, 'modal_confimation_payment'])->name('admin.modal.confirmation.payment');
    Route::get('/AdminModalTrackPayment', [AdminController::class, 'modal_track_payment'])->name('admin.modal.track.payment');
    Route::get('/AdminModalGetDetailInvoice', [AdminController::class, 'modal_get_detail_invoice'])->name('admin.modal.detail.invoice');
    Route::put('/AdminConfirmationPayment', [AdminController::class, 'confirmation_payment'])->name('admin.confirmation.payment');
    Route::get('/AdminHistoryAccepted', [AdminController::class, 'admin_history_accepted'])->name('admin.history.accepted');
    Route::get('/AdminHistoryRejected', [AdminController::class, 'admin_history_rejected'])->name('admin.history.rejected');
    Route::get('/AdminDownloadInvoicePDF', [AdminController::class, 'download_pdf_invoice'])->name('download.pdf.invoice');
    Route::get('/AdminBlockUnblockApi', [AdminController::class, 'block_unblock_api'])->name('block.unblock.api');
    Route::post('/AdminBlockUnblockApiAction', [AdminController::class, 'block_unblock_api_action'])->name('block.unblock.api.action');
    Route::get('/ErrorPage', [AdminController::class, 'error_page'])->name('error.page');
});

