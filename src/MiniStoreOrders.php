<?php
/**
 * Mini store orders class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

/**
 * Class MiniStoreOrders
 *
 * This class handles CRUD operations for the `ministore_orders` table.
 */
class MiniStoreOrders
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * MiniStoreOrders constructor.
     *
     * @param PDO $conn Database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Create a new order.
     *
     * @param array $data Order data
     * @return string|false
     */
    public function createOrder($data)
    {
        try {
            $sql = <<<EOF
                INSERT INTO ministore_orders
                (store_id, mmid, total_amount, subtotal, shipping_delivery_fee, delivery_fee, order_delivery_fee, discount, payer_name, payer_mobile,
                payer_phone, payer_email, remark, ip_address, user_agent, status, created_at, updated_at)
                VALUES
                (:store_id, :mmid, :total_amount, :subtotal, :shipping_delivery_fee, :delivery_fee, :order_delivery_fee, :discount, :payer_name,
                :payer_mobile, :payer_phone, :payer_email, :remark, :ip_address,:user_agent, :status, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves an order record by ID.
     *
     * @param int $order_id Order ID
     * @return array|null Order data if found, else null
     */
    public function getOrderById($order_id)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_orders WHERE id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Updates an existing order record.
     *
     * @param array $data Updated order data
     * @return void
     */
    public function updateOrder($data)
    {
        try {
            $sql = <<<EOF
                UPDATE ministore_orders
                SET store_id = :store_id, hash_code = :hash_code, total_amount = :total_amount, subtotal = :subtotal,
                delivery_fee = :delivery_fee, discount = :discount, discount_info = :discount_info, coupon = :coupon,
                payer_name = :payer_name, payer_mobile = :payer_mobile, payer_phone = :payer_phone, payer_email = :payer_email,
                remark = :remark, custom_fields = :custom_fields, system_rtnmsg = :system_rtnmsg, user_comment = :user_comment,
                ip_address = :ip_address, user_agent = :user_agent, status = :status, currency = :currency,
                picking_up_at = :picking_up_at, shipped_at = :shipped_at, deleted_at = :deleted_at, updated_at = CURRENT_TIMESTAMP()
                WHERE id = :id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Deletes an order record by ID.
     *
     * @param int $order_id Order ID
     * @return void
     */
    public function deleteOrder($order_id)
    {
        try {
            $sql = <<<EOF
                DELETE FROM ministore_orders WHERE id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Retrieves orders based on store ID and payer email.
     *
     * @param int $store_id Store ID
     * @param string $payer_email Payer email
     * @return array Orders data
     */
    public function getOrdersByStoreIdAndPayerEmail($store_id, $payer_email)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_orders WHERE store_id = :store_id AND payer_email = :payer_email
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->bindParam(':payer_email', $payer_email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Fetches orders based on status.
     *
     * @param int $status Status of the orders
     * @return array Fetched orders
     */
    public function getOrdersByStatus($status)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_orders
                WHERE status = :status
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Retrieves an order record by ID and store ID.
     *
     * @param int $order_id Order ID
     * @param int $store_id Store ID
     * @return array|null Order data if found, else null
     */
    public function getOrderByIdAndStoreId($order_id, $store_id)
    {
        try {
            $sql = <<<EOF
            SELECT * FROM ministore_orders WHERE id = :order_id AND store_id = :store_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Retrieves orders based on store ID and status.
     *
     * @param int $storeId Store ID
     * @param int $status Status of the orders
     * @return array Fetched orders
     */
    public function getStoreOrders($storeId, $status)
    {
        try {
            $sql = <<<EOF
            SELECT * FROM ministore_orders
            WHERE store_id = :store_id AND status = :status
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

}
