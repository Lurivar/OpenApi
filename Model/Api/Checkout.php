<?php

namespace OpenApi\Model\Api;

use OpenApi\Annotations as OA;
use Thelia\Model\Order;
use OpenApi\Constraint as Constraint;

/**
 * Class Checkout
 * @package OpenApi\Model\Api
 * @OA\Schema(
 *     schema="Checkout",
 *     title="Checkout",
 *     description="Checkout model",
 * )
 */
class Checkout extends BaseApiModel
{

    protected $isComplete = false;

    /**
     * @var integer
     * @OA\Property(
     *    type="integer",
     *    description="id of the delivery module used by this checkout"
     * )
     */
    protected $deliveryModuleId;

    /**
     * @var integer
     * @OA\Property(
     *    type="integer",
     *    description="id of the payment module used by this checkout"
     * )
     */
    protected $paymentModuleId;

    /**
     * @var integer
     * @OA\Property(
     *    type="integer"
     * )
     */
    protected $billingAddressId;

    /**
     * @var integer
     * @OA\Property(
     *    type="integer"
     * )
     */
    protected $deliveryAddressId;

    /**
     * @var Address
     * @OA\Property(
     *     ref="#/components/schemas/Address"
     * )
     */
    protected $pickupAddress;

    public function createFromData($json)
    {
        parent::createFromData($json);

        $data = json_decode($json, true);

        if (!null === $data['pickupAddress']) {
            $this->pickupAddress = (new Address())
                ->createFromData($data['pickupAddress']);
        }

        return $this;
    }

    public function createFormOrder(Order $order)
    {
        $this->setDeliveryAddressId($order->getChoosenDeliveryAddress());
        $this->setBillingAddressId($order->getChoosenInvoiceAddress());

        $this->setDeliveryModuleId($order->getDeliveryModuleId())
            ->setPaymentModuleId($order->getPaymentModuleId());

        return $this;
    }

    /**
     *  @OA\Property(
     *     property="isComplete",
     *     type="boolean"
     *  )
     * @return boolean
     */
    public function getIsComplete()
    {
        if (null === $this->getDeliveryModuleId()) {
            return false;
        }

        if (null === $this->getDeliveryAddressId()) {
            return false;
        }

        if (null === $this->getBillingAddressId()) {
            return false;
        }

        if (null === $this->getPaymentModuleId()) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    public function getDeliveryModuleId()
    {
        return $this->deliveryModuleId;
    }

    /**
     * @param int $deliveryModuleId
     * @return Checkout
     */
    public function setDeliveryModuleId($deliveryModuleId)
    {
        $this->deliveryModuleId = $deliveryModuleId;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentModuleId()
    {
        return $this->paymentModuleId;
    }

    /**
     * @param int $paymentModuleId
     * @return Checkout
     */
    public function setPaymentModuleId($paymentModuleId)
    {
        $this->paymentModuleId = $paymentModuleId;
        return $this;
    }

    /**
     * @return int
     */
    public function getBillingAddressId()
    {
        return $this->billingAddressId;
    }

    /**
     * @param int $billingAddressId
     * @return Checkout
     */
    public function setBillingAddressId($billingAddressId)
    {
        $this->billingAddressId = $billingAddressId;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryAddressId()
    {
        return $this->deliveryAddressId;
    }

    /**
     * @param int $deliveryAddressId
     * @return Checkout
     */
    public function setDeliveryAddressId($deliveryAddressId)
    {
        $this->deliveryAddressId = $deliveryAddressId;
        return $this;
    }

    /**
     * @return Address
     */
    public function getPickupAddress()
    {
        return $this->pickupAddress;
    }

    /**
     * @param Address $pickupAddress
     * @return Checkout
     */
    public function setPickupAddress($pickupAddress)
    {
        $this->pickupAddress = $pickupAddress;
        return $this;
    }
}