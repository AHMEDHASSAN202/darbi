<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Classes;

class Price
{
    private $bookingEntity;
    private $bookingPlugins;

    public function __construct($bookingEntity, $bookingPlugins = [])
    {
        $this->bookingEntity = $bookingEntity;
        $this->bookingPlugins = $bookingPlugins;
    }


    public function getInitialPriceSummary()
    {
        return [
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
