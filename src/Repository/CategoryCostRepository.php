<?php
declare(strict_types=1);

namespace Financas\Repository;

use Illuminate\Support\Collection;
use Financas\Models\BillPay;
use Financas\Models\BillReceive;
use Financas\Models\CategoryCost;

class CategoryCostRepository extends DefaultRepository implements CategoryCostRepositoryInterface
{
    
    /**
     * CategoryCostRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(CategoryCost::class);
    }
    
    public function sumByPeriod(string $dateStart, string $dateEnd, int $userId): array {
        $categories = CategoryCost::query()
            ->selectRaw('category_costs.name, sum(value) as value')
            ->leftJoin('bill_pays', 'bill_pays.category_cost_id', '=', 'category_costs.id')
            ->whereBetween('date_launch', [$dateStart, $dateEnd])
            ->where('category_costs.user_id', $userId)
            ->whereNotNull('bill_pays.category_cost_id')
            ->groupBy('category_costs.name')
            ->get();
        return $categories->toArray(); 
    }

}