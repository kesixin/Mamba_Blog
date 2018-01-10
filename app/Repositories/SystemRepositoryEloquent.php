<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 23:00
 */

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SystemRepository;
use Illuminate\Container\Container as Application;
use App\Models\System;

/**
 * Class SystemRepositoryEloquent
 * @package App\Repositories
 *
 */
class SystemRepositoryEloquent extends BaseRepository implements SystemRepository
{

    private $config;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->config = config('blog.system_key');
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return System::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function optionList()
    {
        //检索数据库表的所有数据
        $all = $this->all(['key', 'value']);

        $system = $this->initSystemKey();
        foreach ($all as $item) {
            $system[$item['key']] = $item['value'];
        }
        return $system;
    }

    /**
     * 反转数组
     * @return array
     */
    public function initSystemKey()
    {
        $init = [];
        $config = array_flip($this->config);
        foreach ($config as $key => $value) {
            $init[$key] = '';
        }

        return $init;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data)
    {
        if (!$data) {
            return false;
        }

        unset($data['_token']);
        foreach ($data as $key => $value) {
            if (in_array($key, $this->config)) {
                $this->updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return true;

    }

}