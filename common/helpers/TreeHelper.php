<?php

namespace common\helpers;

/**
 * Class TreeHelper
 * @package common\helpers
 * @author jianyan74 <751393839@qq.com>
 */
class TreeHelper
{
    /**
     * @return string
     */
    public static function prefixTreeKey($id)
    {
        return  $id . '-';
    }

    /**
     * @return string
     */
    public static function defaultTreeKey()
    {
        return '0-';
    }

    /**
     * 将扁平数组转换为树形结构
     *
     * @param array $list 数据列表(需包含 id, pid 字段)
     * @param string $pk 主键字段名
     * @param string $pid 父级字段名
     * @param string $child 子级字段名
     * @param int $root 根节点 pid 值
     * @return array
     */
    public static function list2tree($list, $pk = 'id', $pid = 'pid', $child = 'children', $root = 0)
    {
        $tree = [];
        $refer = [];

        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = &$list[$key];
        }

        foreach ($list as $key => $data) {
            $parentId = $data[$pid] ?? 0;
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }

        return $tree;
    }
}
