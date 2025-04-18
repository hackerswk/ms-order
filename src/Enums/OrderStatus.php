<?php

namespace Stanleysie\MsOrder\Enums;

/**
 * 訂單狀態列舉類別
 * 
 * 此類別定義了訂單可能的狀態常數，並提供取得對應狀態標籤的方法
 * 
 * 常量定義:
 * 
 * - CANCEL    訂單取消 (值為 0)
 * - ESTABLISH  訂單成立 (值為 1)
 * 
 * @package Stanleysie\MsOrder\Enums
 * @see getLabel() 根據狀態代碼取得對應的多語系 key
 * @example
 * // 獲取訂單狀態標籤
 * $label = OrderStatus::getLabel(OrderStatus::CANCEL);
 * 
 */
class OrderStatus
{
    const CANCEL = 0;
    const ESTABLISH = 1;

    protected static $labels = [
        self::CANCEL => 'orders.order_cancel',
        self::ESTABLISH => 'orders.order_confirm'
    ];

    /**
     * 取得訂單狀態的對應標籤
     *
     * @param int $status 訂單狀態代碼
     * @return string 狀態的翻譯標籤。如果找不到對應狀態則返回預設的「訂單成立」標籤
     *
     * @example
     * OrderStatus::getLabel(OrderStatus::CANCEL) // 返回 'orders.order_cancel'
     * OrderStatus::getLabel(OrderStatus::ESTABLISH) // 返回 'orders.order_confirm'
     * OrderStatus::getLabel(999) // 找不到對應狀態，返回譯 'orders.order_confirm'
     */
    public static function getLabel(int $status): string
    {
        return self::$labels[$status] ?? 'orders.order_confirm';
    }

    /**
     * 取得所有訂單狀態的標籤
     *
     * 回傳所有可用訂單狀態的對應標籤陣列
     * 
     * @return array<string,string> 訂單狀態標籤的關聯陣列，鍵為狀態代碼，值為對應的顯示標籤
     */
    public static function getLabels(): array
    {
        return self::$labels;
    }

    /**
     * 取得所有訂單狀態代碼
     *
     * 回傳所有可用的訂單狀態代碼
     * 
     * @return array<int> 訂單狀態代碼陣列
     */
    public static function getStatuses(): array
    {
        return [
            self::CANCEL,
            self::ESTABLISH,
        ];
    }
}