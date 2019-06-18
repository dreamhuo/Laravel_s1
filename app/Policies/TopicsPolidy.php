<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

// 这里继承的是同目录下 Policy.php 里的 class Policy
// 同目录下不需要 use
class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
