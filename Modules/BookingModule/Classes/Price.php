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
    private $vendor;

    public function __construct($bookingEntity, $bookingPlugins = [], $startedAt, $endedAt, $vendor)
    {
        $this->bookingEntity = $bookingEntity;
        $this->bookingPlugins = $bookingPlugins;
        $this->startedAt = Carbon::parse($startedAt);
        $this->endedAt = Carbon::parse($endedAt);
        $this->vendor = $vendor;
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
            'vendor_price'          => $this->getVendorPrice(),
            'darbi_price'           => $this->getDarbiPrice()
        ];
    }


    public function getTotalPrice()
    {
        $entity = $this->bookingEntity['price'];
        $pluginPrice = 0;
        foreach ($this->bookingPlugins as $bookingPlugin) {
            $pluginPrice += $bookingPlugin['price'];
        }
        $totalEntityPrice = ($entity * $this->getUnitsCount()) + $pluginPrice;
        return round($totalEntityPrice, 2);
    }


    private function getUnitsCount()
    {
        if ($this->bookingEntity['price_unit'] == 'day') {
            $diffInUnits = $this->startedAt->diffInDays($this->endedAt);
        } else {
            $diffInUnits = $this->startedAt->diffInHours($this->endedAt);
        }

        if ($diffInUnits === 0) {
            return 1;
        }

        return $diffInUnits;
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
        $darbiPercentage = @$this->vendor['darbi_percentage'];

        if (!$darbiPercentage) {
            $darbiPercentage = getOption('darbi_percentage', 20);
        }

        return $darbiPercentage;
    }


    public function getChargeCC()
    {

    }


    public function getChargeShop()
    {

    }


    public function getVendorPrice()
    {
        $darbiPrice = $this->getDarbiPrice();
        $totalPrice = $this->getTotalPrice();

        return round($totalPrice - $darbiPrice, 2);
    }


    public function getDarbiPrice()
    {
        $darbiPercentage = $this->getDarbiPercentage();
        $totalPrice = $this->getTotalPrice();

        return round($totalPrice * ($darbiPercentage / 100), 2);
    }
}
