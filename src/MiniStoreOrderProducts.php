<?php
/**
 * Mini store order products class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

/**
 * Class MiniStoreOrderProducts
 *
 * This class handles CRUD operations for the `ministore_order_products` table.
 */
class MiniStoreOrderProducts
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * MiniStoreOrderProducts constructor.
     *
     * @param PDO $conn Database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Creates a new order product record.
     *
     * @param array $data Order product data.
     * @return bool Returns false on failure, or true on success.
     */
    public function createOrderProduct(array $data): bool
    {
        try {
            $sql = <<<SQL
                INSERT INTO ministore_order_products (
                    order_id, product_id, specification_id, main_spec_id, sub_spec_id, title, image, price,
                    quantity, detail, google_category, primary_spec, sub_spec, conditions, availability, link,
                    created_at, updated_at
                ) VALUES (
                    :order_id, :product_id, :specification_id, :main_spec_id, :sub_spec_id, :title, :image, :price,
                    :quantity, :detail, :google_category, :primary_spec, :sub_spec, :conditions, :availability, :link,
                    CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP()
                )
SQL;

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log('DB Insert Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retrieves order product records by order ID.
     *
     * @param int $order_id Order ID
     * @return array|null Order product data if found, else null
     */
    public function getOrderProducts($order_id)
    {
        try {
            $sql = <<<EOF
                SELECT * FROM ministore_order_products WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Updates an existing order product record.
     *
     * @param array $data Updated order product data
     * @return void
     */
    public function updateOrderProduct($data)
    {
        try {
            $sql = <<<EOF
                UPDATE ministore_order_products
                SET product_id = :product_id, specification_id = :specification_id, title = :title, image = :image, price = :price,
                quantity = :quantity, google_category = :google_category, primary_spec = :primary_spec, sub_spec = :sub_spec,
                conditions = :conditions, availability = :availability, link = :link, updated_at = CURRENT_TIMESTAMP()
                WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Deletes order product records by order ID.
     *
     * @param int $order_id Order ID
     * @return void
     */
    public function deleteOrderProducts($order_id)
    {
        try {
            $sql = <<<EOF
                DELETE FROM ministore_order_products WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
