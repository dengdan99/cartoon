<?php


namespace app\validate;


use think\facade\Db;
use think\Validate;

class Tag extends Validate
{
    protected $rule = [
        'tag_name|分类名' => "require",
        'sort|排序' => 'require|integer|checkSort',
    ];

    protected $message = [
        'tag_name.require' => '分类名不能为空',
        'tag_name.unique' => '分类名重复',
    ];

    public function __construct()
    {
        parent::__construct();

    }

    public function sceneEdit()
    {
        $id = input('id',0);
        return $this->only(['tag_name'])
            ->append('tag_name|分类名','unique:tags,tag_name,'.$id);
    }

    public function sceneSort()
    {
        return $this->only(['sort']);
    }

    public function checkSort($value,$rule,$data)
    {
        if (isset($data['id']) && !empty($data['id'])){
            $table = Db::name('tags')->find($data['id']);
            if (empty($table)) {
                return false;
            }else{
                return true;
            }
        }
        return true;
    }
}