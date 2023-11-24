<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Order;
use App\Models\OrderDetail;
//use App\Models\FoodType;


use Encore\Admin\Layout\Content;


class OrdersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Orders';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());
        $grid->column('id', __('Order Id'));
        $grid->column('user.f_name', __('User'));
        //Set the color, the default `success`, optional `danger`, `warning`, `info`, `primary`, `default`, `success`
        //$grid->column('name')->label('danger');
        $grid->column('order_amount', __('Order amount'))->label();
        $grid->column('order_status', __('Order status'));
        $grid->column('payment_method', __('Payment method')); 
        
        $grid->column('detailsOrdes.food_details', __('Food details'));

        //$grid->column('images')->carousel();
        //Set the display size and image server
        //$grid->column('images')->carousel($width = 300, int $height = 200, $server);
        //$grid->column('stars', __('Stars'));
        //$grid->column('img', __('Thumbnail Photo'))->image('',60,60);
        //$grid->column('description', __('Description'))->style('max-width:200px;word-break:break-all;')->display(function ($val){
            //return substr($val,0,30);
        //});
        //$grid->column('total_people', __('People'));
       // $grid->column('selected_people', __('Selected'));
        $grid->column('created_at', __('Created_at'));
        $grid->column('updated_at', __('Updated_at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());
        $form->text('order_amount', __('Order Amo'));
        //  $form->select('type_id', __('Type_id'))->options((new FoodType())::selectOptions());
        //$form->number('price', __('Price'));
        //$form->text('location', __('Location'));
        //$form->number('stars', __('Stars'));
        //$form->number('people', __('People'));
        //$form->number('selected_people', __('Selected'));
        //$form->image('img', __('Thumbnail'))->uniqueName();
        //$form->UEditor('description','Description');



        return $form;
    }
}
