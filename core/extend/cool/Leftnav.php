<?php

namespace cool;

class leftnav
{
    /*
     * 自定义菜单排列
     */
    public static function menu($cate, $lefthtml = '|— ', $pid = 0, $lvl = 0, $leftpin = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $v['lvl'] = $lvl + 1;
                $v['leftpin'] = $leftpin + 0;
                $v['lefthtml'] = str_repeat($lefthtml, $lvl);
                $v['ltitle'] = $v['lefthtml'].$v['name'];
                $arr[] = $v;
                $arr = array_merge($arr, self::menu($cate, $lefthtml, $v['id'], $lvl + 1, $leftpin + 20));
            }
        }

        return $arr;
    }

    public static function authRule($cate, $pid = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                $arr[] = $v;
                // dump(self::authRule($cate, $v['id']));
                $arr = array_merge($arr, self::authRule($cate, $v['id']));
            }
        }
        return $arr;
    }
    public static function cate($cate, $lefthtml = '|— ', $pid = 0, $lvl = 0, $leftpin = 0)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parentid'] == $pid) {
                $v['lvl'] = $lvl + 1;
                $v['leftpin'] = $leftpin + 0;
                $v['lefthtml'] = str_repeat($lefthtml, $lvl);
                $arr[] = $v;
                $arr = array_merge($arr, self::menu($cate, $lefthtml, $v['id'], $lvl + 1, $leftpin + 20));
            }
        }

        return $arr;
    }

    public static function auth($cate, $pid = 0, $gid)
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['pid'] == $pid) {
                if (1 == $gid) {
                    $v['checked'] = true;
                } else {
                    if ($v['roleid'] && in_array($gid, explode(',', $v['roleid']))) {
                        $v['checked'] = true;
                    }
                }
                $v['open'] = true;
                $arr[] = $v;
                $arr = array_merge($arr, self::auth($cate, $v['id'], $gid));
            }
        }

        return $arr;
    }

    /*
     * $column_one 顶级栏目
     * $column_two 所有栏目
     * 用法匹配column_leftid 进行数组组合
     */
    public static function index_top($column_one, $column_two)
    {
        $arr = array();
        foreach ($column_one as $v) {
            $v['sub'] = self::index_toptwo($column_two, $v['id']);
            $arr[] = $v;
        }

        return $arr;
    }

    public static function index_toptwo($column_two, $c_id)
    {
        $arry = array();
        foreach ($column_two as $v) {
            if ($v['parentid'] == $c_id) {
                $arry[] = $v;
            }
        }

        return $arry;
    }
}
