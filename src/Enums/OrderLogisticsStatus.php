<?php

namespace Stanleysie\MsOrder\Enums;

/**
 * 物流狀態列舉類別
 * 
 * 這個類別定義了訂單的物流狀態常量及相關處理功能。
 * 提供了四種基本物流狀態：未出貨、已出貨、已收貨和數位交付。
 * 包含獲取物流狀態標籤的靜態方法。
 *
 * 常量定義:
 * - PENDING(0): 表示訂單尚未出貨的狀態
 * - SHIPPED(1): 表示訂單已經出貨的狀態
 * - RECEIVED(2): 表示訂單已被收貨的狀態
 * - DIGITAL_DELIVERY(3): 表示數位商品交付的狀態
 *
 * @package Stanleysie\MsOrder\Enums
 * @see OrderLogisticsStatus::getLabel() 用於獲取狀態對應的標籤文字
 * @example
 * // 獲取物流狀態標籤
 * $label = OrderLogisticsStatus::getLabel(OrderLogisticsStatus::PENDING);
 */
class OrderLogisticsStatus
{
    const PENDING = 0;
    const SHIPPED = 1;
    const RECEIVED = 2;
    const DIGITAL_DELIVERY = 3;

    protected static $labels = [
        self::PENDING => 'orders.not_ship',
        self::SHIPPED => 'orders.shipped',
        self::RECEIVED => 'orders.picked_up',
        self::DIGITAL_DELIVERY => '數位交付',
    ];

    /**
     * 根據物流狀態代碼取得對應的標籤文字
     *
     * @param int $status 物流狀態代碼
     * @return string 對應的標籤文字，如果找不到對應狀態則返回'未知狀態'
     *
     */
    public static function getLabel(int $status): string
    {
        return self::$labels[$status] ?? '未知狀態';
    }

    /**
     * 取得所有訂單物流狀態的標籤
     *
     * 回傳所有可用訂單物流狀態的對應標籤陣列
     * 
     * @return array<string,string> 訂單物流狀態標籤的關聯陣列，鍵為狀態代碼，值為對應的顯示標籤
     */
    public static function getLabels(): array
    {
        return self::$labels;
    }

    /**
     * 取得所有訂單物流狀態代碼
     *
     * 回傳所有可用的訂單物流狀態代碼
     * 
     * @return array<int> 訂單物流狀態代碼陣列
     */
    public static function getStatuses(): array
    {
        return [
            self::PENDING,
            self::SHIPPED, 
            self::RECEIVED,
            self::DIGITAL_DELIVERY
        ];
    }
}