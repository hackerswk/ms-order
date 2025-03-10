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
     * Creates a new order product record. (Bulk insert)
     *
     * @param array $data List of order products (each item is an associative array).
     * @return bool Returns true on success, false on failure.
     */
    public function createOrderProducts(array $data): bool
    {
        try {
            // 先準備列名
        $columns = [
            'order_id', 'product_id', 'specification_id', 'main_spec_id', 'sub_spec_id', 'title',
            'image', 'price', 'quantity', 'detail', 'google_category', 'primary_spec',
            'sub_spec', 'conditions', 'availability', 'link', 'created_at', 'updated_at'
        ];

        // 構建 SQL 的欄位部分
        $sql = "INSERT INTO ministore_order_products (" . implode(", ", $columns) . ") VALUES ";

        $placeholders = [];
        $params = [];
        $now = date('Y-m-d H:i:s');

        foreach ($data as $index => $product) {
            $rowPlaceholders = [];

            foreach ($columns as $column) {
                // 處理時間戳欄位
                if ($column === 'created_at' || $column === 'updated_at') {
                    $paramName = ":{$column}{$index}";
                    $params[$paramName] = $now;
                    $rowPlaceholders[] = $paramName;
                }
                // 處理其他欄位
                else {
                    $paramName = ":{$column}{$index}";
                    $params[$paramName] = $product[$column] ?? null;
                    $rowPlaceholders[] = $paramName;
                }
            }

            $placeholders[] = "(" . implode(", ", $rowPlaceholders) . ")";
        }

        $sql .= implode(", ", $placeholders);

        $stmt = $this->conn->prepare($sql);

        // 綁定所有參數
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Product Bulk Insert Error: ' . $e->getMessage());
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
