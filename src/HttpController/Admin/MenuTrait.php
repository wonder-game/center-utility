<?php


namespace WonderGame\CenterUtility\HttpController\Admin;

use WonderGame\CenterUtility\Common\Exception\HttpParamException;
use WonderGame\CenterUtility\Common\Http\Code;
use WonderGame\CenterUtility\Common\Languages\Dictionary;

/**
 * Class Menu
 * @property \App\Model\Admin\Menu $Model
 * @package App\HttpController\Admin
 */
trait MenuTrait
{
	public function index()
	{
		$input = $this->get;

		$where = [];
		if ( ! empty($input['title'])) {
			$where['title'] = ["%{$input['title']}%", 'like'];
		}
		if (isset($input['status']) && $input['status'] !== '') {
			$where['status'] = $input['status'];
		}
        if (isset($input['sub'])) {
            $this->Model->where("(FIND_IN_SET('{$input['sub']}', sub) > 0 OR sub='')");
        }

		$result = $this->Model->getTree($where);
		$this->success($result);
	}

	/**
	 * Client vue-router
	 */
    public function _getMenuList($return = false)
	{
		$userMenus = $this->getUserMenus();
		if ( ! is_null($userMenus) && empty($userMenus)) {
			throw new HttpParamException(lang(Dictionary::PERMISSION_DENIED));
		}

        $where = ['type' => [[0, 1], 'in'], 'status' => 1 ];
        $options = ['isRouter' => true, 'filterIds' => $userMenus];
        $this->Model->where("(FIND_IN_SET('{$this->sub}', sub) > 0 OR sub='')");
        $menu = $this->Model->getTree($where, $options);
		return $return ? $menu : $this->success($menu);
	}

    /**
     * 所有菜单树形结构
     * @return void
     */
    public function _treeList($return = false)
    {
        $treeData = $this->Model->getTree();
        return $return ? $treeData : $this->success($treeData);
    }
}
