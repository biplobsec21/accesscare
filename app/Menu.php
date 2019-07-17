<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
/**
 * Class ShippingCourier
 * @package EAC
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class Menu extends Model
{
    

    /**
     * Indicates if the model should automatically increment the id
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => \App\Events\ChangeLogEvent::class,
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * The prefix for the id
     *
     * @var string
     */
    protected $prefix = "MENUS";

    public function multiLabelMenu()
    {
        $parent_menu = array();
        $sub_menu = array();
        $list = array();
        $items = DB::table('menus')
            ->where('active', '=',1);

        $stack = array();
        $child_list = array();

        $stack[] =&$items[0];
        while(!empty($stack))
        {
            $parent_element = array_pop($stack);
            $parent_element->children = [];
            foreach ($items as &$item)
            {
                if($item->parent_menu == $parent_element->id)
                {
                    $parent_element->children[] =  $item;
                    $stack[] = $item;
                }
            }
        }
        return($items[0]);
    }

    public function selectBoxMaker($rootItem, $outputArray = false)
    {
        //dd($rootItem);
        $stack = array();
        $element = array();
        $rootItem->space = "";
        $stack[] = &$rootItem;
        $allMenuItem = array();
        $totalString = "";
        while(!empty($stack)) {
            $element = array_pop($stack);
            if($outputArray)
                $allMenuItem[] = [
                    'id' => $element->id,
                    'value' => $element->space.$element->name
                ];
            else
                $totalString .= "<option value='{$element->id}'>{$element->space}{$element->name}</option>";

            $childSpaces = $element->space. '&nbsp;  &nbsp; ' ;
            if(!empty($element->children))
            {
                $children = array_reverse($element->children);

                foreach ( $children as $child) {
                    $child->space = $childSpaces;
                    $stack[] = $child;
                    // echo $child;
                }
            }
        }
        //dd($totalString);
        if($outputArray)
            return $allMenuItem;
        else
            return "<select>$totalString</select>";
    }
}
