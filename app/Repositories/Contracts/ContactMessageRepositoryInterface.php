<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactMessageRepositoryInterface extends RepositoryInterface
{
    public function paginateLatest(int $perPage = 15): LengthAwarePaginator;

    public function unreadCount(): int;
}
