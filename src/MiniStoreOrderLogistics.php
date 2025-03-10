<?php
/**
 * Mini store order logistics class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

/**
 * Class MiniStoreOrderLogistics
 *
 * This class handles CRUD operations for the `ministore_order_logistics` table.
 */
class MiniStoreOrderLogistics
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * MiniStoreOrderLogistics constructor.
     *
     * @param PDO $conn Database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Creates a new order logistics record.
     *
     * @param array $data Order logistics data
     * @return bool
     */
    public function createOrderLogistics($data)
    {
        try {
            $sql = <<<SQL
                INSERT INTO ministore_order_logistics
                (order_id, vendor_logistics, logistics_method, logistics_no, logistics_type,
                recipient_name, recipient_mobile, recipient_zip_code, recipient_address, sender_name,
                sender_mobile, sender_phone, sender_zip_code, sender_address, cvs_id, cvs_name, cvs_address,
                cvs_delivery_type, home_temperature, home_specification, home_pickup_time, home_delivery_time,
                cash_on_delivery)
                VALUES
                (:order_id, :vendor_logistics, :logistics_method, :logistics_no, :logistics_type,
                :recipient_name, :recipient_mobile, :recipient_zip_code, :recipient_address, :sender_name,
                :sender_mobile, :sender_phone, :sender_zip_code, :sender_address, :cvs_id, :cvs_name, :cvs_address,
                :cvs_delivery_type, :home_temperature, :home_specification, :home_pickup_time, :home_delivery_time,
                :cash_on_delivery)
SQL;

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Create Order Logistics Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves order logistics record by order ID.
     *
     * @param int $order_id Order ID
     * @return array|null Order logistics data if found, else null
     */
    public function getOrderLogistics($order_id)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_logistics WHERE order_id = :order_id
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
     * Updates an existing order logistics record.
     *
     * @param array $data Updated order logistics data
     * @return void
     */
    public function updateOrderLogistics($data)
    {
        try {
            $sql = <<<EOF
                UPDATE ministore_order_logistics
                SET vendor_logistics = :vendor_logistics, logistics_method = :logistics_method, logistics_no = :logistics_no,
                logistics_type = :logistics_type, delivery_date = :delivery_date, delivery_no = :delivery_no,
                recipient_name = :recipient_name, recipient_mobile = :recipient_mobile, recipient_phone = :recipient_phone,
                recipient_zip_code = :recipient_zip_code, recipient_address = :recipient_address, sender_name = :sender_name,
                sender_mobile = :sender_mobile, sender_phone = :sender_phone, sender_zip_code = :sender_zip_code,
                sender_address = :sender_address, cvs_id = :cvs_id, cvs_name = :cvs_name, cvs_address = :cvs_address,
                cvs_delivery_type = :cvs_delivery_type, home_temperature = :home_temperature, home_distance = :home_distance,
                home_specification = :home_specification, home_pickup_time = :home_pickup_time, home_delivery_time = :home_delivery_time,
                extra_data = :extra_data, cash_on_delivery = :cash_on_delivery, status = :status, updated_at = CURRENT_TIMESTAMP()
                WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Deletes an order logistics record by order ID.
     *
     * @param int $order_id Order ID
     * @return void
     */
    public function deleteOrderLogistics($order_id)
    {
        try {
            $sql = <<<EOF
                DELETE FROM ministore_order_logistics WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fetches logistics information based on status.
     *
     * @param int $status Status of the logistics
     * @return array Fetched logistics information
     */
    public function getLogisticsByStatus($status)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_logistics
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
     * Retrieves logistics information based on order ID and status.
     *
     * @param int $order_id Order ID
     * @param int $status Status of the logistics
     * @return array Fetched logistics information
     */
    public function getLogisticsByOrderIdAndStatus($order_id, $status)
    {
        try {
            $sql = <<<EOF
            SELECT * FROM ministore_order_logistics
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
