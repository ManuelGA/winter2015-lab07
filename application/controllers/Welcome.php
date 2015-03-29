<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
	$files = directory_map(DATAPATH);        
        
        foreach ($files as $file)
        {
            
           $extension = '.xml';
           
            if(substr_compare($file,$extension,strlen($file)-strlen($extension),
                 strlen($extension)) === 0 && $file !== 'menu.xml')
             {
                 // prepare the order file name minus extension
                 $order_file = $file;
                 $order_file = substr($order_file,0,strlen($order_file)-4);
                 // add the order to array of orders
                 $order_files[] = $order_file;
             }
         }
 
         // build a list of orders
         $orders = array();
         foreach($order_files as $order_file)
         {
             // build the order
             $order = new stdclass();
             $order->name = $order_file;
             $order->path   = 'welcome/order/'.$order_file;
 
             // add the order to array of orders
             $orders[] = $order;
         }
         
         $this->data['orders'] = $orders;

	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
        $receipttop = $this->orders->getOrderData($filename);
        
        $this->data['ordernum'] = $receipttop['ordernum'];
        $this->data['customer'] = $receipttop['customer'];
        $this->data['order-type'] = $receipttop['order-type'];
        if (empty($receipttop['special']))
        {
            $this->data['special'] = ' - ';
        }
        else
        {
            $this->data['special'] = $receipttop['special'];
        }
        
        
        $burgers = $this->orders->getBurgers($filename);
        $totalorder = 0;
        
        for ($i = 0; $i < count($burgers); $i++)
        {
            $burgers[$i]['price'] = $this->orders->getBurgerPrice($burgers[$i]);
            $totalorder += $burgers[$i]['price'];
            
            if (isset( $burgers[$i]['patty']))
            {
                $burgers[$i]['patty'] = $this->menu->getPatty($burgers[$i]['patty'])->name;
            }
            else
            {
                 $burgers[$i]['patty'] = ' - ';
            }
            
            if (isset( $burgers[$i]['top-cheese']))
            {
                $burgers[$i]['top-cheese'] = $this->menu->getCheese($burgers[$i]['top-cheese'])->name;
            }
            else
            {
                 $burgers[$i]['top-cheese'] = ' - ';
            }
            if (isset( $burgers[$i]['bottom-cheese']))
            {
                $burgers[$i]['bottom-cheese'] = $this->menu->getCheese($burgers[$i]['bottom-cheese'])->name;
            }
            else
            {
                 $burgers[$i]['bottom-cheese'] = ' - ';
            }
            
            if (empty($burgers[$i]['instructions']))
            {
                $burgers[$i]['instructions'] = ' - ';
            }
        }	
        
	$this->data['burgers'] = $burgers;
        $this->data['total'] = $totalorder;
        $this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
