<?php
/**
 * Mini store order payment class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

/**
 * Class MiniStoreOrderPayment
 *
 * This class handles CRUD operations for the `ministore_order_payment` table.
 */
class MiniStoreOrderPayment
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * MiniStoreOrderPayment constructor.
     *
     * @param PDO $conn Database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Creates a new order payment record.
     *
     * @param array $data Order payment data
     * @return bool
     */
    public function createOrderPayment(array $data):bool
    {
        try {
            $sql = <<<SQL
                INSERT INTO ministore_order_payment
                (order_id, vendor_id, payment_method, created_at, updated_at)
                VALUES
                (:order_id, :vendor_id, :payment_method, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
SQL;

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Create Order Payment Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves order payment record by order ID.
     *
     * @param int $order_id Order ID
     * @return array|null Order payment data if found, else null
     */
    public function getOrderPayment($order_id)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_payment WHERE order_id = :order_id
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
     * Updates an existing order payment record.
     *
     * @param array $data Updated order payment data
     * @return bool
     */
    public function updateOrderPayment($data)
    {
        try {
            $sql = <<<SQL
                UPDATE ministore_order_payment
                SET payment_no = :payment_no, payment_date = :payment_date, status = :status
                WHERE order_id = :order_id
SQL;
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Update Order Payment Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Deletes an order payment record by order ID.
     *
     * @param int $order_id Order ID
     * @return void
     */
    public function deleteOrderPayment($order_id)
    {
        try {
            $sql = <<<EOF
                DELETE FROM ministore_order_payment WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fetches payments based on status.
     *
     * @param int $status Status of the payments
     * @return array Fetched payments
     */
    public function getPaymentsByStatus($status)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_payment
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
     * Retrieves payments based on order ID and status.
     *
     * @param int $order_id Order ID
     * @param int $status Status of the payments
     * @return array Fetched payments
     */
    public function getPaymentsByOrderIdAndStatus($order_id, $status)
    {
        try {
            $sql = <<<EOF
            SELECT * FROM ministore_order_payment
            WHERE order_id = :order_id AND status = :status
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

}
