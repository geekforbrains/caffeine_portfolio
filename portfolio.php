<?php

class Portfolio extends Module {

    public static function getCategories() {
        return Portfolio::category()->orderBy('name')->all();
    }

    public static function recentItems($limit)
    {
        if($items = Portfolio::item()->orderBy('created_at', 'DESC')->limit($limit)->get())
        {
            foreach($items as &$item)
            {
                $item->category = Portfolio::category()->find($item->category_id);
                $item->photos = Db::table('files_items')->where('item_id', '=', $item->id)->all();
            }
        }

        return $items;
    }

}
