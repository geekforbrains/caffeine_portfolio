<?php

class Portfolio_PortfolioController extends Controller {


    public static function category($categorySlug)
    {
        if(!$category = Portfolio::category()->find($categorySlug))
            return ERROR_NOTFOUND;

        if($items = Portfolio::item()->where('category_id', '=', $category->id)->orderBy('created_at', 'DESC')->all())
        {
            foreach($items as &$item)
                $item = self::_getExtras($item);
        }

        View::data('items', $items);
    }


    public static function item($categorySlug, $itemSlug)
    {
        if(!$item = Portfolio::item()->find($itemSlug))
            return ERROR_NOTFOUND;

        $item = self::_getExtras($item);

        View::data('item', $item);
    }


    private static function _getExtras($item)
    {
        $item->category = Portfolio::category()->find($item->category_id);
        $item->photos = Db::table('files_items')->where('item_id', '=', $item->id)->all();

        return $item;
    }


}
