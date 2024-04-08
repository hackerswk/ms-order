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
     * @return void
     */
    public function createOrderPayment($data)
    {
        try {
            $sql = <<<EOF
                INSERT INTO ministore_order_payment
                (order_id, vendor_id, payment_method, payment_no, payment_date, extra_data, status, created_at, updated_at)
                VALUES
                (:order_id, :vendor_id, :payment_method, :payment_no, :payment_date, :extra_data, :status, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
     * @return void
     */
    public function updateOrderPayment($data)
    {
        try {
            $sql = <<<EOF
                UPDATE ministore_order_payment
                SET vendor_id = :vendor_id, payment_method = :payment_method, payment_no = :payment_no, payment_date = :payment_date,
                extra_data = :extra_data, status = :status, updated_at = CURRENT_TIMESTAMP()
                WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
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
}
