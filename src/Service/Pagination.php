<?php

namespace App\Service;

class Pagination
{

    public function paginate(int $limit,int $page, $repo,string $orderBy,string $way): array
    {
        $start = $limit * $page - $limit;
        return $repo->findBy([],[$orderBy => $way],$limit,$start);
    }

    public function numberPages(int $total, int $limit): float
    {
        return ceil($total / $limit);
    }
}