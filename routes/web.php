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
    Route::get('/CustomerReportResultApi', [CustomerController::class, 'customer_result_api_summary_report'])->name('customer.result.api.summary.report');
    Route::get('/CustomerReportDetail/{app}/{api}', [CustomerController::class, 'customer_detail_logs_report'])->name('customer.detail.logs.report');
    Route::get('/CustomerApiResourceUsageSummary', [CustomerController::class, 'customer_api_resource_usage_summary_page'])->name('customer.api.resource.usage.summary.page');
    Route::get('/CustomerUsageResultResource', [CustomerController::class, 'customer_result_resource_summary_usage'])->name('customer.result.resource.summary.usage');
    Route::get('/CustomerUsageResultMonth', [CustomerController::class, 'customer_result_month_summary_usage'])->name('customer.result.month.summary.usage');
    Route::get('/CustomerUsageDetail', [CustomerController::class, 'customer_detail_logs_usage'])->name('customer.detail.logs.usage');
    Route::get('/CustomerDashboard', [CustomerController::class, 'customer_dashboard_page'])->name('customer.dashboard.page');
    
    Route::get('/AdminMonthlyReportSummary', [AdminController::class, 'admin_monthly_report_summary_page'])->name('admin.monthly.report.summary.page');
    Route::get('/AdminApiResourceUsageSummary', [AdminController::class, 'admin_api_resource_usage_summary_page'])->name('admin.api.resource.usage.summary.page');
    Route::get('/AdminUsageDetail', [AdminController::class, 'admin_detail_logs_usage'])->name('admin.detail.logs.usage');
    Route::get('/AdminUsageResultMonth', [AdminController::class, 'admin_result_month_summary_usage'])->name('admin.result.month.summary.usage');
    Route::get('/AdminUsageResultResource', [AdminController::class, 'admin_result_resource_summary_usage'])->name('admin.result.resource.summary.usage');
    Route::get('/AdminInvoicePage', [AdminController::class, 'admin_invoice_page'])->name('admin.invoice.page');
    Route::get('/AdminPaymentPage', [AdminController::class, 'admin_payment_page'])->name('admin.payment.page');

});

