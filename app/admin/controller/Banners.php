<?php


namespace app\admin\controller;

use app\model\Banner;
use app\model\Book;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\ValidateException;
use think\facade\View;
use app\validate\Image;

class Banners extends BaseAdmin
{
    public function index()
    {
        $data = Banner::with('book')->where('platform', 'h5');
        $banners = $data->order('id', 'desc')->paginate(5, false,
            [
                'query' => request()->param(),
                'var_page' => 'page',
            ]);
        View::assign([
            'banners' => $banners,
            'count' => $data->count()
        ]);
        return view();
    }

    public function pcIndex()
    {
        $data = Banner::with('book')->where('platform', 'pc');
        $banners = $data->order('id', 'desc')->paginate(5, false,
            [
                'query' => request()->param(),
                'var_page' => 'page',
            ]);
        View::assign([
            'banners' => $banners,
            'count' => $data->count()
        ]);
        return view();
    }

    public function create()
    {
        if (request()->isPost()) {
            if (empty(request()->file()))
                return json(['err' => 1, 'msg' => "没有上传图片"]);
            $banner = new Banner();
            $banner->title = input('title');
            $banner->book_id = input('book_id');
            $book = Book::find($banner->book_id);
            if (empty($book))
                return json(['err' => 1, 'msg' => '漫画不存在']);

            $banner->banner_order = input('banner_order');
            $banner->platform = input("platform");
            $dir = 'banners';

            if (!empty(request()->file())) {
                $cover = request()->file('pic_name');
                try {
                    $banner->pic_name = $this->uploadImg($cover, $dir);
                } catch (ValidateException $e) {
                    return json(['err' => 1, 'msg' => $e->getError()]);
                }
            }
            $result = $banner->save();
            if ($result) {
                return json(['err' => 0, 'msg' => '添加成功']);
            } else {
                return json(['err' => 1, 'msg' => '添加失败']);
            }
        }
        return view();
    }

    public function edit()
    {
        $id = input('id');
        try {
            $banner = Banner::findOrFail($id);
            if (request()->isPost()) {
                $banner->title = input('title');
                $banner->book_id = input('book_id');
                $book = Book::find($banner->book_id);
                if (empty($book))
                    return json(['err' => 1, 'msg' => '漫画不存在']);
                $banner->banner_order = input('banner_order');
                $banner->platform = input("platform");
                $dir = 'banners';
                if (!empty(request()->file())) {
                    $cover = request()->file('pic_name');
                    try {
                        $banner->pic_name = $this->uploadImg($cover, $dir);
                    } catch (ValidateException $e) {
                        return json(['err' => 1, 'msg' => $e->getError()]);
                    }
                }
                $result = $banner->save();
                if ($result) {
                    return json(['err' => 0, 'msg' => '编辑成功']);
                } else {
                    return json(['err' => 1, 'msg' => '修改失败']);
                }
            }
            View::assign([
                'banner' => $banner,
            ]);
            return view();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function pcCreate()
    {
        return view();
    }

    public function pcEdit()
    {
        $id = input('id');
        try {
            $banner = Banner::findOrFail($id);
            View::assign(compact('banner'));
            return view();
        } catch (DataNotFoundException $e) {
            abort(404, $e->getMessage());
        } catch (ModelNotFoundException $e) {
            abort(404, $e->getMessage());
        }
    }

    public function delete()
    {
        $id = input('id');
        $result = Banner::destroy($id);
        if ($result) {
            return ['err' => 0, 'msg' => '删除成功'];
        } else {
            return ['err' => 1, 'msg' => '删除失败'];
        }
    }

    public function deleteAll($ids)
    {
        Banner::destroy($ids);
    }
}