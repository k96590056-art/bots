<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    // 获取直接下级
    public function directChildren()
    {
        return $this->hasMany(Users::class, 'pid', 'id');
    }

    // 获取所有下级（递归）
    public function getAllChildrenIds()
    {
        $ids = [];
        $this->getChildrenRecursive($this->id, $ids);
        return $ids;
    }

    // 递归获取下级ID
    private function getChildrenRecursive($parentId, &$ids)
    {
        // 获取直接下级 (pid 或 fid)
        $children = Users::where(function($query) use ($parentId) {
            $query->where('pid', $parentId)
                  ->orWhere('fid', $parentId);
        })->get();
        
        foreach ($children as $child) {
            if (!in_array($child->id, $ids)) {
                $ids[] = $child->id; // 把下级ID加入数组
                // 递归获取下级的下级
                $this->getChildrenRecursive($child->id, $ids);
            }
        }
    }
    
    private function getChildrenRecursives($parentId, &$ids)
    {
        // 获取直接下级 (pid 或 fid)
        $children = Users::where(function($query) use ($parentId) {
            $query->where('pid', $parentId)
                  ->orWhere('fid', $parentId);
        })->get();
        
        foreach ($children as $child) {
            if (!in_array($child->id, $ids)) {
                $ids[] = $child->id; // 把下级ID加入数组
                // 递归获取下级的下级
                $this->getChildrenRecursive($child->id, $ids);
            }
        }
    }
}
