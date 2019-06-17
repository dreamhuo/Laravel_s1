<?php
namespace App\Http\Controllers;
use App\Models\Topic;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Auth;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    public function index()
    {
        // 方法 with() 提前加载了我们后面需要用到的关联属性 user 和 category，并做了缓存。后面即使是在遍历数据时使用到这两个关联属性，数据已经被预加载并缓存，因此不会再产生多余的 SQL 查询
        $topics = Topic::with('user', 'category')->paginate(30);
        return view('topics.index', compact('topics'));
    }

    // 展示页面
    public function show(Request $request, Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

    // 创建话题页面
    public function create(Topic $topic)
    {
        // 将所有的分类读取赋值给变量 $categories ，在顶部引入 Category 并传入模板中
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic', 'categories'));
    }

    // 更新话题接口
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->to($topic->link())->with('success', '更新成功！');
    }

    // 存储话题接口
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }
}