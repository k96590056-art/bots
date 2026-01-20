<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

/**
 * Admin routes
 */
Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('agent-tree', 'AgentCommissionController@agentTree');
    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UserController');
    $router->resource('user-vips', 'UserVipController');
    $router->post('user-vips/{id}/toggle-switch', 'UserVipController@toggleSwitch');
    $router->resource('messages', 'MessageController');
    $router->resource('recharge','RechargeController');
    $router->resource('red-envelopes','RedEnvelopesController');
    $router->resource('code-pay','CodePayController');

    // 批量操作（必须在 resource 路由之前定义，否则会被 {id} 匹配）
    $router->post('withdraws/batch-info','WithdrawController@batchInfo');
    $router->post('withdraws/batch-pass','WithdrawController@batchPass');
    $router->post('withdraws/batch-refuse','WithdrawController@batchRefuse');
    // USDT 提现 TronLink 转账确认
    $router->post('withdraw/confirm-transfer','WithdrawController@confirmTransfer');
    // 提现审核：通过和拒绝
    $router->post('withdraws/{id}/pass','WithdrawController@pass');
    $router->post('withdraws/{id}/refuse','WithdrawController@refuse');
    $router->resource('withdraws','WithdrawController');
    $router->resource('banks','BankController');
    $router->resource('syslog','SyslogController');
    $router->resource('pay-settings','PaySettingController');
    $router->get('/pay-config','SystemConfigController@index');
    $router->resource('activities','ActivityController');
    $router->resource('fanshui','FanshuiLogController');
    $router->resource('activity-apply','ActivityApplyController');
    $router->resource('activity-types','ActivityTypeController');
    $router->resource('transfer-logs','TransferLogController');
    $router->resource('finance-report','FinanceReportController');
    $router->resource('game-records','GameRecordController');
    $router->resource('apis','ApiController');
    $router->post('apis/{id}/toggle', 'ApiController@toggle');
    // 获取子分类路由必须在 resource 之前定义，避免被 {id} 匹配
    $router->get('game-categories/children', 'GameCategoryController@getChildren');
    $router->resource('game-categories','GameCategoryController');
    $router->resource('game-tags','GameTagController');
    // 获取子分类路由必须在 resource 之前定义，避免被 {id} 匹配
    $router->get('game-lists/child-categories', 'GameListController@getChildCategories');
    $router->get('game-lists/venues', 'GameListController@getVenues');
    $router->resource('game-lists','GameListController');
    // 获取子分类路由必须在 resource 之前定义
    $router->get('game-lists-app/child-categories', 'GameListAppController@getChildCategories');
    $router->resource('game-lists-app','GameListAppController');
    $router->get('/system-setting','SystemConfigController@siteSetting');
    $router->resource('bet-report','BetReportController');
    $router->resource('bet-sum','BetSumController');
    $router->resource('templates','TemplateController');
    $router->get('/templates','TemplateController@index');
    $router->get('/setDefaultTemplate/{id}/{type}','TemplateController@setDefaultTemplate');
    $router->resource('agents','AgentController');
    $router->get('api/agents/{ignore_id?}', 'AgentController@apiIndex');
    $router->resource('agent-applys','AgentApplyController');
    $router->resource('agent-commission','AgentCommissionController');
    $router->resource('agent-settlements','AgentSettlementController');

    $router->resource('userredpacket','UserredpacketController');
    $router->resource('usercard','UserCardController');
    $router->resource('articlescate','ArticlescateController');
    $router->resource('articles','ArticleController');

    $router->get('/user/upbalance/{id}','UserController@upbalance');
    $router->resource('user-operate-logs','UserOperateLogController');
    $router->resource('banners','BannerController');
    $router->resource('sponsors','SponsorController'); // 赞助管理
    $router->resource('regions', 'RegionController'); // 地区设置
    
    // 临时路由：执行迁移
    $router->get('run-migrations', 'SystemConfigController@runMigrations');

    $router->get('clear','SystemConfigController@clear');
    $router->post('alert','HomeController@getAlertData');

    // 工单系统路由
    $router->resource('work-orders', 'WorkOrderController');
    $router->post('work-orders/{id}/reply', 'WorkOrderController@handleReply');
    $router->put('work-orders/{id}', 'WorkOrderController@update');
    $router->post('work-orders/{id}/close', 'WorkOrderController@close');
    $router->post('work-orders/{id}/open', 'WorkOrderController@open');
    
    // 测试路由 - 临时调试用
    $router->get('work-orders/{id}/test', 'WorkOrderController@testReply');
    $router->get('work-orders/{id}/test-delete', 'WorkOrderController@testDelete');
    
    // 测试控制器路由
    $router->get('test', 'TestController@index');
    $router->get('test-html', 'TestController@html');
    $router->get('test-error', 'TestController@error');

});
