<?php


namespace App\Presenters;


use App\Repositories\CategoryRepositoryEloquent;
use Prettus\Repository\Presenter\FractalPresenter;
use BmobObject;

class CategoryPresenter extends FractalPresenter
{

    protected $category;

    public function __construct(CategoryRepositoryEloquent $category)
    {
        $this->category = $category;
        parent::__construct();
    }

    /**
     * @return CategoryTransformer
     */
    public function getTransformer()
    {
        return new CategoryTransformer();
    }

    public function getSelect($defaultCategoryId = 0, $nullText = '请选择', $nullValue = 0)
    {
        $category = $this->category->getNestedList();
        return $this->getString($defaultCategoryId , $nullText , $nullValue ,$category);
    }

    public function getString($defaultCategoryId = 0, $nullText = '请选择', $nullValue = 0,$category)
    {
        $select = "<select id='cate_id' name='cate_id' class='form-control'>";
        $select .="<option value='".$nullValue."'>--".$nullText."--</option>";
        if($category){
            foreach($category as $key=>$value){
                $selected = $key == $defaultCategoryId? "selected":"";
                $select .="<option value='".$key."' ".$selected.">".$value."</option>";
            }
        }
        $select .= "</select>";

        return $select;
    }
}