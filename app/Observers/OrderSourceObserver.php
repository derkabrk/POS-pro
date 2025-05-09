<?php
namespace App\Observers;

use App\Models\OrderSource;
use Modules\Business\App\Http\Controllers\OrderSourceController;

class OrderSourceObserver
{
    /**
     * Handle the OrderSource "created" event.
     */
    public function created(OrderSource $orderSource)
    {
        // Call the registerWebhook method
        $controller = new OrderSourceController();
        $controller->registerWebhook($orderSource);
    }
}