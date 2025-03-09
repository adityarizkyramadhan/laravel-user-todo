<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    protected $table = 'todos';
    protected $fillable = ['title', 'description', 'status', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeSort($query, $sort)
    {
        return $query->orderBy('created_at', $sort);
    }

    public function scopeSortStatus($query, $sort)
    {
        return $query->orderBy('status', $sort);
    }

    public function scopeSortTitle($query, $sort)
    {
        return $query->orderBy('title', $sort);
    }

    public function scopeSortDescription($query, $sort)
    {
        return $query->orderBy('description', $sort);
    }

    public function paginateFindAndFilter($filter, $sort, $perPage)
    {
        return $this->search($filter['search'] ?? '')
            ->status($filter['status'] ?? '')
            ->userId($filter['user_id'] ?? '')
            ->sort($sort['sort'] ?? 'desc')
            ->sortStatus($sort['sort_status'] ?? 'asc')
            ->sortTitle($sort['sort_title'] ?? 'asc')
            ->sortDescription($sort['sort_description'] ?? 'asc')
            ->paginate($perPage);
    }
}
