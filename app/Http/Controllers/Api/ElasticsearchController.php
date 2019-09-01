<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CsvRequest;
use App\Http\Requests\Api\SearchRequest;
use Elasticsearch\Endpoints\Snapshot\Status;
use Illuminate\Http\Request;

class ElasticsearchController extends Controller
{
    //结构化elastic聚类
    protected $elastic;

    //封装服务体
    public function __construct()
    {
        $this->elastic = app('es');
    }

    public function dmProgram(Request $request)
    {
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_dm_prgram'],
                [
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'sort' => [
                        ['demand_freq' => ['order' => 'desc']]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function bdemand(Request $request)
    {
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_dm'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'demand_user_num' => [
                            'sum' => ['field' => 'demand_user_num']
                        ],
                        'demand_freq' => [
                            'sum' => ['field' => 'demand_freq']
                        ],
                        'watch_freq_family' => [
                            'sum' => ['field' => 'watch_freq_family']
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function bonlive(Request $request)
    {
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_olv'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'onlive_user_num' => [
                            'sum' => ['field' => 'onlive_user_num']
                        ],
                        'onlive_freq' => [
                            'sum' => ['field' => 'onlive_freq']
                        ],
                        'watch_freq_family' => [
                            'sum' => ['field' => 'watch_freq_family']
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function watchTotal(Request $request)
    {
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_wtc'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'watch_user_num' => [
                            'sum' => ['field' => 'watch_user_num']
                        ],
                        'watch_freq' => [
                            'sum' => ['field' => 'watch_freq']
                        ],
                        'watch_freq_family' => [
                            'sum' => ['field' => 'watch_freq_family']
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function breview(Request $request)
    {
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_rev'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'watch_user_num' => [
                            'sum' => ['field' => 'watch_user_num']
                        ],
                        'watch_freq' => [
                            'sum' => ['field' => 'watch_freq']
                        ],
                        'watch_freq_family' => [
                            'sum' => ['field' => 'watch_freq_family']
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }


    public function subReport(Request $request)
    {
        $arr = explode(',', $request->operator);
        $params = [
            'body' => [
                ['index' => 'rw_clk_ti'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['terms' => [
                                    'operators.keyword' => $arr
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'ti' => [
                            'terms' => [
                                'field' => 'ti.keyword',
                                'size' => 100
                            ],
                            'aggs' => [
                                'click_freq' => [
                                    'sum' => [
                                        'field' => 'click_freq'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function epg(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'rw_clk_ti_bx'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'operators.keyword' => [
                                        'value' => $request->operator
                                    ]
                                ]],
                                ['term' => [
                                    'ti.keyword' => [
                                        'value' => $request->list
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ],
                            'should' => [
                                ['term' => [
                                    'ver' => $request->ver
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'click_freq' => [
                            'sum' => [
                                'field' => 'click_freq'
                            ]
                        ]
                    ]

                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function dmProgramP(Request $request)
    {
        $arr = explode(',', $request->operator);
        //DSL结构
        $params = [
            'body' => [
                ['index' => 'rw_dm_ptp_nm'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['terms' => [
                                    'operators.keyword' => $arr
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'demand_freq' => [
                            'sum' => [
                                'field' => 'demand_freq'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function epgProgramList(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'rw_clk_ti_bx'],
                [
                    'size' => 0,
                    'aggs' => [

                        'ti' => [
                            'terms' => [
                                'field' => 'ti.keyword',
                                'size' => 100
                            ]
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function daliyReport(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function monthActiveReport(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function liveDaliyReport(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function weekActiveReport(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'rw_rev_chn'],
                [],
                ['index' => 'rw_rev_chn_prg'],
                [],
                ['index' => 'rw_rev_prgram'],
                []
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function vipReport(Request $request)
    {
        $arr = explode(',', $request->operator);

        $params = [
            'body' => [
                ['index' => 'rw_dm_ti'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['terms' => [
                                    'operators.keyword' => $arr
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'ti' => [
                            'terms' => [
                                'field' => 'ti.keyword',
                                'size' => 15,
                                'order' => [
                                    'demand_user_num' => 'desc'
                                ]
                            ],
                            'aggs' => [
                                'demand_user_num' => [
                                    'sum' => [
                                        'field' => 'demand_user_num'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function marketReport(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function userAction(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function actionTop(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function actionProgramList(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function hotTop(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function areaCode(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'ru_boot'],
                [
                    'aggs' => [
                        'terms' => [
                            'field' => 'ac.keyword',
                            'size' => 20
                        ]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function total(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'ru_boot'],
                [
                    'size' => 0,
                    'query' => [
                        'bool' => [
                            'filter' => [
                                ['term' => [
                                    'begin_date.keyword' => [
                                        'value' => $request->start
                                    ]
                                ]],
                                ['term' => [
                                    'end_date.keyword' => [
                                        'value' => $request->end
                                    ]
                                ]]
                            ]
                        ]
                    ],
                    'aggs' => [
                        'ac' => [
                            'terms' => [
                                'field' => 'ac.keyword',
                                'size' => 20
                            ],
                            'aggs' => [
                                'open_num' => [
                                    'sum' => [
                                        'field' => 'open_num'
                                    ]
                                ]
                            ]
                        ]
                    ]

                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function liveAreaCode(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function incrementList(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function increment(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function search(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function vIncrement(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function vipList(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function vipAreaCode(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function vipPackage(Request $request)
    {
        $params = [
            'body' => [

            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }

    public function demandProgramTop(Request $request)
    {
        $params = [
            'body' => [
                ['index' => 'rw_olv_prgram'],
                [
                    'query' => [
                        'bool' => [
                            ['term' => [
                                'begin_date' => [
                                    'field' => $request->start
                                ]
                            ]],
                            ['term' => [
                                'end_date' => [
                                    'field' => $request->end
                                ]
                            ]]
                        ]
                    ],
                    'sort' => [
                        ['demand_freq' => ['order' => 'desc']]
                    ]
                ]
            ]
        ];

        //search api
        $data = $this->elastic->msearch($params);

        return $this->response->array($data)->setStatusCode(200);
    }
}


