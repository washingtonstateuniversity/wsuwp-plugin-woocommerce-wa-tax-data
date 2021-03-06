<?php namespace WSUWP\Plugin\WA_Tax_Query;

class TaxQuery
{
    public function __construct()
    {

    }

    /*******************************
     *   Get inputs start date and end date
     *   Sanitize user inputs
     *   Call function to fetch data from the DB
     *   *** Maybe process here in a loop or process on display side.***
    ********************************/
    public static function processTaxData($StartDate, $EndDate)
    {
        $StartDate = sanitize_text_field($StartDate);
        $EndDate = sanitize_text_field($EndDate);
        $TaxData = fetchTaxData($StartDate, $EndDate);
        foreach ()
    }

    /*************************************
     *  Use wpdb object to rund SQL query to pull tax data
     *  Return tax data to calling object
     *  Returns customer address information used to calclulate taxes along with state tax codes identifying tax zones to set amounts.
     *************************************/
    public static function fetchTaxData($StartDate, $EndDate)
    {        
        global $wpdb;
        $strQString = "SELECT p.post_id, MAX(CASE WHEN pm.meta_key = '_date_completed' THEN FROM_UNIXTIME(pm.meta_value) END) as ShipDate, MAX(CASE WHEN pm.meta_key = '_shipping_first_name' THEN pm.meta_value END) as CustomerFName, ";
        $strQString .= "MAX(CASE WHEN pm.meta_key = '_shipping_last_name' THEN pm.meta_value END) as CustomerLName, MAX(CASE WHEN pm.meta_key = '_shipping_company' THEN pm.meta_value END) as CompanyName, MAX(CASE WHEN pm.meta_key = '_shipping_address_1' THEN pm.meta_value END) as AddressLine1, ";
        $strQString .= "MAX(CASE WHEN pm.meta_key = '_shipping_address_2' THEN pm.meta_value END) as AddressLine2, MAX(CASE WHEN pm.meta_key = '_shipping_city' THEN pm.meta_value END) as City, MAX(CASE WHEN pm.meta_key = '_shipping_state' THEN pm.meta_value END) as State, ";
        $strQString .= "MAX(CASE WHEN pm.meta_key = '_shipping_postcode' THEN pm.meta_value END) as Zip, MAX(CASE WHEN pm.meta_key = '_order_tax' THEN pm.meta_value END) as Tax, MAX(CASE WHEN pm.meta_key = '_order_shipping_tax' THEN pm.meta_value END) as ShippingTax ";
        $strQString .= "FROM wsuwp.wp_1175_postmeta p JOIN wsuwp.wp_1175_postmeta pm ON p.post_id = pm.post_id WHERE p.post_id IN(SELECT pp.ID FROM wsuwp.wp_1175_posts pp WHERE pp.post_type = 'shop_order' AND pp.post_status = 'wc-completed') ";
        $strQString .= "AND p.meta_key = '_date_completed' AND p.meta_value BETWEEN UNIX_TIMESTAMP(@$StartDate) AND UNIX_TIMESTAMP($EndDate) GROUP BY p.post_id";

        return $wpdb->get_results($strQString);
    }

    // deciding if this is needed.
    public static init
    {
         
    }
}
// deciding if this is needed.
(new TaxQuery)->init();
