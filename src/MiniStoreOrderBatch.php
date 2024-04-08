<?php
/**
 * Mini store order batch class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

/**
 * Class MiniStoreOrderBatch
 *
 * This class handles CRUD operations for the `ministore_order_batch` table.
 */
class MiniStoreOrderBatch
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * MiniStoreOrderBatch constructor.
     *
     * @param PDO $conn Database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Creates a new order batch.
     *
     * @param int $order_id Order ID
     * @param string $batch_id Batch ID
     * @return void
     */
    public function createOrderBatch($order_id, $batch_id)
    {
        try {
            $sql = <<<EOF
                INSERT INTO ministore_order_batch (order_id, batch_id)
                VALUES (:order_id, :batch_id)
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->bindParam(':batch_id', $batch_id, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Retrieves an order batch by order ID.
     *
     * @param int $order_id Order ID
     * @return array Array of order batch data
     */
    public function getOrderBatch($order_id)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_batch WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Updates an order batch.
     *
     * @param int $order_id Order ID
     * @param string $batch_id Batch ID
     * @return void
     */
    public function updateOrderBatch($order_id, $batch_id)
    {
        try {
            $sql = <<<EOF
                UPDATE ministore_order_batch SET batch_id = :batch_id WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':batch_id', $batch_id, PDO::PARAM_STR);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Deletes an order batch by order ID.
     *
     * @param int $order_id Order ID
     * @return void
     */
    public function deleteOrderBatch($order_id)
    {
        try {
            $sql = <<<EOF
                DELETE FROM ministore_order_batch WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}
