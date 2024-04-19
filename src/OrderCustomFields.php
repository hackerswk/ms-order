<?php
/**
 * Order custom fields class
 *
 * @author      Stanley Sie <swookon@gmail.com>
 * @access      public
 * @version     Release: 1.0
 */

namespace Stanleysie\MsOrder;

use \PDO as PDO;
use \PDOException as PDOException;

class OrderCustomFields
{
    /** @var PDO Database connection */
    private $conn;

    /**
     * OrderCustomFields constructor.
     * @param PDO $conn Database connection
     */
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Create a new custom field entry for an order.
     *
     * @param int $orderId Order ID
     * @param int $customFieldsId Custom fields ID
     * @param string $customFieldName Custom field name
     * @param string $customAnswer Custom field answer
     * @return bool True on success, False on failure
     */
    public function createCustomField($orderId, $customFieldsId, $customFieldName, $customAnswer)
    {
        try {
            $sql = <<<EOF
            INSERT INTO order_custom_fields (order_id, custom_fields_id, custom_field_name, custom_answer)
            VALUES (:order_id, :custom_fields_id, :custom_field_name, :custom_answer)
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':custom_fields_id', $customFieldsId, PDO::PARAM_INT);
            $stmt->bindParam(':custom_field_name', $customFieldName, PDO::PARAM_STR);
            $stmt->bindParam(':custom_answer', $customAnswer, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Update the custom answer for a specific custom field in an order.
     *
     * @param int $orderId Order ID
     * @param int $customFieldsId Custom fields ID
     * @param string $customAnswer Custom field answer
     * @return bool True on success, False on failure
     */
    public function updateCustomAnswer($orderId, $customFieldsId, $customAnswer)
    {
        try {
            $sql = <<<EOF
            UPDATE order_custom_fields
            SET custom_answer = :custom_answer
            WHERE order_id = :order_id AND custom_fields_id = :custom_fields_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':custom_fields_id', $customFieldsId, PDO::PARAM_INT);
            $stmt->bindParam(':custom_answer', $customAnswer, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retrieve custom field information for a specific order.
     *
     * @param int $orderId Order ID
     * @return array Array of custom field data for the specified order
     */
    public function getCustomFieldsForOrder($orderId)
    {
        try {
            $sql = <<<EOF
            SELECT * FROM order_custom_fields WHERE order_id = :order_id
EOF;

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

}
