<?php
namespace Modules\Business\App\Http\Controllers;

use App\Models\DynamicApiHeader;
use Illuminate\Http\Request;

class SomeController extends Controller
{
    public function trackEvent(Request $request)
    {
        // Retrieve the Facebook Pixel header
        $facebookPixel = DynamicApiHeader::where('name', 'Facebook Pixel')->where('status', true)->first();

        if ($facebookPixel) {
            // Example: Send a custom event to Facebook Pixel
            $pixelId = $facebookPixel->api_key;

            // Use the Pixel ID in your logic
            // Example: Log the Pixel ID
            \Log::info("Facebook Pixel ID: {$pixelId}");
        }

        return response()->json(['message' => 'Event tracked successfully.']);
    }
}

/*<script>
    window.apiHeaders = @json($apiHeaders);
</script>*/

/*if (window.apiHeaders) {
    window.apiHeaders.forEach(header => {
        if (header.name === 'Facebook Pixel') {
            console.log('Facebook Pixel ID:', header.api_key);
        }
    });
}*/