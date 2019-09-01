<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1.0.0', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings', 'cors'],
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.sign.limit'),
        'expires' => config('api.rate_limits.sign.expires'),
    ], function ($api) {
        //登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorization.store');
        //token刷新
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorization.update');
        //token销毁
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');
    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rate_limits.access.limit'),
        'expires' => config('api.rate_limits.access.expires'),
    ], function ($api) {

        //api版本
        $api->get('version', function () {
            return response('This is version 1.0.0');
        });
        //f
        $api->get('broadcast/demand', 'ElasticsearchController@bdemand')
            ->name('api.broadcast.demand');

        $api->get('broadcast/onlive', 'ElasticsearchController@bonlive')
            ->name('api.broadcast.onlive');
        //f
        $api->get('demandProgramTop', 'ElasticsearchController@dmProgram')
            ->name('api.demandProgramTop');
        //f
        $api->get('media/watch/total', 'ElasticsearchController@watchTotal')
            ->name('api.watch.total');
        //f
        $api->get('broadcast/review', 'ElasticsearchController@breview')
            ->name('api.broadcast.review');
        //f
        $api->post('users/subReport', 'ElasticsearchController@subReport')
            ->name('api.users.subReport');
        //f
        $api->get('epg/programs/list', 'ElasticsearchController@epgProgramList')
            ->name('api.epg.programs.list');
        //f
        $api->post('epg', 'ElasticsearchController@epg')
            ->name('api.users.epg');
        //f
        $api->post('users/mobileReport', 'ElasticsearchController@dmProgramP')
            ->name('api.users.mobileReport');

        $api->post('users/daliyReport', 'ElasticsearchController@daliyReport')
            ->name('api.users.daliyReport');

        $api->post('users/monthActiveReport', 'ElasticsearchController@monthActiveReport')
            ->name('api.users.monthActiveReport');

        $api->post('liveUsers/daliyReport', 'ElasticsearchController@liveDaliyReport')
            ->name('api.users.live.daliyReport');

        $api->post('users/weekActiveReport', 'ElasticsearchController@weekActiveReport')
            ->name('api.users.weekActiveReport');

        $api->post('users/vipReport', 'ElasticsearchController@vipReport')
            ->name('api.users.vipReport');

        $api->post('users/marketReport', 'ElasticsearchController@marketReport')
            ->name('api.users.marketReport');

        $api->post('userAction', 'ElasticsearchController@userAction')
            ->name('api.users.marketReport');

        $api->get('userAction/top', 'ElasticsearchController@actionTop')
            ->name('api.users.action.top');

        $api->get('userAction/programs/list', 'ElasticsearchController@actionProgramList')
            ->name('api.users.action.list');

        $api->get('hot/top', 'ElasticsearchController@hotTop')
            ->name('api.users.hot.top');

        $api->get('areaCode', 'ElasticsearchController@areaCode')
            ->name('api.area.code');

        $api->get('users/total', 'ElasticsearchController@total')
            ->name('api.users.total');

        $api->get('userLives/areaCode', 'ElasticsearchController@liveAreaCode')
            ->name('api.users.live.areaCode');

        $api->get('increment/programs/list', 'ElasticsearchController@incrementList')
            ->name('api.increment.list');

        $api->post('increment', 'ElasticsearchController@increment')
            ->name('api.increment');

        $api->post('search', 'ElasticsearchController@search')
            ->name('api.search');

        $api->post('vip/increment', 'ElasticsearchController@vIncrement')
            ->name('api.vip.increment');

        $api->get('vip/programs/list', 'ElasticsearchController@vipList')
            ->name('api.vip.list');

        $api->get('vip/areaCode', 'ElasticsearchController@vipAreaCode')
            ->name('api.vip.AreaCode');

        $api->get('vip/increment', 'ElasticsearchController@vipPackage')
            ->name('api.vip.package');
    });
});
