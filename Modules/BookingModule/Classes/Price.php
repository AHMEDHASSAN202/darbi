<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes;

use Carbon\Carbon;

class Price
{
    private $bookingEntity;
    private $bookingPlugins;
    private $startedAt;
    private $endedAt;

    public function __construct($bookingEntity, $bookingPlugins = [], $startedAt, $endedAt)
    {
        $this->bookingEntity = $bookingEntity;
        $this->bookingPlugins = $bookingPlugins;
        $this->startedAt = Carbon::parse($startedAt);
        $this->endedAt = Carbon::parse($endedAt);
    }


    public function getInitialPriceSummary()
    {
        return [
            'total_price'           => $this->getTotalPrice(),
            'total_discount'        => $this->getTotalDiscount(),
            'discount_value'        => $this->getDiscountValue(),
            'total_price_before_discount_before_vat' => $this->getTotalPriceBeforeDiscountBeforeVat(),
            'total_price_after_discount_before_vat'  => $this->getTotalPriceAfterDiscountBeforeVat(),
            'total_vat'             => $this->getTotalVat(),
            'vat_percentage'        => $this->getVatPercentage(),
            'total_price_after_discount_after_vat' => $this->getTotalPriceAfterDiscountAfterVat(),
            'darbi_percentage'      => $this->getDarbiPercentage(),
            'charge_cc'             => $this->getChargeCC(),
            'charge_shop'           => $this->getChargeShop(),
        ];
    }


    public function getPriceSummary()
    {
        return [
            'total_price'           => $this->getTotalPrice(),
            'total_discount'        => $this->getTotalDiscount(),
            'discount_value'        => $this->getDiscountValue(),
            'total_price_before_discount_before_vat' => $this->getTotalPriceBeforeDiscountBeforeVat(),
            'total_price_after_discount_before_vat'  => $this->getTotalPriceAfterDiscountBeforeVat(),
            'total_vat'             => $this->getTotalVat(),
            'vat_percentage'        => $this->getVatPercentage(),
            'total_price_after_discount_after_vat' => $this->getTotalPriceAfterDiscountAfterVat(),
            'darbi_percentage'      => $this->getDarbiPercentage(),
            'charge_cc'             => $this->getChargeCC(),
            'charge_shop'           => $this->getChargeShop(),
        ];
    }


    public function getTotalPrice()
    {
        $entity = $this->bookingEntity['price'];
        $pluginPrice = 0;
        foreach ($this->bookingPlugins as $bookingPlugin) {
            $pluginPrice += $bookingPlugin['price'];
        }
        $totalPriceUnit = $entity + $pluginPrice;
        return round($totalPriceUnit * $this->getUnitsCount(), 2);
    }


    private function getUnitsCount()
    {
        if ($this->bookingEntity['price_unit'] == 'day') {
            return $this->startedAt->diffInDays($this->endedAt);
        } else {
            return $this->startedAt->diffInHours($this->endedAt);
        }
    }


    public function getTotalDiscount()
    {

    }


    public function getDiscountValue()
    {

    }


    public function getTotalPriceBeforeDiscountBeforeVat()
    {

    }


    public function getTotalPriceAfterDiscountBeforeVat()
    {

    }


    public function getTotalVat()
    {

    }


    public function getVatPercentage()
    {

    }


    public function getTotalPriceAfterDiscountAfterVat()
    {

    }


    public function getDarbiPercentage()
    {

    }


    public function getChargeCC()
    {

    }


    public function getChargeShop()
    {

    }
}
