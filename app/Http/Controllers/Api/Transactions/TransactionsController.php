<?php 
namespace VanguardLTE\Http\Controllers\Api\Transactions;

use Illuminate\Http\Request;
use VanguardLTE\Http\Controllers\Api\ApiController;
use VanguardLTE\OpenShift;
use VanguardLTE\Statistic;
use VanguardLTE\Transformers\StatisticTransformer;

class TransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = auth()->user()->hierarchyUsers();
        $shops = auth()->user()->availableShops(true);

        $statistics = Statistic::select([
            'id', 'title', 'user_id', 'payeer_id', 'system', 'type', 'sum', 'sum2', 'shop_id', 'created_at'
        ])->orderBy('id', 'DESC');

        if (auth()->user()->shop_id > 0) {
            $statistics->whereIn('shop_id', $shops)
                ->whereIn('user_id', $users);
        }

        if (!auth()->user()->hasRole('admin')) {
            $statistics->whereNotIn('system', ['jpg', 'bank']);
        }

        $statistics->when($request->filled('user'), function ($query) use ($request) {
            $username = $request->user;
            return $query->where(function ($q) use ($username) {
                $q->whereHas('user', function ($q2) use ($username) {
                    $q2->where('username', $username);
                })->orWhereHas('payeer', function ($q2) use ($username) {
                    $q2->where('username', $username);
                });
            });
        }); 
        $statistics->when($request->filled('system'), function ($query) use ($request) {
            return $query->where('system', $request->system);
        });
        $statistics->when($request->filled('role'), function ($query) use ($request) {
            $role_id = $request->role;
            return $query->where(function ($q) use ($role_id) {
                $q->whereHas('user', function ($q2) use ($role_id) {
                    $q2->where('role_id', $role_id);
                })->orWhereHas('payeer', function ($q2) use ($role_id) {
                    $q2->where('role_id', $role_id);
                });
            });
        });

        $addFilterMappings = [
            'credit_in_from' => ['credit_in', '>='],
            'credit_in_to' => ['credit_in', '<='],
            'credit_out_from' => ['credit_out', '>='],
            'credit_out_to' => ['credit_out', '<='],
            'money_in_from' => ['money_in', '>='],
            'money_in_to' => ['money_in', '<='],
            'money_out_from' => ['money_out', '>='],
            'money_out_to' => ['money_out', '<='],
        ];

        $hasAddFilters = collect(array_keys($addFilterMappings))->contains(function ($param) use ($request) {
            return $request->filled($param);
        });

        if ($hasAddFilters) {
            $statistics->whereHas('add', function ($query) use ($request, $addFilterMappings) {
                foreach ($addFilterMappings as $param => $mapping) {
                    $query->when($request->filled($param), function ($q) use ($request, $param, $mapping) {
                        return $q->where($mapping[0], $mapping[1], $request->input($param));
                    });
                }
            });
        }

        $statistics->when($request->filled('dates'), function ($query) use ($request) {
            $dates = explode(' - ', $request->dates);
            if (count($dates) === 2) {
                return $query->whereBetween('created_at', [$dates[0], $dates[1]]);
            }
            return $query;
        });

        $statistics->when($request->filled('shifts'), function ($query) use ($request) {
            $shift = OpenShift::find($request->shifts);
            if ($shift) {
                $query->where('created_at', '>=', $shift->start_date);
                if ($shift->end_date) {
                    $query->where('created_at', '<=', $shift->end_date);
                }
            }
            return $query;
        });

        $paginatedStatistics = $statistics->paginate(100);

        return $this->respondWithPagination($paginatedStatistics, new StatisticTransformer());
    }
} 
