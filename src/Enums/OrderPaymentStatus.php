<?php

namespace Stanleysie\MsOrder\Enums;

/**
 * 付款狀態列舉類別
 * 定義了系統中所有可能的付款狀態常數與對應的處理方法
 * 
 * 包含以下付款狀態:
 * - UNPAID (0): 未付款
 * - PAID (1): 已付款
 * - FAILED (2): 付款失敗 
 * - REFUNDING (3): 退款中
 * - REFUNDED (4): 已退款
 * - NO_PAYMENT_REQUIRED (5): 無須付款
 * 
 * 主要功能:
 * - 提供付款狀態的常數定義
 * - 提供狀態代碼轉換為對應標籤文字的方法
 * 
 * @package Stanleysie\MsOrder\Enums
 * @see getLabel() 取得付款狀態對應的多語系 key
 * @example
 * // 獲取付款狀態標籤
 * $label = OrderPaymentStatus::getLabel(OrderPaymentStatus::UNPAID);
 */
class OrderPaymentStatus
{
    const UNPAID = 0;
    const PAID = 1;
    const FAILED = 2;
    const REFUNDING = 3;
    const REFUNDED = 4;
    const NO_PAYMENT_REQUIRED = 5;

    /**
     * 取得訂單付款狀態對應的標籤文字
     * 
     * 根據訂單付款狀態代碼返回對應的多語言標籤或文字說明
     * 
     * @param int $status 訂單付款狀態代碼
     * @return string 對應的標籤文字。如果狀態代碼不存在則返回「未知狀態」
     * 
     */
    public static function getLabel(int $status): string
    {
        $labels = [
            self::UNPAID => 'orders.unpaid',
            self::PAID => 'orders.paid',
            self::FAILED => 'orders.pay_unsuccess',
            self::REFUNDING => '退款中',
            self::REFUNDED => 'orders.refunded',
            self::REFUNDED => '無須付款',
        ];
        return $labels[$status] ?? '未知狀態';
    }
}