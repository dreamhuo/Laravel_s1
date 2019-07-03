<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

// UserTransformer 是可以复用的
// 当前用户信息，发布话题用户信息，话题回复用户信息都可以用这一个 transformer
// 这样我们所有的有关 用户 的资源都会返回相同的信息
// 客户端只需要解析一遍即可。因为是可复用的，特别需要注意一些敏感信息，如：
// 用户手机，微信的 union_id 等，我们可以使用另外的字段返回
class UserTransformer extends TransformerAbstract
{
    // 只需要给 transformer 方法传入一个模型实例
    public function transform(User $user)
    {
        // 然后返回一个数据即可，这个数组就是返回给客户端的响应数据
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'introduction' => $user->introduction,
            'bound_phone' => $user->phone ? true : false,
            'bound_wechat' => ($user->weixin_unionid || $user->weixin_openid) ? true : false,
            'last_actived_at' => $user->last_actived_at->toDateTimeString(),
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at,
        ];
    }
}