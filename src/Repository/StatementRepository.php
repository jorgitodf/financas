<?php
declare(strict_types=1);
namespace Financas\Repository;

use Financas\Models\BillPay;
use Financas\Models\BillReceive;
use Illuminate\Support\Collection;

class StatementRepository implements StatementRepositoryInterface
{
    public function all(string $dateStart, $dateEnd, int $userId): array 
    {
        $billPays = BillPay::query()
            ->selectRaw('bill_pays.*, category_costs.name AS category_name')
            ->leftJoin('category_costs', 'category_costs.name', '=', 'bill_pays.category_cost_id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->where('bill_pays.user_id', $userId)
            ->get();
        
        $billReceiveis = BillReceive::query()
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->where('user_id', $userId)
            ->get();
        
        $collection = new Collection(array_merge_recursive($billPays->toArray(), $billReceiveis->toArray()));
        $statements = $collection->sortByDesc('date_launch');
        return ['statements' => $statements, 
            'total_pays' => $billPays->sum('value'), 
            'total_receives' => $billReceiveis->sum('value')
        ];
    }
}