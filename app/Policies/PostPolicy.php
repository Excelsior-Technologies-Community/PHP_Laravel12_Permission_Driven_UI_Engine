<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Anyone authenticated may see the list (subject to UI @can).
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * View a single post if the user has post-view or owns it.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->can('post-view') || $user->id === $post->user_id;
    }

    public function create(User $user): bool
    {
        return $user->can('post-create');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->can('post-edit') || $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->can('post-delete') || $user->id === $post->user_id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->can('post-delete');
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->can('post-delete');
    }
}
